<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Scope;
use App\Models\Task;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProjectService
{
    protected Collection $projects;

    protected Collection|LengthAwarePaginator $projectDetails;

    protected ?Scope $scope = null;

    protected int $scopeId;

    protected int $projectId;

    protected string $locale;

    protected string $view;

    protected string $className;

    public function __construct()
    {
        $this->projects = collect();
        $this->projectId = 0;
        $this->scopeId = 0;
        $this->locale = '';
        $this->view = '';
        $this->projectDetails = collect();
        $this->className = class_basename(self::class);
    }

    //get all available projects (e.g., for project switcher, ...)
    public function getAvailableProjects(): Collection
    {
        //if already loaded during loading process ...
        if ($this->projects->isNotEmpty()) {
            Log::info($this->className, [__('project.projects_load_success_singleton') => $this->projects->pluck('id')->toArray()]);

            return $this->projects;
        }

        try {
            $projects = Project::select('id', 'title', 'locale')->orderBy('title')->orderBy('id')->get();
            $projects = Project::getTranslations($projects);
            Log::info($this->className, [__('project.projects_load_success') => $projects->pluck('id')->toArray()]);
        } catch (\Exception $e) {
            Log::error($this->className, [__('project.projects_load_error') => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return collect([]);
        }

        $this->projects = $projects;

        return $projects;
    }

    //get details for a single project to show with different views
    public function getProjectDetails(int $projectId, string $view, string $locale, int $scopeId): array
    {
        Log::info($this->className, [__FUNCTION__ => ['start' => [$projectId, $locale, $view, request()->query()]]]);

        if (empty(trim($locale)) || empty(trim($view)) || ($projectId <= 0)) {
            Log::error($this->className, [__('project.projects_show_error_message', ['projectId' => $projectId, 'view' => $view, 'locale' => $locale])]);
            return [];
        }

        if (! $this->isProjectAndLocaleUnchangedAndDetailsLoaded($projectId, $view, $locale, $scopeId)) {
            $this->loadProjectDetails($projectId, $view, $locale, $scopeId);
        }

        $resultArray = [$this->scopeId, $this->matchAndSortProjectDetailsForView()];

        Log::info($this->className, [__FUNCTION__ => ['end' => [$projectId, $locale, $view, request()->query()]]]);
        return $resultArray;
    }

    //
    //====== private functions ======
    //

    private function getProjectDetailsFromDB(): void
    {
        if (empty(trim($this->view)) || empty($this->locale) || ($this->projectId <= 0)) {
            return;
        }

        $locale = $this->locale;
        $projectId = $this->projectId;
        $view = $this->view;

        if ($view === 'byscope') {
            if (empty($this->scopeId)) {
                $this->scope = Scope::where('project_id', $projectId)
                    ->withCount('tasks')
                    ->orderByDesc('tasks_count')->orderByDesc('id')
                    ->limit(1)
                    ->first();
                $this->scope = Scope::getTranslations($this->scope, [$locale]);
                $this->scopeId = $this->scope->id;
            } else {
                $this->scope = Scope::where('project_id', $projectId)->where('id', $this->scopeId)->first();
                $this->scope = Scope::getTranslations($this->scope, [$locale]);
            }
        } else {
            $this->scopeId = 0;
            $this->scope = null;
        }

        $scopeId = $this->scopeId;

        $useLimit = config("project.project.view.{$view}.max") ?? 30;
        $usePaginate = ($useLimit > 0) ? 0 : max(config("project.project.view.task_paginate") ?? 30, 1);

        $useScopeQuery = (($view === 'default') || ($view === 'latest') || ($view === 'latesttask'));
        $useTaskQuery = !$useScopeQuery;

        if ($useScopeQuery) {
            $result = Scope::select('id', 'title', 'label', 'is_featured', 'column', 'sortorder', 'bgcolor', 'locale')
                ->where('project_id', $projectId)
                ->withTranslations($locale)
                ->with([
                    'tasks' => function ($query) use ($locale, $useLimit) {
                        $query->select('id', 'scope_id', 'title', 'description', 'is_featured', 'icon', 'prefix', 'locale', 'occurred_at', 'updated_at')
                            ->withTranslations($locale)
                            ->orderBy('occurred_at', 'desc')
                            ->orderBy('title')
                            ->orderBy('id', 'desc')
                            ->limit($useLimit);
                    },
                    'tasks.task_details' => function ($query) use ($locale) {
                        $query->select('id', 'task_detail_type_id', 'task_id', 'description', 'locale', 'occurred_at', 'updated_at')
                            ->withTranslations($locale);
                    },
                    'tasks.task_details.task_detail_type' => function ($query) use ($locale) {
                        $query->select('id', 'title', 'label', 'locale')
                            ->withTranslations($locale);
                    },
                ])->get();
        }

        if ($useTaskQuery) {
            $query = Task::select('id', 'scope_id', 'title', 'description', 'is_featured', 'icon', 'prefix', 'locale', 'occurred_at', 'updated_at')
                ->whereHas('scope', function ($query) use ($projectId) {
                    $query->where('project_id', $projectId);
                })
                ->when($scopeId, function ($query) use ($scopeId) {
                    $query->where('scope_id', $scopeId);
                })
                ->withTranslations($locale)
                ->with([
                    'scope:id,title,label,is_featured,column,sortorder,bgcolor,locale',
                    'scope' => function ($query) use ($locale) {
                        $query->withTranslations($locale);
                    },
                    'task_details:id,task_detail_type_id,task_id,description,locale,occurred_at,updated_at',
                    'task_details' => function ($query) use ($locale) {
                        $query->withTranslations($locale);
                    },
                    'task_details.task_detail_type:id,title,label,locale',
                    'task_details.task_detail_type' => function ($query) use ($locale) {
                        $query->withTranslations($locale);
                    },
                ])
                ->orderByDesc('occurred_at')
                ->orderBy('title')
                ->orderByDesc('id');

            $result = $usePaginate ? $query->paginate($usePaginate) : $query->get();
        }

        $this->projectDetails = $result;
    }

    private function matchAndSortProjectDetailsForView(): array|LengthAwarePaginator
    {
        return match ($this->view) {
            'byscope' => $this->projectDetailsDefaultOverviewPaginate(false, false, config('project.project.view.byscope.max')),
            'latest' => $this->projectDetailsDefaultOverview(false, true, config('project.project.view.latest.max')),
            'latesttask' => $this->projectDetailsAll(true, config('project.project.view.latesttask.max')),
            'chronological' => $this->projectDetailsAllPaginate(false, config('project.project.view.chronological.max')),
            'withalldetails' => $this->projectDetailsAllPaginate(true, config('project.project.view.withalldetails.max')),
            default => $this->projectDetailsDefaultOverview(false, false, config('project.project.view.default.max')),
        };
    }

    private function projectDetailsDefaultOverviewPaginate(bool $is_featured = false, bool $withTaskDetails = false, int $maxCount = 0): LengthAwarePaginator
    {
        $projectDetails = [];

        $taskCollection = $this->projectDetails->items();

        $scopeInfo = $this->extractScopeInfo($this->scope, true);

        //matching: only featured details ($is_featured == true) or all details ($is_featured == false)
        foreach ($taskCollection as $task) {
            if ($is_featured && !$task->is_featured) {
                continue;
            }

            $taskInfo = $this->extractTaskInfo($task);

            if ($withTaskDetails && $task->task_details->isNotEmpty()) {
                $taskInfo['task_details'] = $this->getTaskDetails($task->task_details);
            }

            //sort task_details: taskDetailOccurredAt
            usort($taskInfo['task_details'], function ($a, $b) {
                return strtotime($a['taskDetailOccurredAt']) <=> strtotime($b['taskDetailOccurredAt']);
            });

            $scopeInfo['tasks'][] = $taskInfo;
        }

        if ($maxCount > 0) {
            $scopeTasks = $scopeInfo['tasks'];
            $scopeInfo['tasks'] = array_splice($scopeTasks, 0, $maxCount);
        }

        $projectDetails = new LengthAwarePaginator(
            [$scopeInfo],
            $this->projectDetails->total(),
            $this->projectDetails->perPage(),
            $this->projectDetails->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $projectDetails;
    }

    private function projectDetailsDefaultOverview(bool $is_featured = true, bool $withTaskDetails = false, int $maxCount = 0): array
    {
        $locale = $this->locale;

        $projectDetails = [];

        $collection = $this->projectDetails;

        //sorting: scope.column, scope.sortorder, task.craeted_at
        $collection->each(function ($scope) {
            $scope->tasks = $scope->tasks->sortByDesc('occurred_at');
        });

        $collection = $collection->sortBy(function ($scope) {
            return [
                $scope->column,
                $scope->sortorder,
                optional($scope->tasks->first())->occurred_at,
            ];
        });

        //matching: only featured details ($is_featured == true) or all details ($is_featured == false)
        $scopeInfo = null;
        foreach ($collection as $scope) {
            $scopeInfo = $this->extractScopeInfo($scope);

            if ($scope->tasks->isNotEmpty()) {
                foreach ($scope->tasks as $task) {
                    $taskInfo = $this->extractTaskInfo($task);

                    if ($withTaskDetails && $task->task_details->isNotEmpty()) {
                        foreach ($task->task_details as $taskDetail) {
                            $taskInfo['task_details'][] = $this->extractTaskDetailInfo($taskDetail);
                        }
                    } else {
                        $taskInfo['task_details'] = [];
                    }

                    //sort task_details: taskDetailOccurredAt
                    usort($taskInfo['task_details'], function ($a, $b) {
                        return strtotime($a['taskDetailOccurredAt']) <=> strtotime($b['taskDetailOccurredAt']);
                    });

                    if (! $is_featured || $is_featured == $task->is_featured) {
                        $scopeInfo['tasks'][] = $taskInfo;
                    }
                }
            } else {
                $scopeInfo['tasks'] = [];
            }

            if (! $is_featured || $is_featured == $scope->is_featured) {
                if ($maxCount > 0) {
                    $scopeTasks = $scopeInfo['tasks'];
                    $scopeInfo['tasks'] = array_splice($scopeTasks, 0, $maxCount);
                }
                $projectDetails[] = $scopeInfo;
            }
        }

        return $projectDetails;
    }

    private function projectDetailsAllPaginate(bool $withTaskDetails = true, int $maxCount = 0): LengthAwarePaginator
    {
        $locale = $this->locale;

        $taskCollection = $this->projectDetails->items();

        $projectDetails = [];

        //sorting: task.occurred_at desc, task.title (in actual language)
        foreach ($taskCollection as $task) {
            $scope = $task->scope;

            $scopeTranslations = $scope->translations->where('locale', $locale)->pluck('value', 'field_name');
            $taskTranslations = $task->translations->where('locale', $locale)->pluck('value', 'field_name');

            //translatable fields
            $scopeLabel = $scopeTranslations->get('label', $scope->label);

            $taskTitle = $taskTranslations->get('title', $task->title);
            $taskDescription = $taskTranslations->get('description', $task->description);

            // sort task_details
            $taskDetails = $task->task_details ?: collect();
            $taskDetails = $taskDetails->sortBy('occurred_at');

            if ($withTaskDetails) {
                $taskDetails = $this->getTaskDetails($taskDetails);
            } else {
                $taskDetails = [];
            }

            // return new structure while keeping original attributes
            $taskInfo = [
                'taskOccurredAt' => $task->occurred_at,
                'taskTitle' => $taskTitle,
                'taskId' => $task->id,
                'taskDescription' => $taskDescription,
                'taskLocale' => $task->locale,
                'taskIsFeatured' => $task->is_featured,
                'taskIcon' => $task->icon,
                'taskPrefix' => $task->prefix,
                'taskUpdatedAt' => $task->updated_at,
                'scopeId' => $scope->id,
                'scopeTitle' => $scope->title,
                'scopeLabel' => $scopeLabel,
                'scopeIsFeatured' => $scope->is_featured,
                'scopeColumn' => $scope->column,
                'scopeSortorder' => $scope->sortorder,
                'scopeBgcolor' => $scope->bgcolor,
                'task_details' => $taskDetails,
            ];

            $projectDetails[] = $taskInfo;
        }

        if ($maxCount > 0) {
            $projectDetails = array_splice($projectDetails, 0, $maxCount);
        }

        $projectDetailsWithPagination = new LengthAwarePaginator(
            $projectDetails,
            $this->projectDetails->total(),
            $this->projectDetails->perPage(),
            $this->projectDetails->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return $projectDetailsWithPagination;
    }

    private function projectDetailsAll(bool $withTaskDetails = true, int $maxCount = 0): array
    {
        $locale = $this->locale;

        //sorting: task.occurred_at desc, task.title (in actual language)
        $collection = $this->projectDetails->flatMap(function ($scope) use ($locale, $withTaskDetails) {
            return $scope->tasks->map(function ($task) use ($scope, $locale, $withTaskDetails) {
                $scopeTranslations = $scope->translations->where('locale', $locale)->pluck('value', 'field_name');
                $taskTranslations = $task->translations->where('locale', $locale)->pluck('value', 'field_name');

                //translatable fields
                $scopeLabel = $scopeTranslations->get('label', $scope->label);

                $taskTitle = $taskTranslations->get('title', $task->title);
                $taskDescription = $taskTranslations->get('description', $task->description);

                // sort task_details
                $taskDetails = $task->task_details ?: collect();
                $taskDetails = $taskDetails->sortBy('occurred_at');

                if ($withTaskDetails) {
                    $taskDetails = $this->getTaskDetails($taskDetails);
                } else {
                    $taskDetails = [];
                }

                // return new structure while keeping original attributes
                return [
                    'taskOccurredAt' => $task->occurred_at,
                    'taskTitle' => $taskTitle,
                    'taskId' => $task->id,
                    'taskDescription' => $taskDescription,
                    'taskLocale' => $task->locale,
                    'taskIsFeatured' => $task->is_featured,
                    'taskIcon' => $task->icon,
                    'taskPrefix' => $task->prefix,
                    'taskUpdatedAt' => $task->updated_at,
                    'scopeId' => $scope->id,
                    'scopeTitle' => $scope->title,
                    'scopeLabel' => $scopeLabel,
                    'scopeIsFeatured' => $scope->is_featured,
                    'scopeColumn' => $scope->column,
                    'scopeSortorder' => $scope->sortorder,
                    'scopeBgcolor' => $scope->bgcolor,
                    'task_details' => $taskDetails,
                ];
            });
        })->sortBy([
            ['taskOccurredAt', 'desc'],
            ['taskTitle', 'asc'],
            ['taskId', 'desc'],
        ])->values();

        if ($maxCount > 0) {
            $collection = $collection->take($maxCount);
            //$collection = $collection->reverse()->take($maxCount)->reverse();
        }

        return $collection->toArray();
    }

    private function getTaskDetails(Collection $taskDetails): array
    {
        $locale = $this->locale;

        $resultArray = [];

        foreach ($taskDetails as $taskDetail) {
            $taskDetailTranslations = $taskDetail->translations->where('locale', $locale)->pluck('value', 'field_name');
            $taskDetailDescription = $taskDetailTranslations->get('description', $taskDetail->description);

            $taskDetailTypeTranslations = $taskDetail->task_detail_type->translations->where('locale', $locale)->pluck('value', 'field_name');
            $taskDetailTypeLabel = $taskDetailTypeTranslations->get('label', $taskDetail->task_detail_type->label);

            $taskDetailEntry['taskDetailId'] = $taskDetail->id;
            $taskDetailEntry['taskDetailTypeId'] = $taskDetail->task_detail_type_id;
            $taskDetailEntry['taskDetailTypeLabel'] = $taskDetailTypeLabel;
            $taskDetailEntry['taskDetailDescription'] = $taskDetailDescription;
            $taskDetailEntry['taskDetailOccurredAt'] = $taskDetail->occurred_at;
            $taskDetailEntry['taskDetailUpdatedAt'] = $taskDetail->updated_at;

            $resultArray[] = $taskDetailEntry;
        }

        return $resultArray;
    }

    private function extractScopeInfo($scope, bool $translated = false): array
    {
        return [
            'scopeId' => $scope->id,
            'scopeTitle' => $scope->title,
            'scopeLabel' => $translated ? $scope->label : $scope->getTranslatedField('label'),
            'scopeIsFeatured' => $scope->is_featured,
            'scopeColumn' => $scope->column,
            'scopeSortorder' => $scope->sortorder,
            'scopeBgcolor' => $scope->bgcolor,
            'scopeLocale' => $scope->locale,
            'scopeCreatedAt' => $scope->created_at,
            'scopeUpdatedAt' => $scope->updated_at,
            'tasks' => [],
        ];
    }

    private function extractTaskInfo($task): array
    {
        return [
            'taskId' => $task->id,
            'taskTitle' => $task->getTranslatedField('title'),
            'taskDescription' => $task->getTranslatedField('description'),
            'taskLocale' => $task->locale,
            'taskIsFeatured' => $task->is_featured,
            'taskIcon' => $task->icon,
            'taskPrefix' => $task->prefix,
            'taskOccurredAt' => $task->occurred_at,
            'taskUpdatedAt' => $task->updated_at,
            'task_details' => [],
        ];
    }

    private function extractTaskDetailInfo($taskDetail): array
    {
        return [
            'taskDetailId' => $taskDetail->id,
            'taskDetailDescription' => $taskDetail->getTranslatedField('description'),
            'taskDetailLocale' => $taskDetail->locale,
            'taskDetailTypeId' => $taskDetail->task_detail_type_id,
            'taskDetailTypeLabel' => $taskDetail->task_detail_type->getTranslatedField('label'),
            'taskDetailOccurredAt' => $taskDetail->occurred_at,
            'taskDetailUpdatedAt' => $taskDetail->updated_at,
        ];
    }

    private function loadProjectDetails(int $projectId, string $view, string $locale, int $scopeId): void
    {
        if (empty(trim($locale)) || empty(trim($view)) || ($projectId <= 0)) {
            return;
        }

        $this->projectId = $projectId;
        $this->view = $view;
        $this->locale = $locale;
        $this->scopeId = $scopeId;

        $this->getProjectDetailsFromDB();
    }

    private function isProjectAndLocaleUnchangedAndDetailsLoaded(int $projectId, string $view, string $locale, int $scopeId): bool
    {
        if (empty(trim($view)) || empty(trim($locale)) || ($projectId <= 0)) {
            return false;
        }

        if ($this->projectId != $projectId || $this->view != $view || $this->locale != $locale || $this->scopeId != $scopeId || ($this->projectDetails->isEmpty())) {
            return false;
        }

        return true;
    }
}
