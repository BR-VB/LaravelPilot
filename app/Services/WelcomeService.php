<?php

namespace App\Services;

use App\Models\Scope;
use App\Models\Task;
use Illuminate\Support\Facades\Log;

class WelcomeService
{
    public function getWelcomeContent(int $projectId, string $locale): array
    {
        Log::info(class_basename(self::class), [__FUNCTION__ => 'start']);

        $maxColumnGroups = config('project.welcome.max_columns');
        $maxTasksPerScope = config('project.welcome.max_tasks_per_scope');

        if (! empty($projectId)) {
            $featuredScopesRows = Scope::where('project_id', $projectId)
                ->where('is_featured', true)
                ->orderBy('project_id')
                ->orderBy('column')
                ->orderBy('sortorder')
                ->get();

            $featuredScopesRows = Scope::getTranslations($featuredScopesRows, [$locale]);
        } else {
            $featuredScopesRows = [];
        }

        $resultArray = [];
        $currentColumnValues = [];

        foreach ($featuredScopesRows as $row) {
            $columnValue = $row->column;

            if (! in_array($columnValue, $currentColumnValues)) {
                if (count($currentColumnValues) >= $maxColumnGroups) {
                    break;
                }

                $currentColumnValues[] = $columnValue;
                $resultArray[] = [];
            }

            $tasks = Task::where('scope_id', $row->id)
                ->where('is_featured', true)
                ->orderBy('scope_id')
                ->orderBy('occurred_at', 'desc')
                ->limit($maxTasksPerScope)->get();

            $tasks = Task::getTranslations($tasks, [$locale]);

            $featuredTasksForScope = [];
            foreach ($tasks as $task) {
                $featuredTasksForScope[] = [
                    'id' => $task->id,
                    'icon' => $task->icon,
                    'prefix' => $task->prefix,
                    'title' => $task->title,
                    'description' => $task->description,
                ];
            }

            $groupIndex = array_search($columnValue, $currentColumnValues);
            $resultArray[$groupIndex][] = [
                'title' => $row->title,
                'label' => $row->label,
                'id' => $row->id,
                'tasks' => $featuredTasksForScope,
            ];
        }

        Log::info(class_basename(self::class), [__FUNCTION__ => 'end']);

        return $resultArray;
    }
}
