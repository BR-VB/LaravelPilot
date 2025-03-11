<?php

namespace App\Observers;

use App\Models\TaskDetail;
use Illuminate\Support\Facades\Log;

class TaskDetailObserver
{
    /**
     * Handle the TaskDetail "creating" event.
     *
     * @return void
     */
    public function creating(TaskDetail $task_detail)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $task_detail->locale) {
            $task_detail->locale = app()->getLocale();
        }
        if (! $task_detail->created_at) {
            $task_detail->created_at = now();
        }
        if (! $task_detail->updated_at) {
            $task_detail->updated_at = now();
        }
        if (! $task_detail->occurred_at) {
            $task_detail->occurred_at = now();
        }
    }

    /**
     * Handle the TaskDetail "updating" event.
     *
     * @return void
     */
    public function updating(TaskDetail $task_detail)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $task_detail->updated_at = now();
    }
}
