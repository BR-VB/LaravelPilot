<?php

namespace App\Observers;

use App\Models\Translation;
use Illuminate\Support\Facades\Log;

class TranslationObserver
{
    /**
     * Handle the Translation "creating" event.
     *
     * @return void
     */
    public function creating(Translation $translation)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        if (! $translation->created_at) {
            $translation->created_at = now();
        }
        if (! $translation->updated_at) {
            $translation->updated_at = now();
        }
    }

    /**
     * Handle the Translation "updating" event.
     *
     * @return void
     */
    public function updating(Translation $translation)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);

        $translation->updated_at = now();
    }
}
