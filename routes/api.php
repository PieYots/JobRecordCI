<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    UserController,
    RoleController,
    TeamController,
    MachineController,
    JobController,
    CourseTypeController,
    ETrainingController,
    StpmRecordController,
    SubjectRecordController,
    ApprovalController,
    OjtRecordController,
    CompetitiveRecordController,
    WorkTypeController
};

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']); // Get all users
    Route::put('/update-role', [UserController::class, 'updateRole']); // Update user role
});

Route::get('/roles', [RoleController::class, 'index']);
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/machines', [MachineController::class, 'index']);
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/course-types', [CourseTypeController::class, 'index']);

// E-Training Routes
Route::prefix('e-trainings')->group(function () {
    Route::get('/', [ETrainingController::class, 'index']);
    Route::get('/user/{userId}', [ETrainingController::class, 'getByUserId']);
});

// STPM Record Routes
Route::prefix('stpm-records')->group(function () {
    Route::get('/', [StpmRecordController::class, 'index']);
    Route::get('/{id}', [StpmRecordController::class, 'show']);
    Route::post('/', [StpmRecordController::class, 'store']);
    Route::delete('/{id}', [StpmRecordController::class, 'destroy']);
    Route::post('/{id}/set-ojt-etraining', [StpmRecordController::class, 'setOjtAndETraining']);
});

// Subject Record Routes
Route::prefix('subject-records')->group(function () {
    Route::get('/', [SubjectRecordController::class, 'index']);
    Route::get('/{id}', [SubjectRecordController::class, 'show']);
    Route::post('/', [SubjectRecordController::class, 'store']);
    Route::delete('/{id}', [SubjectRecordController::class, 'destroy']);
});

// Approval Routes
Route::prefix('approvals')->group(function () {
    Route::post('/stpm-record', [ApprovalController::class, 'approveStpmRecord']);
    Route::post('/subject-record', [ApprovalController::class, 'approveSubjectRecord']);
});

// OJT Record Routes
Route::prefix('ojt-records')->group(function () {
    Route::get('/', [OjtRecordController::class, 'index']);
    Route::get('/{id}', [OjtRecordController::class, 'show']);
    Route::post('/', [OjtRecordController::class, 'store']);
    Route::delete('/{id}', [OjtRecordController::class, 'destroy']);
});

Route::prefix('competitive-records')->group(function () {
    Route::get('/', [CompetitiveRecordController::class, 'index']); // Get all records
    Route::get('/{id}', [CompetitiveRecordController::class, 'show']); // Get by ID
    Route::post('/', [CompetitiveRecordController::class, 'store']); // Add record
    Route::delete('/{id}', [CompetitiveRecordController::class, 'destroy']); // Delete record
});

Route::prefix('work-types')->group(function () {
    Route::get('/', [WorkTypeController::class, 'index']); // Get all work types
    Route::get('/{id}', [WorkTypeController::class, 'show']); // Get work type by ID
});
