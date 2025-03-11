<?php

namespace App\Observers;

use App\Models\Task;
use Illuminate\Support\Facades\Log;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     *
     * @return void
     */
    public function creating(Task $task)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $task->locale) {
            $task->locale = app()->getLocale();
        }
        if (! $task->created_at) {
            $task->created_at = now();
        }
        if (! $task->updated_at) {
            $task->updated_at = now();
        }
        if (! $task->occurred_at) {
            $task->occurred_at = now();
        }
    }

    /**
     * Handle the Task "updating" event.
     *
     * @return void
     */
    public function updating(Task $task)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $task->updated_at = now();
    }
}
