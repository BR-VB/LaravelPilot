<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class LanguageService
{
    protected ?array $languages = null;

    public function getAvailableLanguages(): array
    {
        if ($this->languages === null) {
            $this->languages = cache('languages') ?? [];

            if (count($this->languages) > 0) {
                Log::info(class_basename(self::class), [__('language.languages_from_cache') => $this->languages]);
            } else {
                $langPath = base_path('lang');

                if (! File::isDirectory($langPath)) {
                    $this->languages = [config('app.locale')];
                    Log::info(class_basename(self::class), [__('language.languages_from_config') => $this->languages]);
                } else {
                    $this->languages = array_map('basename', File::directories($langPath));
                    Log::info(class_basename(self::class), [__('language.languages_from_file') => $this->languages]);
                }

                cache(['languages' => $this->languages], now()->addMinutes(15));
            }
        }

        Log::info(class_basename(self::class), [__('language.languages_from_singleton') => $this->languages]);

        return $this->languages;
    }
}
