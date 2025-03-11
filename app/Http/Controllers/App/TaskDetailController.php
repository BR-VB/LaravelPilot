<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\App\TaskDetailRequest;
use App\Models\Task;
use App\Models\TaskDetail;
use App\Services\TaskDetailService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TaskDetailController extends Controller
{
    public function __construct(protected TaskDetailService $taskDetailService)
    {
        parent::__construct();
    }

    //destroy - DELETE
    public function destroy(TaskDetail $task_detail): RedirectResponse
    {
        try {
            $task_detail->delete();

            Log::info($this->className, [__FUNCTION__ => $task_detail->id]);
            return redirect()->back()->withSuccess(__('task_detail.task_details_delete_success_message'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('task_detail.task_details_delete_error_message') . __('task_detail.task_details_delete_error_foreign_key')]);

                return redirect()->back()->withError(__('task_detail.task_details_delete_error_message') . __('task_detail.task_details_delete_error_foreign_key'))->withInput();
            }

            Log::error($this->className, [
                __FUNCTION__ => __('task_detail.task_details_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $task_detail->id,
            ]);

            return redirect()->back()->withError(__('task_detail.task_details_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //update - PUT
    public function update(TaskDetailRequest $request, TaskDetail $task_detail): RedirectResponse
    {
        try {
            $data = $request->validated();


            if (! empty($data['occurred_at'])) {
                $data['occurred_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $data['occurred_at'])->format('Y-m-d H:i:s');
            }

            $task_detail->update($data);

            Log::info($this->className, [__FUNCTION__ => $task_detail->id]);
            return redirect()->back()->withSuccess(__('task_detail.task_details_update_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task_detail.task_details_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withError(__('task_detail.task_details_update_error_message') . $e->getMessage())->withInput();
        }
    }

    //edit - GET
    public function edit(TaskDetail $task_detail): RedirectResponse|View
    {
        $projectTitle = session('projectTitle') ?? '';
        $task_detail = TaskDetail::getTranslations($task_detail);

        $task = Task::where('id', $task_detail->task_id)->get();
        $task = Task::getTranslations($task);
        $tasks = $task->pluck('title', 'id');

        $task_detail_types = $this->taskDetailService->getTaskDetailTypes();

        Log::info($this->className, [__FUNCTION__ => $task_detail->id]);

        if ($task_detail->locale != session('locale', app()->getLocale())) {
            return redirect()->route('task_details.show', ['task' => $task_detail->id])
                ->withWarning(__('config.not_original_locale'));
        }

        return view('task_details.edit', [
            'projectTitle' => $projectTitle,
            'task_detail' => $task_detail,
            'isEditMode' => true,
            'tasks' => $tasks,
            'task_detail_types' => $task_detail_types,
        ]);
    }

    //show - GET
    public function show(TaskDetail $task_detail): View
    {
        $projectTitle = session('projectTitle') ?? '';
        $task_detail = TaskDetail::getTranslations($task_detail);

        $task = Task::where('id', $task_detail->task_id)->get();
        $task = Task::getTranslations($task);
        $tasks = $task->pluck('title', 'id');

        $task_detail_types = $this->taskDetailService->getTaskDetailTypes();

        Log::info($this->className, [__FUNCTION__ => $task_detail->id]);

        return view('task_details.edit', [
            'projectTitle' => $projectTitle,
            'task_detail' => $task_detail,
            'isEditMode' => false,
            'tasks' => $tasks,
            'task_detail_types' => $task_detail_types,
        ]);
    }

    //store - POST
    public function store(TaskDetailRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            if (! empty($data['occurred_at'])) {
                $data['occurred_at'] = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i:s', $data['occurred_at'])->format('Y-m-d H:i:s');
            }

            $task_detail = TaskDetail::create($data);

            Log::info($this->className, [__FUNCTION__ => __('task_detail.task_details_create_success_message') . '(' . $task_detail->id . ')']);
            return redirect()->route('task_details.index', ['taskId' => $task_detail->task_id] + request()->query())->withSuccess(__('task_detail.task_details_create_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task_detail.task_details_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['description', 'task_detail_type_id', 'task_id']),
            ]);

            return redirect()->back()->withError(__('task_detail.task_details_create_error_message'))->withInput();
        }
    }

    //create - GET
    public function create(Request $request): View
    {
        $taskId = $request->input('taskId') ? $request->input('taskId') : null;

        if (is_null($taskId)) {
            Log::error($this->className, [__FUNCTION__ => __('task_detail.task_details_task_id_error') . '(' . $taskId . ')']);
            return redirect()->back()->withError(__('task_detail.task_details_task_id_error'))->withInput();
        }

        $task = collect([Task::where('id', $taskId)->first()]);
        $task = Task::getTranslations($task);
        $tasks = $task->pluck('title', 'id');

        $task_detail_types = $this->taskDetailService->getTaskDetailTypes();

        Log::info($this->className, [__FUNCTION__]);

        return view('task_details.create', [
            'projectTitle' => session('projectTitle') ?? '',
            'tasks' => $tasks,
            'taskId' => $taskId,
            'task_detail_types' => $task_detail_types,
        ]);
    }

    //index - GET
    public function index(Request $request): View
    {
        $projectId = session('projectId') ?? 0;
        $projectTitle = session('projectTitle') ?? '';
        $locale = app()->getLocale();
        $page = $request->input('page') ?? 1;

        $task_title = $request->input('task_title') ?? null;
        $taskId = $request->input('taskId') ?? null;

        $scopes = $this->taskDetailService->getScopes($projectId);

        if ($taskId) {
            $task = Task::where('id', $taskId)->first();
            $scope_id = $task->scope_id;
        } else {
            $scope_id = $request->input('scope_id') ? $request->input('scope_id') : null;
            $scope_id = $scope_id ?? $scopes->keys()->first();
        }

        $task_detail_types = $this->taskDetailService->getTaskDetailTypes();
        $task_detail_type_id = $request->input('task_detail_type_id') ?? null;

        $task_details = TaskDetail::select('id', 'locale', 'description', 'task_id')
            ->whereHas('task', function ($query) use ($locale, $projectId, $scope_id, $task_title, $taskId) {
                $query->whereHas('scope', function ($query) use ($projectId, $scope_id) {
                    $query->where('project_id', $projectId)
                        ->when($scope_id, function ($query) use ($scope_id) {
                            $query->where('scope_id', $scope_id);
                        })
                        ->select('id');
                })
                    ->select('id')
                    ->when($taskId, function ($query) use ($taskId) {
                        $query->where('task_id', $taskId);
                    })
                    ->when($task_title, function ($query) use ($locale, $task_title) {
                        $query->where(function ($query) use ($locale, $task_title) {
                            $query->where(
                                'title',
                                'like',
                                '%' . $task_title . '%'
                            )->where('locale', $locale)
                                ->orWhereHas('translations', function ($query) use ($locale, $task_title) {
                                    $query->where(
                                        'locale',
                                        $locale
                                    )
                                        ->where('field_name', 'title')
                                        ->where('value', 'like', '%' . $task_title . '%');
                                });
                        });
                    });
            })
            ->when($task_detail_type_id, function ($query) use ($task_detail_type_id) {
                $query->where('task_detail_type_id', $task_detail_type_id);
            })
            ->orderBy('updated_at', 'desc')
            ->orderBy('id')
            ->paginate(8)
            ->appends([
                'scope_id' => $scope_id,
                'task_title' => $task_title,
                'task_detail_type_id' => $task_detail_type_id,
                'page' => $page,
            ]);

        Log::info($this->className, [__FUNCTION__]);

        return view('task_details.index', [
            'projectTitle' => $projectTitle,
            'task_details' => $task_details,
            'scopes' => $scopes,
            'scope_id' => $scope_id,
            'taskId' => $taskId,
            'task_detail_types' => $task_detail_types,
        ]);
    }
}
