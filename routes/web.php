<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResumeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/resume/upload', [ResumeController::class, 'showUploadForm'])->name('resume.upload.form');
Route::post('/resume/upload', [ResumeController::class, 'upload'])->name('resume.upload');

Route::get('/analysis', [ResumeController::class, 'showAnalysis'])
    ->name('analysis.result');

Route::get('/report/download', [ResumeController::class, 'downloadReport'])
    ->name('report.download');