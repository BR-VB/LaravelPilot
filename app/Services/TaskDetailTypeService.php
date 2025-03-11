<?php

namespace App\Services;

use App\Models\TaskDetailType;
use Illuminate\Support\Collection;

class TaskDetailTypeService
{
    //create a new class instance
    public function __construct()
    {
        //
    }

    //task detail types list - sorted by label
    public function getTaskDetailTypes(): Collection
    {
        $task_detail_types = TaskDetailType::select('id', 'label', 'locale')->get();
        $task_detail_types = TaskDetailType::getTranslations($task_detail_types);

        return $task_detail_types->sortBy('label')->pluck('label', 'id');
    }
}
