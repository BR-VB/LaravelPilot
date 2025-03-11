<?php

namespace App\Providers;

use App\Services\LanguageService;
use App\Services\NavigationService;
use App\Services\ProjectService;
use App\Services\ScopeService;
use App\Services\TaskDetailService;
use App\Services\TaskDetailTypeService;
use App\Services\TaskService;
use App\Services\TeaserService;
use App\Services\WelcomeService;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //use other session for frontend / api
        $request = $this->app['request'];
        if ($request->is('api/*') || $request->is('sanctum/*')) {
            Config::set('session.cookie', env('SESSION_COOKIE_API', 'pn_frontend_session'));
        }

        //register singletons
        $this->app->singleton(LanguageService::class, function ($app) {
            return new LanguageService;
        });

        $this->app->singleton(NavigationService::class, function ($app) {
            return new NavigationService;
        });

        $this->app->singleton(ProjectService::class, function ($app) {
            return new ProjectService;
        });

        $this->app->singleton(ScopeService::class, function ($app) {
            return new ScopeService;
        });

        $this->app->singleton(TaskDetailService::class, function ($app) {
            return new TaskDetailService($app->make(ScopeService::class), $app->make(TaskDetailTypeService::class));
        });

        $this->app->singleton(TaskDetailTypeService::class, function ($app) {
            return new TaskDetailTypeService();
        });

        $this->app->singleton(TaskService::class, function ($app) {
            return new TaskService($app->make(ScopeService::class));
        });

        $this->app->singleton(TeaserService::class, function ($app) {
            return new TeaserService;
        });

        $this->app->singleton(WelcomeService::class, function ($app) {
            return new WelcomeService;
        });

        Log::info(class_basename(self::class), [__FUNCTION__]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //define new blade directive: @required($required)
        Blade::directive('required', function ($expression) {
            return "<?php echo $expression ? 'required' : ''; ?>";
        });

        //do not wrap json responses with an additional data component
        JsonResource::withoutWrapping();

        Log::info(class_basename(self::class), [__FUNCTION__]);
    }
}
