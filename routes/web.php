<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\CartController;
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
        Route::resource('roles', RoleController::class);
    });

    Route::get('/',[SiteController::class,'index'])->name('site.home');
    Route::get('/about',[SiteController::class,'about'])->name('site.about');
    Route::get('/product',[SiteController::class,'shop'])->name('site.shop');
    Route::get('/product_detail/{id}',[SiteController::class,'product_detail'])->name('site.product_detail');
    Route::get('/contact',[SiteController::class,'contact'])->name('site.contact');

    Route::post('/product_detail/{id}/review',[SiteController::class,'review'])->name('site.review');


    Route::post('/add-to-cart',[CartController::class,'add_to_cart'])->name('site.add_to_cart');
    Route::get('/cart',[CartController::class,'carts'])->name('site.carts')->middleware('auth');
    Route::get('/checkout',[CartController::class,'checkout'])->name('site.checkout')->middleware('auth');
    Route::get('/payment',[CartController::class,'payment'])->name('site.payment')->middleware('auth');

    Route::view('/payment/success','site.success')->name('site.payment_success');
    Route::view('/payment/fail','site.fail')->name('site.payment_fail');




    // Auth::routes(['register' => false]);
    Auth::routes(['verify' => true]);

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});
