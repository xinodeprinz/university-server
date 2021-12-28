<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Auth\RegisterController; // 242 360 677
use App\Http\Controllers\CourseRegistration;

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

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/login', [RegisterController::class, 'login']);

Route::post('/sms', [SMSController::class, 'send']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', [StudentsController::class, 'getUser']);
    Route::post('/logout', [StudentsController::class, 'logout']);
    Route::post('/school-fee', [PaymentController::class, 'schoolFee']);
    Route::post('/dummy-school-fee', [PaymentController::class, 'dummySchoolFee']);
    Route::get('/has-paid-fee', [PaymentController::class, 'hasPaidFee']);
    Route::post('/update-profile-photo', [StudentsController::class, 'updateProfilePhoto']);
    Route::post('/check-current-password', [StudentsController::class, 'checkCurrentPassword']);
    Route::post('/update-password', [StudentsController::class, 'updatePassword']);
});

Route::post('/upload-courses', [CourseRegistration::class, 'store']);