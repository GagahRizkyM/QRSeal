<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FillPDFController;
use App\Http\Controllers\GenerateQRController;
use App\Http\Controllers\RsaController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\PreviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::middleware(['logged'])->group(function () {
// });
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/auth', [AuthController::class, 'auth'])->name('auth');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('post-register');


Route::get('/upload', function () {
    return view('tervalidasi');
});


Route::post('/store-generate-qr', [GenerateQRController::class, 'store'])->name('store.generate.qr');

Route::post('/process_certificate', [FillPDFController::class, 'process'])->name('process_certificate');

Route::get('/create_certificate', [FillPDFController::class, 'create'])->name('create_certificate');
Route::get('/document', function () {
    return view('document');
});

Route::get('/admin', [AdminController::class, 'index']);


Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    Route::get('/generate-qr', [GenerateQRController::class, 'index'])->name('generate-qr');
    Route::post('/proses-qr', [GenerateQRController::class, 'create'])->name('proses-qr');
    Route::get('/preview/{id}', [PreviewController::class, 'index'])->name('preview');

});
Route::get('/encrypt', [RsaController::class, 'encrypt']);
Route::get('/decrypt', [RsaController::class, 'decrypt']);
Route::get('/scan', [ScanController::class, 'scan'])->name('scan');
Route::get('/test-encryption', [RsaController::class, 'testEncryptionDecryption']);
Route::get('test', fn () => phpinfo());

