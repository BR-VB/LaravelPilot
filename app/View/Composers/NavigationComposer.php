<?php

namespace App\View\Composers;

use App\Services\NavigationService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class NavigationComposer
{
    protected $navigationService;

    public function __construct(NavigationService $navigationService)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $this->navigationService = $navigationService;
    }

    public function compose(View $view)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $view->with('navigation', $this->navigationService->getNavigation());
    }
}
