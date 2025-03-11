<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Project;
use App\Services\WelcomeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WelcomeController extends Controller
{
    public function __construct(protected WelcomeService $welcomeService)
    {
        parent::__construct();
    }

    public function index(Request $request): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__ => [$request->query()]]);
        $apiProjectId = $request->input('project_id') ?? null;

        if ($apiProjectId && is_numeric($apiProjectId) && $apiProjectId > 0) {
            $project = Project::where('id', $apiProjectId)->get()->first();
        } else {
            $project = Project::where('is_featured', true)->orderBy('created_at', 'desc')->first();
        }

        $project = Project::getTranslations($project, [$this->apiLocale]);

        if (is_null($project)) {
            return apiResponse(
                null,
                __('middleware.featured_project_error'),
                false,
                500
            );
        }

        $resultArray = $this->welcomeService->getWelcomeContent($project->id, $this->apiLocale);

        Log::info($this->className, [__FUNCTION__ => [$project->id]]);

        return apiResponse(
            [
                'projectId' => $project->id,
                'projectTitle' => $project->title,
                'scopesLeft' => $resultArray[0] ?? [],
                'scopesRight' => $resultArray[1] ?? [],
            ],
            __('welcome.welcome_success_message'),
            true,
            200
        );
    }
}
