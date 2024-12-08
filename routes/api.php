<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;

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

//Before Login Api Routes
Route::post("register",[ApiController::class,"register"]);
Route::post("login",[ApiController::class,"login"]);

Route::prefix('user')->group(function () {
    Route::get('/items/search', [ApiController::class, 'searchCategory']);
    Route::get('/items', [ApiController::class, 'getUserDashboard']);
    Route::get('/categories', [ApiController::class, 'getUserCategory']);
    Route::get('/items/{id}', [ApiController::class, 'showItemDetail']);
});

//After login Api Routes
Route::group(["middleware" => ["auth:api"]], function(){
    Route::get("profile",[ApiController::class,"profile"]);
    Route::get("refresh",[ApiController::class,"refresh"]);
    Route::get("logout",[ApiController::class,"logout"]);

    Route::get('/categories', [ApiController::class, 'getAdminCategory']);
    Route::post("/categories", [ApiController::class, 'storeAdminCategory']);
    Route::get('/categories/{id}', [ApiController::class, 'editAdminCategory']);
    Route::put('/categories/{id}', [ApiController::class, 'updateAdminCategory']);
    Route::delete('/categories/{id}', [ApiController::class, 'destroyAdminCategory']);

    Route::get('/items', [ApiController::class, 'getAdminItem']);
    Route::post("/items", [ApiController::class, 'storeAdminItem']);
    Route::get('/items/{id}', [ApiController::class, 'editAdminItem']);
    Route::put('/items/{id}', [ApiController::class, 'updateAdminItem']);
    Route::delete('/items/{id}', [ApiController::class, 'deleteAdminItem']);
});
