<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Log;

class ActivityLogObserver
{
    /**
     * Handle the ActivityLog "creating" event.
     *
     * @return void
     */
    public function creating(ActivityLog $activity_log)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $activity_log->locale) {
            $activity_log->locale = app()->getLocale();
        }
        if (! $activity_log->created_at) {
            $activity_log->created_at = now();
        }
        if (! $activity_log->updated_at) {
            $activity_log->updated_at = now();
        }
    }

    /**
     * Handle the ActivityLog "updating" event.
     *
     * @return void
     */
    public function updating(ActivityLog $activity_log)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $activity_log->updated_at = now();
    }
}
