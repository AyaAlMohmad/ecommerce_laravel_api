<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\Role\RoleUserController;
use App\Http\Controllers\Api\Role\UserController;
use App\Http\Controllers\Api\Store\CategoryController;
use App\Http\Controllers\Api\Store\ProductController;
use App\Http\Controllers\Api\Store\SubCategoryController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([

    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/user_profile', [AuthController::class, 'userProfile'])->middleware('auth:sanctum');
    Route::put('/user_update/{id}', [UserController::class, 'update'])->middleware('auth:sanctum');
});
Route::group([
    'middleware' => ['auth:sanctum', 'chekUser:admin'],
    // 'middleware' => 'auth:sanctum',
    'prefix' => 'admin'
], function () {
    Route::resource('/products', ProductController::class);
    Route::get('/products/showsoft', [ProductController::class, 'showsoft']);
    Route::post('/products/restor/{id}', [ProductController::class, 'restor']);
    Route::post('/products/finldelet/{id}', [ProductController::class, 'finldelet']);

    Route::resource('/subCategories', SubCategoryController::class);
    Route::get('/subCategories/showsoft', [SubCategoryController::class, 'showsoft']);
    Route::post('/subCategories/restor/{id}', [SubCategoryController::class, 'restor']);
    Route::post('/subCategories/finldelet/{id}', [SubCategoryController::class, 'finldelet']);


    Route::resource('/categories', CategoryController::class);
    Route::get('/categories/showsoft', [CategoryController::class, 'showsoft']);
    Route::post('/categories/restor/{id}', [CategoryController::class, 'restor']);
    Route::post('/categories/finldelet/{id}', [CategoryController::class, 'finldelet']);

    Route::resource('/Users', UserController::class);

    Route::resource('/roles', RoleController::class);
    Route::get('/roles/showsoft', [RoleController::class, 'showsoft']);
    Route::post('/roles/restor/{id}', [RoleController::class, 'restor']);
    Route::post('/roles/finldelet/{id}', [RoleController::class, 'finldelet']);


    Route::resource('/rolesUser', RoleUserController::class);
    Route::get('/rolesUser/showsoft', [RoleUserController::class, 'showsoft']);
    Route::post('/rolesUser/restor/{id}', [RoleUserController::class, 'restor']);
    Route::post('/rolesUser/finldelet/{id}', [RoleUserController::class, 'finldelet']);



    Route::get('/get_subcatgories/{id}', [CategoryController::class, 'getSubcategories']);
    Route::get('/allWithSub', [CategoryController::class, 'allWithSub']);
    Route::get('/subcategories/products', [SubcategoryController::class, 'allWithProducts']);

    Route::get('/subcategories/{id}/products', [ProductController::class, 'subcategoryProducts']);
    Route::get('/categories/products', [CategoryController::class, 'products']);
});
