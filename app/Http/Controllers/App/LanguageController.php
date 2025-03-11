<?php

namespace App\Http\Controllers\App;

use App\Models\Project;
use App\Services\LanguageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class LanguageController extends Controller
{
    public function __construct(protected LanguageService $languageService)
    {
        parent::__construct();
    }

    public function switch(Request $request): RedirectResponse
    {
        //get form input
        $localeNew = $request->input('locale');
        $localeOld = app()->getLocale();

        $languages = $this->languageService->getAvailableLanguages();

        //check input language
        if (in_array($localeNew, $languages)) {
            app()->setLocale($localeNew);
            session(['locale' => $localeNew]);

            if (Auth::check()) {
                Cookie::queue('userLocale', $localeNew, 60 * 24 * 30);
            }

            cache()->forget('teaserTask');

            $project = Project::where('id', session('projectId'))->select('id', 'title', 'locale')->first();
            $project = Project::getTranslations($project);

            session(['projectTitle' => $project->title]);

            Log::info($this->className, [__FUNCTION__ => 'success', 'locale - old' => $localeOld, 'locale - new' => $localeNew]);

            return redirect()->back()->with('success', __('language.success_switch_language'));
        }

        //input language not valid
        Log::error($this->className, [__FUNCTION__ => 'error: ' . __('language.invalid_language')]);

        return redirect()->back()->with('error', __('language.invalid_language'));
    }
}
