<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', [PagesController::class, 'index']);
Route::get('/master-letters', [PagesController::class, 'master_letters']);
Route::get('/master-items', [PagesController::class, 'master_items']);
Route::get('/letters/{type}/{id}', [PagesController::class, 'letters']);
