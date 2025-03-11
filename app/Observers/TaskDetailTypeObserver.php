<?php

namespace App\Observers;

use App\Models\TaskDetailType;
use Illuminate\Support\Facades\Log;

class TaskDetailTypeObserver
{
    /**
     * Handle the TaskDetailType "creating" event.
     *
     * @return void
     */
    public function creating(TaskDetailType $task_detail_type)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $task_detail_type->locale) {
            $task_detail_type->locale = app()->getLocale();
        }
        if (! $task_detail_type->created_at) {
            $task_detail_type->created_at = now();
        }
        if (! $task_detail_type->updated_at) {
            $task_detail_type->updated_at = now();
        }
    }

    /**
     * Handle the TaskDetailType "updating" event.
     *
     * @return void
     */
    public function updating(TaskDetailType $task_detail_type)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $task_detail_type->updated_at = now();
    }
}
