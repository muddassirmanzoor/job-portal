<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RecruitmentController;

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

Route::get('/', [RecruitmentController::class, 'jobForm'])->name('jobForm');
//Route::get('/', function () {
//    return view('cancelation');
//});
Route::get('/form', [RecruitmentController::class, 'jobForm'])->name('jobForm');
Route::post('submit-form', [RecruitmentController::class, 'submitForm']);
Route::get('eligibility-criteria/{post_id}', [RecruitmentController::class, 'getEligibilityCriteria']);
Route::get('applicant-detail/{user_id}', [RecruitmentController::class, 'applicantDetail'])->name('applicantDetail');

Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'checkLogin']);

Route::middleware(['auth'])->group(function () {
    Route::get('first-submitted-form-listing', [RecruitmentController::class, 'submittedFormListing']);
    Route::get('first-submitted-form-data/{post_id}', [RecruitmentController::class, 'submittedFormData']);
    Route::get('first-scrutinize-form-data/{post_id}', [RecruitmentController::class, 'scrutinizeFormData']);
    Route::get('first-review-form-data/{post_id}', [RecruitmentController::class, 'reviewFormData']);
    Route::get('second-review-form-data/{post_id}', [RecruitmentController::class, 'secondReviewFormData']);
    Route::get('first-submitted-count', [RecruitmentController::class, 'firstSubmittedCount']);
    Route::get('first-scrutinize-count', [RecruitmentController::class, 'firstScrutinizedCount']);
    Route::get('first-review-count', [RecruitmentController::class, 'firstReviewedCount']);
    Route::get('second-review-count', [RecruitmentController::class, 'secondReviewedCount']);

    Route::get('first-user-form/{user_id}', [\App\Http\Controllers\PDFController::class, 'downloadUserDocuments']);
    Route::get('first-user-documents/{user_id}', [\App\Http\Controllers\PDFController::class, 'downloadUserDocumentsZip']);

    Route::get('user-detail/{user_id}', [RecruitmentController::class, 'userDetail']);
    Route::post('first-user-scrutiny', [RecruitmentController::class, 'userScrutiny']);
    Route::post('first-user-scrutiny-update', [RecruitmentController::class, 'userScrutinyUpdate']);
    Route::get('logout', [LoginController::class, 'logout']);
});
