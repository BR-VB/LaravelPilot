<?php

namespace App\Http\Controllers\App;

use App\Events\TranslationMissing;
use App\Http\Requests\App\ProjectRequest;
use App\Models\Project;
use App\Models\Scope;
use App\Models\User;
use App\Services\ProjectService;
use App\Services\ScopeService;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProjectController extends Controller
{
    protected array $projectDetails;

    public function __construct(protected ProjectService $projectService, protected ScopeService $scopeService)
    {
        parent::__construct();

        $this->projectDetails = [];
    }

    //switch - GET
    public function switch(Request $request): RedirectResponse
    {
        $newProjectId = $request->input('projectId');
        if (! (filter_var($newProjectId, FILTER_VALIDATE_INT) && (int) $newProjectId > 0)) {
            return redirect()->back()->withError(__('project.projects_invalid_project_id'));
        }

        $currentProjectId = session('projectId') ?? 0;
        if ($currentProjectId !== $newProjectId) {
            $projects = $this->projectService->getAvailableProjects();

            foreach ($projects as $project) {
                if ($project->id == $newProjectId) {
                    session(['projectId' => $project->id, 'projectTitle' => $project->title]);
                    cache()->forget('teaserTask');

                    if (Auth::check()) {
                        Cookie::queue('userProjectId', session('projectId'), 60 * 24 * 30);
                    }

                    Log::info($this->className, [__FUNCTION__ => __('project.projects_switch_success'), 'project - old' => $currentProjectId, 'project - new' => $newProjectId]);

                    return redirect()->route('home')->withSuccess(__('project.projects_switch_success'));
                }
            }

            Log::error(class_basename(self::class), [__FUNCTION__ => __('project.projects_invalid_project_id')]);

            return redirect()->back()->withError(__('project.projects_invalid_project_id'));
        }

        Log::info(class_basename(self::class), [__FUNCTION__]);
        return redirect()->back();
    }

    //destroy - DELETE
    public function destroy(Project $project): RedirectResponse
    {
        $routeLink = session('return_to_delete_origin', route('projects.index'));

        try {
            $project->delete();

            Log::info($this->className, [__FUNCTION__ => $project->id]);
            return redirect($routeLink)->withSuccess(__('project.projects_delete_success_message'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('project.projects_delete_error_message') . __('project.projects_delete_error_foreign_key')]);
                return redirect()->back()->withError(__('project.projects_delete_error_message') . __('project.projects_delete_error_foreign_key'))->withInput();
            }

            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $project->id,
            ]);

            return redirect()->back()->withError(__('project.projects_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //reporting - POST
    public function report(Request $request, Project $project): RedirectResponse
    {
        Log::info($this->className, [__FUNCTION__ => $project->id]);

        if ($request->user()->cannot('report', $project)) {
            return redirect()->route('home')->withError(__('project.projects_policy_reporting_error'));
        }

        $user = User::where('id', $request->user()->id)->first();

        TranslationMissing::dispatch($user, $project);

        return redirect()->back()->withSuccess(__('project.projects_event_success_message'));
    }

    //update - PUT
    public function update(ProjectRequest $request, Project $project): RedirectResponse
    {
        //$routeLink = session('return_to_edit_origin', route('projects.index'));

        try {
            $project->update($request->validated());

            Log::info($this->className, [__FUNCTION__ => $project->id]);
            return redirect()->back()->withSuccess(__('project.projects_update_success_message'));
            //return redirect($routeLink)->withSuccess(__('project.projects_update_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withError(__('project.projects_update_error_message') . $e->getMessage())->withInput();
        }
    }

    //edit - GET
    public function edit(Project $project): RedirectResponse|View
    {
        $projectTitle = session('projectTitle');
        $project = Project::getTranslations($project);

        Log::info($this->className, [__FUNCTION__ => $project->id]);

        if ($project->locale != session('locale')) {
            return redirect()->route('projects.show', ['project' => $project->id])
                ->withWarning(__('config.not_original_locale'));
        }

        return view('projects.edit', [
            'projectTitle' => $projectTitle,
            'project' => $project,
            'isEditMode' => true,
        ]);
    }

    //show - GET ( no model-binding here (!) )
    public function show(Request $request, ?string $id = null, $view = 'default'): RedirectResponse|View
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);

        $projectTitle = session('projectTitle') ?? '';
        $projectId = session('projectId') ?? 0;

        $scopeId = (int) $request->input('scopeId') ?? 0;

        if ($id !== null) {
            if (! (filter_var($id, FILTER_VALIDATE_INT) && (int) $id > 0)) {
                return redirect()->back()->withError(__('project.projects_invalid_project_id'));
            }
            $project = Project::find($id);
        } else {
            $project = Project::find($projectId);
        }

        $project = Project::getTranslations($project);

        //get defined views
        $views = trans('config.view');
        $appLocale = session('locale', app()->getLocale());

        if (is_null($project) || (! array_key_exists($view, $views)) || empty($appLocale)) {
            return redirect()->back()->withError(__('project.projects_show_error_message', ['projectId' => ($id ?? ($projectId ?? null)), 'view' => $view, 'locale' => $appLocale]));
        }

        //get scopes, tasks, task_details
        [$scopeId, $scopes] = $this->projectService->getProjectDetails($project->id, $view, $appLocale, $scopeId);

        $scopesSelect = $this->scopeService->getScopes($project->id);

        $bladeView = $views[$view] ?? 'projects.show';

        Log::info($this->className, [__FUNCTION__ => ['end', $project->id]]);

        return view($bladeView, [
            'projectTitle' => $projectTitle,
            'project' => $project,
            'scopes' => $scopes,
            'view' => $view,
            'scopeId' => $scopeId,
            'scopeSelect' => $scopesSelect,
        ]);
    }

    //store - POST
    public function store(ProjectRequest $request): RedirectResponse
    {
        $routeLink = session('return_to_create_origin', route('projects.index'));

        try {
            $project = Project::create($request->validated());

            Log::info($this->className, [__FUNCTION__ => __('project.projects_create_success_message') . '(' . $project->id . ')']);
            return redirect($routeLink)->withSuccess(__('project.projects_create_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('project.projects_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'description', 'is_featured']),
            ]);

            return redirect()->back()->withError(__('project.projects_create_error_message'))->withInput();
        }
    }

    //create - GET
    public function create(): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('projects.create', [
            'projectTitle' => session('projectTitle'),
        ]);
    }

    //index - GET
    public function index(Request $request): View
    {
        $projects = Project::orderBy('title')->orderBy('id')->paginate(8)->appends($request->query());
        Log::info($this->className, [__FUNCTION__]);

        return view('projects.index', [
            'projectTitle' => session('projectTitle'),
            'projects' => $projects,
        ]);
    }
}
