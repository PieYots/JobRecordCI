<?php

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is the API documentation for my Laravel project"
 * )
 */

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\MachineController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\CourseTypeController;
use App\Http\Controllers\Api\ETrainingController;
use App\Http\Controllers\Api\StpmRecordController;
use App\Http\Controllers\Api\SubjectRecordController;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\OjtRecordController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::get('/roles', [RoleController::class, 'index']);
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/machines', [MachineController::class, 'index']);
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/e-trainings', [ETrainingController::class, 'index']);
Route::get('/e-trainings/user/{userId}', [ETrainingController::class, 'getByUserId']);
Route::get('/course-types', [CourseTypeController::class, 'index']);
Route::get('/stpm-records', [StpmRecordController::class, 'index']);
Route::get('/stpm-records/{id}', [StpmRecordController::class, 'show']);
Route::post('/stpm-records', [StpmRecordController::class, 'store']);
Route::delete('/stpm-records/{id}', [StpmRecordController::class, 'destroy']);
Route::get('/subject-records', [SubjectRecordController::class, 'index']);
Route::get('/subject-records/{id}', [SubjectRecordController::class, 'show']);
Route::post('/subject-records', [SubjectRecordController::class, 'store']);
Route::delete('/subject-records/{id}', [SubjectRecordController::class, 'destroy']);
Route::post('/approve-stpm-record', [ApprovalController::class, 'approveStpmRecord']);
Route::post('/approve-subject-record', [ApprovalController::class, 'approveSubjectRecord']);
Route::prefix('ojt-records')->group(function () {
    Route::get('/', [OjtRecordController::class, 'index']); // Get all OJT records
    Route::get('{id}', [OjtRecordController::class, 'show']); // Get OJT record by ID
    Route::post('/', [OjtRecordController::class, 'store']); // Create a new OJT record
    Route::delete('{id}', [OjtRecordController::class, 'destroy']); // Delete OJT record
});
