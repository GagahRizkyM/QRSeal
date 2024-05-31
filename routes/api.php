<?php

use App\Http\Controllers\RsaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/encrypt', [RsaController::class, 'encrypt']);
Route::post('/decrypt', [RsaController::class, 'decrypt']);
Route::post('/test-encryption', [RsaController::class, 'testEncryptionDecryption']);