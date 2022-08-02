<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SMSController;
use App\Http\Controllers\Auth\RegisterController; // 242 360 677
use App\Http\Controllers\CourseRegistration;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\AdminController;

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
Route::post('/sms', [SMSController::class, 'sendSMS']);
Route::post('/gmail', [SMSController::class, 'sendGmail']);
Route::get('/faculty', [DashboardController::class, 'facultyData']);
Route::get('/department', [DashboardController::class, 'departmentData']);
Route::post('/admin-password', [DashboardController::class, 'checkPassword']);
Route::get('/departments/{id}', [DashboardController::class, 'departments']);
Route::get('/faculty/all', [DashboardController::class, 'getFaculties']);
Route::get('/ca-courses/{dept_id}', [CourseRegistration::class, 'coursesForCAUpload']);
Route::post('/upload-ca', [CourseRegistration::class, 'uploadCA']);
Route::post('/upload-exam', [CourseRegistration::class, 'uploadExam']);
Route::post('/forgot-password', [PasswordResetController::class, 'forgotPassword']);

//testing route
Route::post('/testing', [PaymentController::class, 'testing']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/courses/{dept_id}', [CourseRegistration::class, 'departmentCourses']);
    Route::get('/user', [StudentsController::class, 'getUser']);
    Route::get('/logout', [StudentsController::class, 'logout']);
    Route::post('/update-profile-photo', [StudentsController::class, 'updateProfilePhoto']);
    Route::post('/check-current-password', [StudentsController::class, 'checkCurrentPassword']);
    Route::post('/update-password', [StudentsController::class, 'updatePassword']);
    Route::post('/courses/register', [CourseRegistration::class, 'register']);
    Route::get('/registered-courses', [CourseRegistration::class, 'registeredCourses']);
    Route::delete('/delete-course/{code}', [CourseRegistration::class, 'deleteCourse']);
    Route::get('/ca-results', [CourseRegistration::class, 'getCAResults']);
    Route::get('/exam-results', [CourseRegistration::class, 'getExamResults']);

    //auth payments
    Route::post('/mobile_money', [PaymentController::class, 'mobile_money']);
    Route::post('/dummy-transaction', [PaymentController::class, 'dummy_transaction']);
    Route::get('/has-paid-fee', [PaymentController::class, 'hasPaidFee']);
    Route::get('/transactions', [PaymentController::class, 'getTransactions']);
});

Route::post('/upload-courses', [CourseRegistration::class, 'store']);
Route::get('/course-list/{code}', [CourseRegistration::class, 'generateCourseList']);
Route::post('/validate-student-info', [RegisterController::class, 'validateStudentInfo']);
Route::get('/pdf/registration-receipt/{matricule}', [PdfController::class, 'registrationReceipt']);
Route::get('/download', [PdfController::class, 'download']);

//account PDFs
Route::get('/admission_letter/{matricule}', [PdfController::class, 'admission_letter']);
Route::get('/pdf/transaction/{matricule}', [PdfController::class, 'transaction']);
Route::get('/pdf/form_b/{matricule}', [PdfController::class, 'form_b']);
Route::get('/pdf/ca/{matricule}', [PdfController::class, 'ca']);
Route::get('/pdf/exam/{matricule}', [PdfController::class, 'exam']);


// Admin Controller
Route::get('/admin/create', [AdminController::class, 'store']);
Route::get('/admin/get', [AdminController::class, 'get']);
Route::post('/admin/update', [AdminController::class, 'update']);