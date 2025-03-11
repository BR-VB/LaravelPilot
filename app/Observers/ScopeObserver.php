<?php

namespace App\Observers;

use App\Models\Scope;
use Illuminate\Support\Facades\Log;

class ScopeObserver
{
    /**
     * Handle the Scope "creating" event.
     *
     * @return void
     */
    public function creating(Scope $scope)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $scope->locale) {
            $scope->locale = app()->getLocale();
        }
        if (! $scope->created_at) {
            $scope->created_at = now();
        }
        if (! $scope->updated_at) {
            $scope->updated_at = now();
        }
    }

    /**
     * Handle the Scope "updating" event.
     *
     * @return void
     */
    public function updating(Scope $scope)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $scope->updated_at = now();
    }
}
