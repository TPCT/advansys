<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\SlidersController;

Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login')->name('admin.login');
        Route::delete('logout', 'logout')->name('admin.logout')->middleware('auth:admin');
    });

Route::middleware(['auth:admin'])->group(function () {
    Route::prefix('profile')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('me', 'me')->name('admin.profile.me');
            Route::put('update', 'update')->name('admin.profile.update');
        });

    Route::prefix('settings')
        ->controller(SettingsController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.settings.index');
            Route::post('update', 'update')->name('admin.settings.update');
        });

    Route::prefix('sliders')
        ->controller(SlidersController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.sliders.index');
            Route::any('/hero', 'hero')->name('admin.sliders.hero');
            Route::any('/hero/{id}', 'hero')->name('admin.sliders.hero_update');
            Route::any('/projects', 'projects')->name('admin.sliders.projects');
            Route::any('/projects/{id}', 'projects')->name('admin.sliders.projects_update');
            Route::any('/feedbacks', 'feedbacks')->name('admin.sliders.feedbacks');
            Route::any('/feedbacks/{id}', 'feedbacks')->name('admin.sliders.feedbacks_update');
            Route::any('/partners', 'partners')->name('admin.sliders.partners');
            Route::any('/partners/{id}', 'partners')->name('admin.sliders.partners_update');
        });
});
