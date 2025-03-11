<?php

namespace App\Http\Controllers\App\Auth;

use App\Http\Controllers\App\Controller;
use App\Http\Requests\App\Auth\LoginRequest;
use App\Models\Project;
use App\Services\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    public function __construct(protected LanguageService $languageService)
    {
        parent::__construct();
    }

    /**
     * Handle an incoming authentication request
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);
        $request->authenticate();
        $request->session()->regenerate();

        $this->initUserEnv($request);

        Log::info($this->className, [__FUNCTION__ => 'end']);

        return redirect()->route('home')->withSuccess(__('auth.login_success_message'));
    }

    /**
     * Destroy an authenticated session
     */
    public function destroy(Request $request): RedirectResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Log::info($this->className, [__FUNCTION__ => 'end']);

        return redirect()->route('home')->withSuccess(__('auth.logout_success_message'));
    }

    //Private Functions
    private function initUserEnv(LoginRequest $request): void
    {
        $user = Auth::user();

        $cookieLocale = Cookie::get('userLocale') ?? ($user->default_locale ?? app()->getLocale()) ?? 'en';
        $cookieProjectId = Cookie::get('userProjectId') ?? ($user->default_project_id ?? session('projectId')) ?? '';

        $existingLocales = $this->languageService->getAvailableLanguages();
        if (! in_array($cookieLocale, $existingLocales, true)) {
            $cookieLocale = app()->getLocale() ?? 'en';
        }

        $localeChanged = $cookieLocale !== app()->getLocale();
        $projectChanged = $cookieProjectId && $cookieProjectId !== session('projectId');

        if ($localeChanged) {
            app()->setLocale($cookieLocale);
            session(['locale' => $cookieLocale]);
        }

        if ($localeChanged || $projectChanged) {
            cache()->forget('teaserTask');

            $projectId = $projectChanged ? $cookieProjectId : session('projectId');
            if ($projectId) {
                $project = Project::where('id', $projectId)->select('id', 'title', 'locale')->first();
                if ($project) {
                    $project = Project::getTranslations($project);
                    session(['projectId' => $projectId, 'projectTitle' => $project->title]);
                }
            }
        }

        Cookie::queue('userLocale', $cookieLocale, 60 * 24 * 30);
        Cookie::queue('userProjectId', $cookieProjectId, 60 * 24 * 30);
    }
}
