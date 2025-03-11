<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\ProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\ScopeService;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    public function __construct(protected ProjectService $projectService, protected ScopeService $scopeService)
    {
        parent::__construct();
    }

    public function search(ProjectRequest $request): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__]);

        $query = Project::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('description')) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        $projects = $query->get();
        $projects = Project::getTranslations($projects, [$this->apiLocale]);
        $totalCount = count($projects);

        $responseMsg = $projects->isEmpty() ? __('project.projects_search_no_data_found_message') : __('project.projects_search_success_message');

        Log::info($this->className, [__FUNCTION__ => [$responseMsg]]);

        return apiResponse(
            $projects->isEmpty() ? [] : $projects,
            $responseMsg,
            true,
            200,
            ['X-Total-Count' => $totalCount]
        );
    }

    public function index(): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__]);

        $projects = Project::orderBy('title')->orderBy('id')->get();
        $projects = Project::getTranslations($projects, [$this->apiLocale]);
        $totalCount = count($projects);

        $responseMsg = $projects->isEmpty() ? __('project.projects_index_no_data_found_message') : __('project.projects_index_success_message');

        Log::info($this->className, [__FUNCTION__ => [$responseMsg]]);

        return apiResponse(
            $projects->isEmpty() ? [] : $projects,
            $responseMsg,
            true,
            200,
            ['X-Total-Count' => $totalCount]
        );
    }

    public function show(Request $request, Project $project, $view = 'default'): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__ => ['start', $project->id, $view, request()->query()]]);

        try {
            $project = Project::getTranslations($project, [$this->apiLocale]);

            $scopeId = (int) $request->input('scopeId') ?? 0;

            //get defined views
            $views = trans('config.view');

            //get scopes, tasks, task_details
            if (is_null($project) || (! array_key_exists($view, $views)) || empty($this->apiLocale)) {
                $data = null;
                $message = __('project.projects_show_error_message', ['projectId' => $project->id ?? null, 'view' => $view, 'locale' => $this->apiLocale]);
                $status = 404;
            } else {
                [$scopeId, $scopes] = $this->projectService->getProjectDetails($project->id, $view, $this->apiLocale, $scopeId);

                $scopesSelect = $this->scopeService->getScopes($project->id)->toArray();

                $data = [
                    'project' => $project,
                    'scopes' => $scopes,
                    'scopeId' => $scopeId,
                    'scopeSelect' => $scopesSelect,
                ];
                $message = __('project.projects_show_success_message');
                $status = 200;
            }

            Log::info($this->className, [__FUNCTION__ => ['end']]);
            return apiResponse($data, $message, true, $status);
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_show_error_message', ['projectId' => $project->id ?? null, 'view' => $view]) . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return apiResponse(
                null,
                __('project.projects_show_error_message') . ': ' . $e->getTraceAsString(),
                false,
                500
            );
        }
    }

    public function store(ProjectRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $data['locale'] = $this->apiLocale;

            $project = Project::create($data);

            Log::info($this->className, [__FUNCTION__ => __('project.projects_create_success_message') . '(' . $project->id . ')']);

            return apiResponse(
                $project,
                __('project.projects_create_success_message'),
                true,
                201,
                ['Location' => route('projects.show', ['project' => $project->id])]
            );
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'description', 'is_featured']),
            ]);

            return apiResponse(
                null,
                __('project.projects_create_error_message') . ': ' . $e->getTraceAsString(),
                false,
                500
            );
        }
    }

    public function update(ProjectRequest $request, Project $project): JsonResponse
    {
        try {
            $data = $request->validated();
            $project = Project::create($data);

            Log::info($this->className, [__FUNCTION__ => __('project.projects_update_success_message') . '(' . $project->id . ')']);

            return apiResponse(
                $project,
                __('project.projects_update_success_message'),
                true,
                200
            );
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'description', 'is_featured']),
            ]);

            return apiResponse(
                null,
                __('project.projects_update_error_message') . ': ' . $e->getTraceAsString(),
                false,
                500
            );
        }
    }

    //destroy
    public function destroy(Project $project): JsonResponse
    {
        try {
            $project->delete();

            Log::info($this->className, [__FUNCTION__ => $project->id]);

            return apiResponse(
                null,
                __('project.projects_delete_success_message'),
                true,
                200
            );
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('project.projects_delete_error_message') . __('project.projects_delete_error_foreign_key')]);

                return apiResponse(
                    null,
                    __('project.projects_delete_error_message') . __('project.projects_delete_error_foreign_key'),
                    false,
                    500
                );
            }

            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $project->id,
            ]);

            return apiResponse(
                null,
                __('project.projects_delete_error_message') . ': ' . $e->getTraceAsString(),
                false,
                500
            );
        }
    }
}
