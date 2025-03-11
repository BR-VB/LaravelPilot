<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\V1\Auth\RegisteredUserController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\WelcomeController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->name('api.v1.')->group(function () {

    //==== Welcome ====
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');

    //==== User ====
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware(['auth:sanctum'])->name('logout');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');;

    Route::middleware(['auth:sanctum'])->group(function () {
        //==== Project ====
        Route::prefix('projects')->name('projects.')->group(function () {
            Route::get('/', [ProjectController::class, 'index'])->name('index');
            Route::post('/', [ProjectController::class, 'store'])->middleware(['isAdminUser'])->name('store');
            Route::get('/search', [ProjectController::class, 'search'])->name('search');
            Route::post('/{project}/report', [ProjectController::class, 'report'])->name('report');
            Route::get('/{project}/{view?}', [ProjectController::class, 'show'])->name('show');
            Route::put('/{project}', [ProjectController::class, 'update'])->middleware(['isAdminUser'])->name('update');
            Route::delete('/{project}', [ProjectController::class, 'destroy'])->middleware(['isAdminUser'])->name('destroy');
        });

        //==== test route: check if user logged in ====
        Route::get('/user', function (Request $request) {
            $user = $request->user();
            $data = [
                "user" => [
                    "id" => $user->id,
                    "is_admin" => $user->is_admin ? true : false,
                    "is_reporting" => $user->is_reporting ? true : false,
                    "name" => $user->name,
                    "email" => $user->email
                ]
            ];
            return apiResponse($data, 'User data retrieved successfully', true, 200);
        });
    });

    //==== Sanctum Token - test route - to get a bearer token for Thunder Client tests ====
    Route::get('/sanctum/token', function () {
        $user = User::find(13);
        if (! $user) {
            return apiResponse(null, 'User not found', false, 404);
        }
        $token = $user->createToken(config('api.sanctum_token_name'))->plainTextToken;

        return apiResponse(['token' => $token], 'Token created successfully', true, 200);
    });

    Route::get('/sanctum/admintoken', function () {
        $user = User::find(14);
        if (! $user) {
            return apiResponse(null, 'User not found', false, 404);
        }
        $token = $user->createToken(config('api.sanctum_token_name'))->plainTextToken;

        return apiResponse(['token' => $token], 'Token created successfully', true, 200);
    });
});
