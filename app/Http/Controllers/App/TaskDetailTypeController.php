<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\App\TaskDetailTypeRequest;
use App\Models\TaskDetailType;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TaskDetailTypeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //destroy - DELETE
    public function destroy(TaskDetailType $task_detail_type): RedirectResponse
    {
        try {
            $task_detail_type->delete();

            Log::info($this->className, [__FUNCTION__ => $task_detail_type->id]);
            return redirect()->back()->withSuccess(__('task_detail_type.task_detail_types_delete_success_message'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('task_detail_type.task_detail_types_delete_error_message') . __('task_detail_type.task_detail_types_delete_error_foreign_key')]);
                return redirect()->back()->withError(__('task_detail_type.task_detail_types_delete_error_message') . __('task_detail_type.task_detail_types_delete_error_foreign_key'))->withInput();
            }

            Log::error($this->className, [
                __FUNCTION__ => __('task_detail_type.task_detail_types_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $task_detail_type->id,
            ]);

            return redirect()->back()->withError(__('task_detail_type.task_detail_types_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //update - PUT
    public function update(TaskDetailTypeRequest $request, TaskDetailType $task_detail_type): RedirectResponse
    {
        try {
            $task_detail_type->update($request->validated());

            Log::info($this->className, [__FUNCTION__ => $task_detail_type->id]);
            return redirect()->back()->withSuccess(__('task_detail_type.task_detail_types_update_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task_detail_type.task_detail_types_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withError(__('scope.scopess_update_error_message') . $e->getMessage())->withInput();
        }
    }

    //edit - GET
    public function edit(TaskDetailType $task_detail_type): RedirectResponse|View
    {
        $projectTitle = session('projectTitle') ?? '';
        $task_detail_type = TaskDetailType::getTranslations($task_detail_type);

        Log::info($this->className, [__FUNCTION__ => $task_detail_type->id]);

        if ($task_detail_type->locale != session('locale')) {
            return redirect()->route('task_detail_types.show', ['task_detail_type' => $task_detail_type->id])
                ->withWarning(__('config.not_original_locale'));
        }

        return view('task_detail_types.edit', [
            'projectTitle' => $projectTitle,
            'task_detail_type' => $task_detail_type,
            'isEditMode' => true,
        ]);
    }

    //show - GET
    public function show(TaskDetailType $task_detail_type): View
    {
        $projectTitle = session('projectTitle');
        $task_detail_type = TaskDetailType::getTranslations($task_detail_type);

        Log::info($this->className, [__FUNCTION__ => $task_detail_type->id]);

        return view('task_detail_types.edit', [
            'projectTitle' => $projectTitle,
            'task_detail_type' => $task_detail_type,
            'isEditMode' => false,
        ]);
    }

    //store - POST
    public function store(TaskDetailTypeRequest $request): RedirectResponse
    {
        $routeLink = session('return_to_create_origin', route('task_detail_types.index'));

        try {
            $task_detail_type = TaskDetailType::create($request->validated());

            Log::info($this->className, [__FUNCTION__ => __('task_detail_type.task_detail_types_create_success_message') . '(' . $task_detail_type->id . ')']);
            return redirect($routeLink)->withSuccess(__('task_detail_type.task_detail_types_create_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('task_detail_type.task_detail_types_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'label', 'is_featured', 'column', 'sortorder']),
            ]);

            return redirect()->back()->withError(__('task_detail_type.task_detail_types_create_error_message'))->withInput();
        }
    }

    //create - GET
    public function create(): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('task_detail_types.create', [
            'projectTitle' => session('projectTitle'),
        ]);
    }

    //index - GET
    public function index(Request $request): View
    {
        $task_detail_types = TaskDetailType::orderBy('title')->orderBy('id')->paginate(8)->appends($request->query());

        Log::info($this->className, [__FUNCTION__]);

        return view('task_detail_types.index', [
            'projectTitle' => session('projectTitle'),
            'task_detail_types' => $task_detail_types,
        ]);
    }
}
