<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// Route::group(['prefix' => LaravelLocalization::setLocale()], function(){
Route::prefix(LaravelLocalization::setLocale())->group(function() {

    Route::prefix('admin')->name('admin.')->middleware('auth', 'check', 'verified')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('index');

        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });

    Route::get('/',[SiteController::class,'index'])->name('site.home');
    Route::get('/about',[SiteController::class,'about'])->name('site.about');
    Route::get('/product',[SiteController::class,'shop'])->name('site.shop');
    Route::get('/product_detail/{id}',[SiteController::class,'product_detail'])->name('site.product_detail');
    Route::get('/contact',[SiteController::class,'contact'])->name('site.contact');
    Route::post('/product_detail/{id}/review',[SiteController::class,'review'])->name('site.review');


    // Auth::routes(['register' => false]);
    Auth::routes(['verify' => true]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
