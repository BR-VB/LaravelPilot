<?php

namespace App\Services;

use Illuminate\Support\Collection;

class TaskService
{
    //create a new class instance
    public function __construct(private ScopeService $scopeService)
    {
        //
    }

    public function getScopes(int $projectId): Collection
    {
        return $this->scopeService->getScopes($projectId);
    }

    public function getTaskIcons(): array
    {
        return [
            '' => __('task.tasks_create_select_icon_text'),
            '✅' => '✅',
            '⌛' => '⌛',
            '🤔' => '🤔',
            '⚠️' => '⚠️',
            '🌟' => '🌟',
            '👀' => '👀',
            '💡' => '💡',
            '🔐' => '🔐',
            '👉' => '👉',
            '💪' => '💪',
            '🚀' => '🚀',
        ];
    }
}
