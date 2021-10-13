<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|-------------------------------------------------------------- ------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// destroy action should not be here, just for now
Route::apiResource("products", ProductController::class)->only(['index', 'store', 'destroy']);

// should not be here (accessible via console), just for now
Route::apiResource("categories", CategoryController::class)->only(['store', 'destroy']);
