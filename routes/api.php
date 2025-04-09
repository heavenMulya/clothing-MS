<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Category\ManageCategory;
use App\Http\Controllers\purchase\managePurchase;
use App\Http\Controllers\purchase\managesales;
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

Route::resource('/category', ManageCategory::class);
Route::resource('/purchase', managePurchase::class);
Route::resource('/sales', managesales::class);

