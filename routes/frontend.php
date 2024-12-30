<?php
    use App\Http\Controllers\frontend\FrontendController;

    Route::controller(FrontendController::class)
        ->group(function (){
            Route::get('/home', 'home')->name('frontend.home');
            Route::get('/services/{service}', 'service')->name('frontend.services');
            Route::any('/contact-us', 'contact_us')->name('frontend.contact');
            Route::get('/about-us', 'about_us')->name('frontend.about');
            Route::get('/settings', 'settings')->name('frontend.settings');
        });