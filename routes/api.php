<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//GET
Route::get('product/list',[RouteController::class,'productList']);
Route::get('category/list',[RouteController::class,'categoryList']);
Route::get('user/list',[RouteController::class,'userList']);
Route::get('cart/list',[RouteController::class,'cartList']);
Route::get('contact/list',[RouteController::class,'contactList']);
Route::get('order/list',[RouteController::class,'orderList']);
Route::get('order',[RouteController::class,'order']);

//POST
Route::post('create/category',[RouteController::class,'categoryCreate']);
Route::post('create/contact',[RouteController::class,'contactCreate']);

//Delete
Route::post('category/delete',[RouteController::class,'deleteCategory']);

//Detail
Route::get('category/details/{id}',[RouteController::class,'categoryDetails']);

Route::post('category/update',[RouteController::class,'updateCategory']);
