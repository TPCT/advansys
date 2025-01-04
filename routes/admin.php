<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\FormsController;
use App\Http\Controllers\admin\OurValuesController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\ServicesController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\SlidersController;
use App\Http\Controllers\admin\SubServicesController;
use App\Http\Controllers\admin\TeamMembersController;
use App\Http\Controllers\admin\BlogsController;
use App\Http\Controllers\admin\TranslationCategoriesController;
use App\Http\Controllers\admin\TranslationsController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Middleware\IsSuperAdmin;

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
            Route::post('update', 'update')->name('admin.profile.update');
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

    Route::prefix('team-members')
        ->controller(TeamMembersController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.team-members.index');
            Route::post('', 'create')->name('admin.team-members.create');
            Route::get('/{team_member}', 'show')->name('admin.team-members.show');
            Route::post('/{team_member}', 'update')->name('admin.team-members.update');
            Route::delete('/{team_member}', 'delete')->name('admin.team-members.delete');
        });

    Route::prefix('blogs')
        ->controller(BlogsController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.blogs.index');
            Route::post('', 'create')->name('admin.blogs.create');
            Route::get('/{blog}', 'show')->name('admin.blogs.show');
            Route::post('/{blog}', 'update')->name('admin.blogs.update');
            Route::delete('/{blog}', 'delete')->name('admin.blogs.delete');
        });

    Route::prefix('forms')
        ->controller(FormsController::class)
        ->group(function () {
           Route::get('contact-us', 'contact_us')->name('admin.forms.contact_us');
           Route::get('newsletters', 'newsletter')->name('admin.forms.newsletters');
        });

    Route::prefix('services')
        ->controller(ServicesController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.services.index');
            Route::post('', 'create')->name('admin.services.create');
            Route::get('/{service}', 'show')->name('admin.services.show');
            Route::post('/{service}', 'update')->name('admin.services.update');
            Route::delete('/{service}', 'delete')->name('admin.services.delete');

            Route::prefix('{service}/sub-services')
                ->controller(SubServicesController::class)
                ->group(function () {
                    Route::get('', 'index')->name('admin.services.sub-services.index');
                    Route::post('', 'create')->name('admin.services.sub-services.create');
                    Route::get('/{sub_service}', 'show')->name('admin.services.sub-services.show');
                    Route::post('/{sub_service}', 'update')->name('admin.services.sub-services.update');
                    Route::delete('/{sub_service}', 'delete')->name('admin.services.sub-services.delete');
                });
        });

    Route::prefix('translations')
        ->group(function () {
            Route::prefix('categories')
                ->controller(TranslationCategoriesController::class)
                ->group(function () {
                    Route::get('', 'index')->name('admin.translations.categories.index');
                    Route::post('', 'create')->name('admin.translations.categories.create');
                    Route::post('/{category}', 'update')->name('admin.translations.categories.update');
                    Route::delete('/{category}', 'delete')->name('admin.translations.categories.delete');
                });

            Route::prefix('categories')
                ->controller(TranslationsController::class)
                ->group(function () {
                    Route::get('/{category}/translations', 'index')->name('admin.translations.categories.translations.index');
                    Route::post('/{category}/translations', 'create')->name('admin.translations.categories.translations.create');
                    Route::post('/{category}/translations/{translation}', 'update')->name('admin.translations.categories.translations.update');
                    Route::delete('/{category}/translations/{translation}', 'delete')->name('admin.translations.categories.translations.delete');
                });
        });

    Route::prefix('management')
        ->middleware([IsSuperAdmin::class])
        ->group(function () {
            Route::prefix('users')
                ->controller(UsersController::class)
                ->group(function () {
                    Route::get('', 'index')->name('admin.management.users.index');
                    Route::post('', 'create')->name('admin.management.users.create');
                    Route::get('/{admin}', 'show')->name('admin.management.users.show');
                    Route::post('/{admin}', 'update')->name('admin.management.users.update');
                    Route::delete('/{admin}', 'delete')->name('admin.management.users.delete');
                });
        });

    Route::prefix('our-values')
        ->controller(OurValuesController::class)
        ->group(function () {
            Route::get('', 'index')->name('admin.our-values.index');
            Route::post('', 'create')->name('admin.our-values.create');
            Route::delete('/{our_value}', 'delete')->name('admin.our-values.delete');
        });
});
