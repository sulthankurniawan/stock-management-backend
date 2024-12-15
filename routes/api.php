<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\StockEntryController;
use App\Http\Controllers\Api\StockLedgerController;

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

Route::prefix('items')->group(function () {
    Route::get('/', [ItemController::class, 'index']);
    Route::post('/', [ItemController::class, 'store']);
});

Route::prefix('stock-entries')->group(function () {
    Route::get('/', [StockEntryController::class, 'index']);
    Route::post('/', [StockEntryController::class, 'store']);
});

Route::get('stock-ledger', [StockLedgerController::class, 'index']);
