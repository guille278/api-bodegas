<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BillingController;
use App\Http\Controllers\api\StorageController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\CheckoutController;
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

Route::prefix("/auth")->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::middleware("auth:sanctum")->get("/me", [AuthController::class, "me"]);
    Route::middleware("auth:sanctum")->get("/logout", [AuthController::class, "logout"]);
});

Route::get("/categories", [CategoryController::class, "index"]);
Route::get("/storages/{id}", [StorageController::class, "find"]);
Route::get("/storages/category/{category_id}", [StorageController::class, "findByCategory"]);

Route::get("/checkout/{storage_id}/{plan_id}", [CheckoutController::class, "resume"]);
Route::middleware("auth:sanctum")->post("/checkout", [CheckoutController::class, "checkout"]);
Route::middleware("auth:sanctum")->get("/billing", [BillingController::class, "index"]);
