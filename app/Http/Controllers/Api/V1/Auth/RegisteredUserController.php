<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Api\V1\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function store(LoginRequest $request): JsonResponse
    {
        Log::info($this->className, [__FUNCTION__ => 'start']);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        //stateless api request do not habe a session
        if ($request->hasSession()) {
            //new session ID
            $request->session()->regenerate();

            //new CSRF token
            $request->session()->regenerateToken();
        }

        $projectLang = $user->default_locale ?? $this->apiLocale;

        //default project for user
        if ($user->default_project_id) {
            $project = Project::where('id', $user->default_project_id)->select('id', 'title', 'locale')->first();
            $project = Project::getTranslations($project, [$projectLang]);
        }

        //new sanctum token (bearer token)
        $success['token'] = $user->createToken(config('api.sanctum_token_name'))->plainTextToken;
        $success['user'] = [
            "id" => $user->id,
            "is_admin" => $user->is_admin ? true : false,
            "is_reporting" => $user->is_reporting ? true : false,
            "name" => $user->name,
            "email" => $user->email,
            "default_locale" => $user->default_locale,
            "default_project_id" => $user->default_project_id,
            "default_project_title" => $project->title ?? null
        ];

        Log::info($this->className, [__FUNCTION__ => 'end']);

        return apiResponse(
            $success,
            __('auth.register_success_message'),
            true,
            201
        );
    }
}
