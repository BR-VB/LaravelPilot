<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TaskDetailService
{
    //create a new class instance
    public function __construct(private ScopeService $scopeService, private TaskDetailTypeService $taskDetailTypeService)
    {
        //
    }

    public function getScopes(int $projectId): Collection
    {
        return $this->scopeService->getScopes($projectId);
    }

    public function getTaskDetailTypes(): Collection
    {
        return $this->taskDetailTypeService->getTaskDetailTypes();
    }
}
