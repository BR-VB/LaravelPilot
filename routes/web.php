<?php

use App\Http\Controllers\App\AdminController;
use App\Http\Controllers\App\ConfigController;
use App\Http\Controllers\App\LanguageController;
use App\Http\Controllers\App\ProjectController;
use App\Http\Controllers\App\ScopeController;
use App\Http\Controllers\App\TaskController;
use App\Http\Controllers\App\TaskDetailController;
use App\Http\Controllers\App\TaskDetailTypeController;
use App\Http\Controllers\App\TranslationController;
use App\Http\Controllers\App\WelcomeController;
use Illuminate\Support\Facades\Route;

//==== Inertia Page ====
Route::inertia('/about', 'About')->name('about');

//==== Welcome ====
Route::get('/', [WelcomeController::class, 'index'])->name('home');

//==== Language ====
Route::get('language', [LanguageController::class, 'switch'])->name('language.switch');

//==== Project ====
Route::middleware(['auth', 'isAdminUser'])->prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->withoutMiddleware(['isAdminUser'])->name('index');
    Route::get('/switch', [ProjectController::class, 'switch'])->withoutMiddleware(['isAdminUser'])->name('switch');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/', [ProjectController::class, 'store'])->name('store');
    Route::post('/{project}/report', [ProjectController::class, 'report'])->withoutMiddleware(['isAdminUser'])->name('report');
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
    Route::get('/{project}/{view?}', [ProjectController::class, 'show'])->withoutMiddleware(['isAdminUser'])->name('show');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
});

//==== Scope ====
Route::middleware(['auth', 'isAdminUser'])->prefix('scopes')->name('scopes.')->group(function () {
    Route::get('/', [ScopeController::class, 'index'])->name('index');
    Route::get('/create', [ScopeController::class, 'create'])->name('create');
    Route::post('/', [ScopeController::class, 'store'])->name('store');
    Route::get('/{scope}', [ScopeController::class, 'show'])->name('show');
    Route::get('/{scope}/edit', [ScopeController::class, 'edit'])->name('edit');
    Route::put('/{scope}', [ScopeController::class, 'update'])->name('update');
    Route::delete('/{scope}', [ScopeController::class, 'destroy'])->name('destroy');
});

//==== Task ====
Route::middleware(['auth', 'isAdminUser'])->prefix('tasks')->name('tasks.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/create', [TaskController::class, 'create'])->name('create');
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/{task}', [TaskController::class, 'show'])->name('show');
    Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
});

//==== TaskDetail ====
Route::middleware(['auth', 'isAdminUser'])->prefix('task_details')->name('task_details.')->group(function () {
    Route::get('/', [TaskDetailController::class, 'index'])->name('index');
    Route::get('/create', [TaskDetailController::class, 'create'])->name('create');
    Route::post('/', [TaskDetailController::class, 'store'])->name('store');
    Route::get('/{task_detail}', [TaskDetailController::class, 'show'])->name('show');
    Route::get('/{task_detail}/edit', [TaskDetailController::class, 'edit'])->name('edit');
    Route::put('/{task_detail}', [TaskDetailController::class, 'update'])->name('update');
    Route::delete('/{task_detail}', [TaskDetailController::class, 'destroy'])->name('destroy');
});

//==== TaskDetailType ====
Route::middleware(['auth', 'isAdminUser'])->prefix('task_detail_types')->name('task_detail_types.')->group(function () {
    Route::get('/', [TaskDetailTypeController::class, 'index'])->name('index');
    Route::get('/create', [TaskDetailTypeController::class, 'create'])->name('create');
    Route::post('/', [TaskDetailTypeController::class, 'store'])->name('store');
    Route::get('/{task_detail_type}', [TaskDetailTypeController::class, 'show'])->name('show');
    Route::get('/{task_detail_type}/edit', [TaskDetailTypeController::class, 'edit'])->name('edit');
    Route::put('/{task_detail_type}', [TaskDetailTypeController::class, 'update'])->name('update');
    Route::delete('/{task_detail_type}', [TaskDetailTypeController::class, 'destroy'])->name('destroy');
});

//==== Translation ====
Route::middleware(['auth', 'isAdminUser'])->prefix('translations')->name('translations.')->group(function () {
    Route::get('/', [TranslationController::class, 'index'])->name('index');
    Route::get('/{table_name}/{record_id}/{field_name?}', [TranslationController::class, 'translate'])->name('translate');
    Route::post('/{table_name}/{record_id}/{field_name?}', [TranslationController::class, 'save'])->name('save');
    Route::delete('/{translation}', [TranslationController::class, 'destroy'])->name('destroy');
});

//ToDo: Admin & Config - ====
Route::middleware(['auth', 'isAdminUser'])->get('/admin', [AdminController::class, 'index'])->name('admin');
Route::middleware(['auth', 'isAdminUser'])->get('/config', [ConfigController::class, 'index'])->name('config');
//ToDo: Admin & Config - ====

//==== Login, Register, Profile, ... ====
require __DIR__.'/auth.php';
