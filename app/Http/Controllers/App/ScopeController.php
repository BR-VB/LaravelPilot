<?php

namespace App\Http\Controllers\App;

use App\Http\Requests\App\ScopeRequest;
use App\Models\Scope;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ScopeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    //destroy - DELETE
    public function destroy(Scope $scope): RedirectResponse
    {
        try {
            $scope->delete();

            Log::info($this->className, [__FUNCTION__ => $scope->id]);
            return redirect()->back()->withSuccess(__('scope.scopes_delete_success_message'));
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1] ?? null;

            if ($errorCode === 1451) {
                Log::error($this->className, [__FUNCTION__ => __('scope.scopes_delete_error_message') . __('scope.scopes_delete_error_foreign_key')]);
                return redirect()->back()->withError(__('scope.scopes_delete_error_message') . __('scope.scopes_delete_error_foreign_key'))->withInput();
            }

            Log::error($this->className, [
                __FUNCTION__ => __('scope.scopes_delete_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $scope->id,
            ]);

            return redirect()->back()->withError(__('scope.scopes_delete_error_message') . $e->getMessage())->withInput();
        }
    }

    //update - PUT
    public function update(ScopeRequest $request, Scope $scope): RedirectResponse
    {
        if (! ($scope->project_id > 0) || $scope->project_id !== (int) session('projectId')) {
            Log::error($this->className, [__FUNCTION__ => __('scope.scopes_search_error_message') . '(' . $scope->id . ')']);
            return redirect()->back()->withError(__('scope.scopes_search_error_message'))->withInput();
        }

        try {
            $scope->update($request->validated());

            Log::info($this->className, [__FUNCTION__ => $scope->id]);
            return redirect()->back()->withSuccess(__('scope.scopes_update_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('scope.scopes_update_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all(),
            ]);

            return redirect()->back()->withError(__('scope.scopes_update_error_message') . $e->getMessage())->withInput();
        }
    }

    //edit - GET ( no model-binding here (!) )
    public function edit(string $id): RedirectResponse|View
    {
        $projectTitle = session('projectTitle');

        $scope = Scope::where('id', $id)->where('project_id', session('projectId'))->first();
        $scope = Scope::getTranslations($scope);

        Log::info($this->className, [__FUNCTION__ => $scope->id]);

        if ($scope->locale != session('locale')) {
            return redirect()->route('scopes.show', ['scope' => $scope->id])
                ->withWarning(__('config.not_original_locale'));
        }

        return view('scopes.edit', [
            'projectTitle' => $projectTitle,
            'scope' => $scope,
            'isEditMode' => true,
        ]);
    }

    //show - GET ( no model-binding here (!) )
    public function show(string $id): View
    {
        $projectTitle = session('projectTitle');

        $scope = Scope::where('id', $id)->where('project_id', session('projectId'))->first();
        $scope = Scope::getTranslations($scope);

        Log::info($this->className, [__FUNCTION__ => $scope->id]);

        return view('scopes.edit', [
            'projectTitle' => $projectTitle,
            'scope' => $scope,
            'isEditMode' => false,
        ]);
    }

    //store - POST
    public function store(ScopeRequest $request): RedirectResponse
    {
        $projectId = session('projectId');
        if (! $projectId) {
            return redirect()->back()->withError(__('scope.scopes_no_project'))->withInput();
        }

        $routeLink = session('return_to_create_origin', route('scopes.index'));

        try {
            $scope = Scope::create(array_merge($request->validated(), ['project_id' => $projectId]));

            Log::info($this->className, [__FUNCTION__ => __('scope.scopes_create_success_message') . '(' . $scope->id . ')']);
            return redirect($routeLink)->withSuccess(__('scope.scopes_create_success_message'));
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('scope.scopes_create_error_message') . $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->only(['title', 'label', 'is_featured', 'column', 'sortorder']),
            ]);

            return redirect()->back()->withError(__('scope.scopes_create_error_message'))->withInput();
        }
    }

    //create - GET
    public function create(): View
    {
        Log::info($this->className, [__FUNCTION__]);

        return view('scopes.create', [
            'projectTitle' => session('projectTitle'),
        ]);
    }

    //index - GET
    public function index(Request $request): View
    {
        $scopes = Scope::where('project_id', session('projectId'))
            ->orderBy('project_id')
            ->orderBy('column')
            ->orderBy('sortorder')
            ->orderBy('title')
            ->orderBy('id')
            ->paginate(8)->appends($request->query());

        Log::info($this->className, [__FUNCTION__]);

        return view('scopes.index', [
            'projectTitle' => session('projectTitle'),
            'scopes' => $scopes,
        ]);
    }
}
