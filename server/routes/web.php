<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PdfController;
use App\Mail\Gmail;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/gmail', function () {
    return new Gmail();
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/password-reset/{token_name}/{id}', [PasswordResetController::class, 'index']);
Route::put('/password-reset/{token_name}/{id}', [PasswordResetController::class, 'store']);
Route::get('/pdf/admission', [PdfController::class, 'admission_letter']);
Route::get('/pdf/transaction', [PdfController::class, 'transaction']);
Route::get('/pdf/form_b', [PdfController::class, 'form_b']);
Route::get('/pdf/ca', [PdfController::class, 'ca']);
Route::get('/pdf/exam', [PdfController::class, 'exam']);
