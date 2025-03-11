<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\App\TaskRequest;
use App\Jobs\NewTaskCreatedJob;
use App\Models\Task;
use App\Models\User;
use App\Notifications\NewTaskCreatedNotification;
use App\Services\TaskService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService)
    {
        parent::__construct();
    }

    //destroy - DELETE
    public function destroy(Task $task): RedirectResponse
    {
        try {
            $task->delete();

            Log::info($this->className, [__FUNCTION__ => $task->id]);
            return redirect()->back()->withSuccess(__('task.tasks_delete_success_message'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('task.tasks_delete_error_message') . __('task.tasks_delete_error_foreign_key')]);

                return redirect()->back()->withError(__('task.tasks_delete_error_message') . __('task.tasks_delete_error_foreign_key'))->withInput();
            }

            Log::error($this->className, [
                __FUNCTION__ => __('task.tasks_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $task->id,
            ]);

            return redirect()->back()->withError(__('task.tasks_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //update - PUT
    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        try {
            $data = $request->validated();

            if (! empty($data['occurred_at'])) {
                $data['occurred_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $data['occurred_at'])->format('Y-m-d H:i:s');
            }

            $task->update($data);

            Log::info($this->className, [__FUNCTION__ => $task->id]);
            return redirect()->back()->withSuccess(__('task.tasks_update_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task.tasks_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withError(__('task.tasks_update_error_message') . $e->getMessage())->withInput();
        }
    }

    //edit - GET
    public function edit(Task $task): RedirectResponse|View
    {
        $projectTitle = session('projectTitle') ?? '';
        $projectId = session('projectId') ?? 0;

        $task = Task::getTranslations($task);

        $scopes = $this->taskService->getScopes($projectId);
        $taskIcons = $this->taskService->getTaskIcons();

        Log::info($this->className, [__FUNCTION__ => $task->id]);

        if ($task->locale != session('locale')) {
            return redirect()->route('tasks.show', ['task' => $task->id])
                ->withWarning(__('config.not_original_locale'));
        }

        return view('tasks.edit', [
            'projectTitle' => $projectTitle,
            'task' => $task,
            'isEditMode' => true,
            'scopes' => $scopes,
            'taskIcons' => $taskIcons,
        ]);
    }

    //show - GET
    public function show(Task $task): View
    {
        $projectTitle = session('projectTitle') ?? '';
        $projectId = session('projectId') ?? 0;

        $task = Task::getTranslations($task);

        $scopes = $this->taskService->getScopes($projectId);
        $taskIcons = $this->taskService->getTaskIcons();

        Log::info($this->className, [__FUNCTION__ => $task->id]);

        return view('tasks.edit', [
            'projectTitle' => $projectTitle,
            'task' => $task,
            'isEditMode' => false,
            'scopes' => $scopes,
            'taskIcons' => $taskIcons,
        ]);
    }

    //store - POST
    public function store(TaskRequest $request): RedirectResponse
    {
        $routeLink = session('return_to_create_origin', route('tasks.index'));

        try {
            $data = $request->validated();

            if (! empty($data['occurred_at'])) {
                $data['occurred_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $data['occurred_at'])->format('Y-m-d H:i:s');
            }

            $task = Task::create($data);

            Log::info($this->className, [__FUNCTION__ => __('task.tasks_create_success_message') . '(' . $task->id . ')']);

            //details for job entries to send out emails
            $details = [
                'projectId' => session('projectId'),
                'taskId' => $task->id,
                'taskTitle' => $task->title,
            ];

            $users = User::where('is_admin', false)->where('id', '!=', $request->user()->id)->get();

            //
            //inserts job entries into db-table jobs
            //NewTaskCreatedJob::dispatch($users, $details);
            //

            //show latest task immediately
            cache()->forget('teaserTask');

            return redirect($routeLink)->withSuccess(__('task.tasks_create_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task.tasks_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'description', 'is_featured', 'icon', 'prefix', 'scope_id']),
            ]);

            return redirect()->back()->withError(__('task.tasks_create_error_message'))->withInput();
        }
    }

    //create - GET
    public function create(): View
    {
        $projectTitle = session('projectTitle') ?? '';
        $projectId = session('projectId') ?? 0;

        $scopes = $this->taskService->getScopes($projectId);
        $taskIcons = $this->taskService->getTaskIcons();

        Log::info($this->className, [__FUNCTION__]);

        return view('tasks.create', [
            'projectTitle' => $projectTitle,
            'scopes' => $scopes,
            'taskIcons' => $taskIcons,
        ]);
    }

    //index - GET
    public function index(Request $request): View
    {
        $projectTitle = session('projectTitle') ?? '';
        $projectId = session('projectId') ?? 0;
        $locale = app()->getLocale();
        $titleSearch = $request->input('title') ?? null;
        $scopeId = $request->input('scope_id') ?? null;

        $tasks = Task::whereHas('scope', function ($query) use ($projectId) {
            $query->where('project_id', $projectId)->select(DB::raw(1));
        })
            ->when($scopeId, function ($query) use ($scopeId) {
                $query->where('scope_id', $scopeId);
            })
            ->when($titleSearch, function ($query) use ($locale, $titleSearch) {
                $query->where(function ($query) use ($locale, $titleSearch) {
                    $query->where('title', 'like', '%' . $titleSearch . '%')
                        ->where('locale', $locale)
                        ->orWhereHas('translations', function ($query) use ($locale, $titleSearch) {
                            $query->where('locale', $locale)
                                ->where('field_name', 'title')
                                ->where('value', 'like', '%' . $titleSearch . '%')->select(DB::raw(1));
                        });
                });
            })
            ->orderByDesc('updated_at')
            ->orderBy('title')
            ->orderByDesc('id')
            ->paginate(8)->appends($request->query());

        $scopes = $this->taskService->getScopes($projectId);

        Log::info($this->className, [__FUNCTION__]);

        return view('tasks.index', [
            'projectTitle' => $projectTitle,
            'tasks' => $tasks,
            'scopes' => $scopes,
        ]);
    }
}
