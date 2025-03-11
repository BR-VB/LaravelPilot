<?php

namespace App\View\Composers;

use App\Services\TeaserService;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TeaserComposer
{
    protected TeaserService $teaserService;

    public function __construct(TeaserService $teaserService)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $this->teaserService = $teaserService;
    }

    public function compose(View $view)
    {
        Log::info(class_basename(self::class), [__FUNCTION__]);
        $view->with('teaserInfo', $this->teaserService->getTeaserInfo());
    }
}
