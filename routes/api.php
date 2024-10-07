<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProductController;

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


Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/auth/verification', [AuthController::class, 'sendResetLinkEmail']);
Route::post('/auth/reset-password', [AuthController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->get('/current-user', [AuthController::class, 'currentUser']);

Route::get('/packages', [PackageController::class, 'index']);



Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/products/organization', [ProductController::class, 'getProductByOrganization']);
Route::get('/products/user', [ProductController::class, 'getProductByUser']);
Route::get('/products/package', [ProductController::class, 'getProductByPackage']);
Route::post('/products', [ProductController::class, 'createProduct']);
