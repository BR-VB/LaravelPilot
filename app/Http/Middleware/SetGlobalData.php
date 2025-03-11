<?php

namespace App\Http\Middleware;

use App\Models\Project;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetGlobalData
{
    public function handle(Request $request, Closure $next): Response
    {
        //
        //Middleware: provide global data - locale, projectId, projectTitle, ...
        //

        //actual language
        $locale = session('locale', config('app.locale'));
        app()->setLocale($locale);
        session(['locale' => $locale]);

        //actual project
        $projectId = session('projectId');

        if (! ($projectId)) {
            $project = Project::where('is_featured', true)->select('id', 'title', 'locale')->orderBy('created_at', 'desc')->first();
            $project = Project::getTranslations($project);
            if (is_null($project)) {
                return response()->json([
                    'error' => __('middleware.featured_project_error'),
                ], 500);
            }
            session(['projectId' => $project->id, 'projectTitle' => $project->title]);
            Log::info(class_basename(self::class), [__('middleware.project_read_from_db', ['project' => $project->id])]);
        } else {
            Log::info(class_basename(self::class), [__('middleware.middleware_executed')]);
        }

        if (Auth::check()) {
            Cookie::queue('userLocale', $locale, 60 * 24 * 30);
            Cookie::queue('userProjectId', session('projectId'), 60 * 24 * 30);
        }

        //next middleware step ...
        return $next($request);
    }
}
