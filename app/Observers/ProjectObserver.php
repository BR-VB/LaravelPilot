<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Facades\Log;

class ProjectObserver
{
    /**
     * Handle the Project "creating" event.
     *
     * @return void
     */
    public function creating(Project $project)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $project->locale) {
            $project->locale = app()->getLocale();
        }
        if (! $project->created_at) {
            $project->created_at = now();
        }
        if (! $project->updated_at) {
            $project->updated_at = now();
        }
    }

    /**
     * Handle the Project "updating" event.
     *
     * @return void
     */
    public function updating(Project $project)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $project->updated_at = now();
    }
}
