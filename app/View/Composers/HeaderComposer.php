<?php

namespace App\View\Composers;

use App\Services\LanguageService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class HeaderComposer
{
    protected $languageService;

    public function __construct(LanguageService $languageService)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $this->languageService = $languageService;
    }

    public function compose(View $view)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $view->with('languages', $this->languageService->getAvailableLanguages());
    }
}
