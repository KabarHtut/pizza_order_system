<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\User\AjaxController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// login / Auth
Route::middleware(['admin_auth'])->group(function () {
    Route::redirect('/', 'loginPage');

    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');

    //register / Auth

    Route::get('registerPage',[AuthController::class,'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {

    //dashboard
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');


    // admin
    Route::middleware(['admin_auth'])->group(function () {
        //category
        Route::prefix('category')->group(function () {
        Route::get('list',[CategoryController::class,'list'])->name('category#list');
        Route::get('create/page',[CategoryController::class,'createPage'])->name('category#createPage');
        Route::post('create',[CategoryController::class,'create'])->name('categroy#create');
        Route::get('delete/{id}',[CategoryController::class,'delete'])->name('category#delete');
        Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category#edit');
        Route::post('update',[CategoryController::class,'update'])->name('category#update');
    });

        //admin account
        Route::prefix('admin')->group(function(){
            //change password
            Route::get('password/changePage',[AdminController::class,'changePasswordPage'])->name('admin#passwordChangePage');
            Route::post('change/password',[AdminController::class,'changePassword'])->name('admin#changePassword');

            //account
            Route::get('details',[AdminController::class,'details'])->name('admin#details');

            //admin account edit

            Route::get('edit',[AdminController::class,'edit'])->name('admin#edit');

            //admin update

            Route::post('update/{id}',[AdminController::class,'update'])->name('admin#update');

            //admin list

            Route::get('list',[AdminController::class,'list'])->name('admin#list');

            //delete account

            Route::get('delete/{id}',[AdminController::class,'delete'])->name('admin#delete');

            //change

            Route::get('change',[AdminController::class,'changeRole'])->name('admin#changeRole');
        });

        //product pizza
        Route::prefix('product')->group(function(){
            Route::get('pizzaList',[ProductController::class,'pizzaList'])->name('product#list');
            Route::get('create',[ProductController::class,'createPage'])->name('product#createPage');
            Route::post('create',[ProductController::class,'create'])->name('product#create');
            Route::get('delete/{id}',[ProductController::class,'delete'])->name('product#delete');
            Route::get('edit/{id}',[ProductController::class,'edit'])->name('product#edit');
            Route::get('updatePage/{id}',[ProductController::class,'updatePage'])->name('product#updatePage');
            Route::post('update',[ProductController::class,'update'])->name('product#update');
        });

        //order pizza
        Route::prefix('order')->group(function(){
            Route::get('list',[OrderController::class,'orderList'])->name('admin#orderList');
            Route::get('change/status',[OrderController::class,'changeStatus'])->name('admin#changeStatus');
            Route::get('ajax/change/status',[OrderController::class,'ajaxChangeStatus'])->name('admin#ajaxChangeStatus');
            Route::get('listInfo/{orderCode}',[OrderController::class,'listInfo'])->name('admin#listInfo');
        });

        //user
        Route::prefix('user')->group(function(){
            Route::get('list',[UserController::class,'userList'])->name('admin#userList');
            Route::get('change/role',[UserController::class,'userChangeRole'])->name('admin#userChangeRole');
            Route::get('edit/{id}',[UserController::class,'userEdit'])->name('admin#userEdit');
            Route::post('update',[UserController::class,'userUpdate'])->name('admin#userUpdate');
            Route::get('delete/{id}',[UserController::class,'userDelete'])->name('admin#userDelete');
        });

        //contact
        Route::prefix('contact')->group(function(){
            Route::get('list',[ContactController::class,'contactList'])->name('admin#contactList');
        });
    });


    //user
    //home
    Route::prefix('user')->middleware('user_auth')->group(function () {
         Route::get('homePage',[UserController::class,'home'])->name('user#home');
         Route::get('filter/{id}',[UserController::class,'filter'])->name('user#filter');
         Route::get('/history',[UserController::class,'history'])->name('user#history');

         Route::prefix('pizza')->group(function(){
            Route::get('details/{id}',[UserController::class,'details'])->name('pizza#details');
         });

         Route::prefix('cart')->group(function(){
            Route::get('list',[UserController::class,'cartList'])->name('user#cartList');
         });

         Route::prefix('password')->group(function(){
            Route::get('changePage',[UserController::class,'passwordChangePage'])->name('user#passwordChangePage');
            Route::post('changePage',[UserController::class,'changePassword'])->name('user#passwordChange');
         });

         Route::prefix('account')->group(function(){
            Route::get('edit',[UserController::class,'edit'])->name('user#edit');
            Route::post('update/{id}',[UserController::class,'update'])->name('user#update');
         });

         Route::prefix('ajax')->group(function(){
            Route::get('pizza/list',[AjaxController::class,'list'])->name('ajax#pizzaList');
            Route::get('cart',[AjaxController::class,'addToCart'])->name('ajax#addToCart');
            Route::get('order',[AjaxController::class,'order'])->name('ajax#order');
            Route::get('clear/cart',[AjaxController::class,'clearCart'])->name('ajax#clearCart');
            Route::get('clear/current/product',[AjaxController::class,'clearCurrentProduct'])->name('ajax#clearCurrentProduct');
            Route::get('increase/viewCount',[AjaxController::class,'increaseViewCount'])->name('ajax#increaseViewCount');
         });

         Route::prefix('contact')->group(function(){
            Route::get('message',[ContactController::class,'contactMessage'])->name('user#contactMessage');
            Route::post('sent',[ContactController::class,'sent'])->name('user#sent');
         });
    });
});
