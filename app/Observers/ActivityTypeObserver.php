<?php

namespace App\Observers;

use App\Models\ActivityType;
use Illuminate\Support\Facades\Log;

class ActivityTypeObserver
{
    /**
     * Handle the ActivityType "creating" event.
     *
     * @return void
     */
    public function creating(ActivityType $activity_type)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $activity_type->locale) {
            $activity_type->locale = app()->getLocale();
        }
        if (! $activity_type->created_at) {
            $activity_type->created_at = now();
        }
        if (! $activity_type->updated_at) {
            $activity_type->updated_at = now();
        }
    }

    /**
     * Handle the ActivityType "updating" event.
     *
     * @return void
     */
    public function updating(ActivityType $activity_type)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $activity_type->updated_at = now();
    }
}
