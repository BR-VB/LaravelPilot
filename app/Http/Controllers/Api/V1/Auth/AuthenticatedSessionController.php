<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store(LoginRequest $request): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);

        try {
            Log::info($this->className, [__FUNCTION__ => 'start - try - 1']);
            $request->authenticate();
            Log::info($this->className, [__FUNCTION__ => 'start - try - 2']);

            if ($request->hasSession()) { // Prüfen, ob eine Session existiert
                $request->session()->regenerate();
            }

            Log::info($this->className, [__FUNCTION__ => 'start - try - 3']);
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('auth.login_failed_message'),
                'error' => $e->getMessage(),
            ]);

            return apiResponse(
                null,
                __('auth.login_failed_message') . $e->getMessage(),
                false,
                401
            );
        }

        Log::info($this->className, [__FUNCTION__ => 'start - after try - 1']);

        $user = $request->user();
        $token = $user->createToken(config('api.sanctum_token_name'))->plainTextToken;

        $projectLang = $user->default_locale ?? $this->apiLocale;

        //default project for user
        if ($user->default_project_id) {
            $project = Project::where('id', $user->default_project_id)->select('id', 'title', 'locale')->first();
            $project = Project::getTranslations($project, [$projectLang]);
        }

        Log::info($this->className, [__FUNCTION__ => ['end' => $token]]);

        return apiResponse(
            [
                'user' => [
                    "id" => $user->id,
                    "is_admin" => $user->is_admin ? true : false,
                    "is_reporting" => $user->is_reporting ? true : false,
                    "name" => $user->name,
                    "email" => $user->email,
                    "default_locale" => $user->default_locale,
                    "default_project_id" => $user->default_project_id,
                    "default_project_title" => $project->title ?? null
                ],
                'token' => $token
            ],
            __('auth.login_success_message'),
            true,
            200
        );
    }

    public function destroy(Request $request): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);

        try {
            $token = $request->user()->currentAccessToken();

            if ($token instanceof \Laravel\Sanctum\PersonalAccessToken) {
                //used for Thunder Client tests
                $token->delete();

                Log::info($this->className, [__FUNCTION__ => 'end']);

                return apiResponse(
                    null,
                    __('auth.logout_success_message'),
                    200
                )->withCookie(cookie()->forget(env('SESSION_COOKIE_XSRF', 'XSRF-TOKEN')));
            } else {
                //used for SPA requests
                Log::warning($this->className, [
                    __FUNCTION__ => ['no_personal_access_token' => $token],
                ]);

                $request->user()->tokens()->delete();

                $request->session()->invalidate();
                $request->session()->regenerate();
                $request->session()->regenerateToken();

                Cookie::queue(Cookie::forget(env('SESSION_COOKIE_API', 'pn_frontend_session')));
                Cookie::queue(Cookie::forget(env('SESSION_COOKIE_XSRF', 'XSRF-TOKEN')));

                Log::info($this->className, [__FUNCTION__ => 'end']);

                return apiResponse(
                    null,
                    __('auth.logout_success_message'),
                    200
                )->withCookie(cookie()->forget(env('SESSION_COOKIE_XSRF', 'XSRF-TOKEN')));
            }
        } catch (\Exception $e) {
            Log::error($this->className, [
                __FUNCTION__ => __('auth.logout_failed_message'),
                'error' => $e->getMessage(),
            ]);

            return apiResponse(
                null,
                __('auth.logout_failed_message') . $e->getMessage(),
                false,
                401
            );
        }
    }
}
