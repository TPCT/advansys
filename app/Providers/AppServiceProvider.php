<?php

namespace App\Providers;

use App\Models\FileExtension;
use App\Models\Language;
use App\Settings\General;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Config::set('app.timezone', app(General::class)->site_timezone);
        \Config::set('app.name', app(General::class)->site_title[config('app.locale')] ?? config('app.name'));
        \Config::set('curator.accepted_file_types', FileExtension::all()->pluck('extension')->toArray());

        if (!in_array(request()->segment(1), [
            'livewire', 'admin', 'storage'
        ]) && app(General::class)->default_locale){
            \Config::set('app.locale', app(General::class)->default_locale);
            \Config::set('translatable.fallback_locale', app(General::class)->default_locale);
            \Config::set('translatable.use_fallback', true);
        }


        if (Language::count()) {
            $languages = Language::all()->toArray();

            \Config::set('app.locales', \Arr::mapWithKeys($languages, function ($value) {
                return [$value['locale'] => $value['language']];
            }));

            \Config::set('translatable.locales', \Arr::mapWithKeys($languages, function ($value) {
                return [$value['language'] => $value['locale']];
            }));

            if (!Language::where('locale', 'en')->count())
                $languages[] = ['locale' => 'en', 'language' => "English", 'flag' => 'us'];

            \Config::set('translation-manager.available_locales', \Arr::map($languages, function ($value) {
                return ['code' => $value['locale'], 'name' => __($value['language']), 'flag' => $value['flag'] ?? null];
            }));
        }

        view()->share('language', app()->getLocale());
    }
}

