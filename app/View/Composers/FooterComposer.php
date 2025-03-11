<?php

namespace App\View\Composers;

use App\Services\ProjectService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class FooterComposer
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $this->projectService = $projectService;
    }

    public function compose(View $view)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $view->with('projects', $this->projectService->getAvailableProjects());
    }
}
