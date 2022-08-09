<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\StatisticsController;
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

Route::resource('items',ItemController::class)->only(['index', 'store', 'show', 'update']);

Route::group([
                'prefix' => 'statistics'
            ],function(){
    Route::get('count_items',[StatisticsController::class,'countItems']);
    Route::get('average_price',[StatisticsController::class,'getItemsAveragePrice']);
    Route::get('sum_price_this_month',[StatisticsController::class,'getItemsTotalPriceThisMonth']);

});

