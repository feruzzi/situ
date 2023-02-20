<?php

use App\Http\Controllers\api\MasterLetterController;
use App\Http\Controllers\api\LetterController;
use App\Http\Controllers\api\ItemController;
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
Route::get('master-letter', [MasterLetterController::class, 'index']);
Route::post('master-letter/store', [MasterLetterController::class, 'store']);
Route::get('master-letter/show/{id}', [MasterLetterController::class, 'show']);
// Route::get('master-letter/edit/{id}', [MasterLetterController::class, 'edit']);
Route::put('master-letter/update/{id}', [MasterLetterController::class, 'update']);
Route::delete('master-letter/destroy/{id}', [MasterLetterController::class, 'destroy']);

Route::get('letter/{id}', [LetterController::class, 'index']);
Route::post('letter/store', [LetterController::class, 'store']);
Route::get('letter/show/{id}', [LetterController::class, 'show']);
// Route::get('letter/edit/{id}', [LetterController::class, 'edit']);
Route::put('letter/update/{id}', [LetterController::class, 'update']);
Route::post('letter/upload/{id}', [LetterController::class, 'upload']);
Route::delete('letter/destroy/{id}', [LetterController::class, 'destroy']);

Route::get('master-item', [ItemController::class, 'index']);
Route::post('master-item/store', [ItemController::class, 'store']);
Route::get('master-item/show/{id}', [ItemController::class, 'show']);
Route::put('master-item/update/{id}', [ItemController::class, 'update']);
Route::delete('master-item/destroy/{id}', [ItemController::class, 'destroy']);
