<?php

namespace App\Providers;

use App\View\Composers\FooterComposer;
use App\View\Composers\HeaderComposer;
use App\View\Composers\NavigationComposer;
use App\View\Composers\TeaserComposer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.header', HeaderComposer::class);
        View::composer('layouts.footer', FooterComposer::class);
        View::composer(['layouts.navigation', 'layouts.breadcrumb'], NavigationComposer::class);
        View::composer('layouts.teaser', TeaserComposer::class);

        Log::info(class_basename(self::class), [__('service.view_composer_boot')]);
    }
}
