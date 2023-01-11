<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoriesController;
use Tymon\JWTAuth\Facades\JWTAuth;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['api','checkPassword','switchLanguage']], function () {
    Route::post('get-main-categories', [CategoriesController::class, 'index']);
    Route::post('get-category', [CategoriesController::class, 'getCategoryById']);
    Route::post('change-category-status', [CategoriesController::class, 'changeStatus']);

    Route::prefix('admin')->group(function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout'])->middleware(['assignGuard:admin-api']);
    });

    Route::prefix('user')->group(function () {
        Route::post('login', [AuthController::class, 'loginUser']);
    });

    Route::group(['prefix' => 'user' ,'middleware' => 'assignGuard:user-api'],function (){
        Route::post('profile',function(){
            return  Auth::user();
        });
        Route::post('logout', [AuthController::class, 'logoutUser']);
    });


});

