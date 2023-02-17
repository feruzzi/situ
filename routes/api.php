<?php

use App\Http\Controllers\api\MasterLetterController;
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
Route::get('master-letter/edit/{id}', [MasterLetterController::class, 'edit']);
Route::put('master-letter/update/{id}', [MasterLetterController::class, 'update']);
Route::delete('master-letter/destroy/{id}', [MasterLetterController::class, 'destroy']);
