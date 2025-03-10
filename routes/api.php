<?php

/**
 * @OA\Info(
 *     title="My API",
 *     version="1.0.0",
 *     description="This is the API documentation for my Laravel project"
 * )
 */

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
    WorkTypeController,
    OPLController,
    ImprovementController,
    EmployeeController,
    ScoreCriteriaController,
    RewardController,
    SupportStrategyController,
    AuthController
};

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth.token')->group(function () {
    // User Routes
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/change-role', [UserController::class, 'changeRole']); // Changed from PUT
    });

    // Employee Routes
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::post('/update-score', [ScoreCriteriaController::class, 'updateScore']); // Changed from PUT
    });

    Route::get('/roles', [RoleController::class, 'index']);
    Route::get('/teams', [TeamController::class, 'index']);
    Route::get('/machines', [MachineController::class, 'index']);
    Route::get('/jobs', [JobController::class, 'index']);
    Route::get('/course-types', [CourseTypeController::class, 'index']);
    Route::get('/support-strategy', [SupportStrategyController::class, 'index']);

    // E-Training Routes
    Route::prefix('e-trainings')->group(function () {
        Route::get('/', [ETrainingController::class, 'index']);
        Route::get('/employee/{userId}', [ETrainingController::class, 'getByEmployeeId']);
    });

    // STPM Record Routes
    Route::prefix('stpm-records')->group(function () {
        Route::get('/', [StpmRecordController::class, 'index']);
        Route::get('/{id}', [StpmRecordController::class, 'show']);
        Route::post('/', [StpmRecordController::class, 'store']);
        Route::post('/delete/{id}', [StpmRecordController::class, 'destroy']); // Changed from DELETE
        Route::post('/set-ojt-record', [StpmRecordController::class, 'setOjtRecord']);
    });

    // Subject Record Routes
    Route::prefix('subject-records')->group(function () {
        Route::get('/', [SubjectRecordController::class, 'index']);
        Route::get('/{id}', [SubjectRecordController::class, 'show']);
        Route::post('/', [SubjectRecordController::class, 'store']);
        Route::post('/delete/{id}', [SubjectRecordController::class, 'destroy']); // Changed from DELETE
        Route::post('/set-ojt-record', [SubjectRecordController::class, 'setOjtRecord']);
    });

    // Approval Routes
    Route::prefix('approvals')->group(function () {
        Route::post('/stpm-record', [ApprovalController::class, 'approveStpmRecord']);
        Route::post('/subject-record', [ApprovalController::class, 'approveSubjectRecord']);
        Route::post('/opl', [ApprovalController::class, 'approveOpl']);
        Route::post('/improvement', [ApprovalController::class, 'approveImprovement']);
        Route::post('/competitive-record', [ApprovalController::class, 'approveCompetitiveRecord']);
    });

    // OJT Record Routes
    Route::prefix('ojt-records')->group(function () {
        Route::get('/', [OjtRecordController::class, 'index']);
        Route::get('/{id}', [OjtRecordController::class, 'show']);
        Route::post('/', [OjtRecordController::class, 'store']);
        Route::post('/delete/{id}', [OjtRecordController::class, 'destroy']); // Changed from DELETE
    });

    Route::prefix('competitive-records')->group(function () {
        Route::get('/', [CompetitiveRecordController::class, 'index']);
        Route::get('/{id}', [CompetitiveRecordController::class, 'show']);
        Route::post('/', [CompetitiveRecordController::class, 'store']);
        Route::post('/delete/{id}', [CompetitiveRecordController::class, 'destroy']); // Changed from DELETE
        Route::post('/progress', [CompetitiveRecordController::class, 'updateProgress']); // Changed from PUT
    });

    Route::prefix('work-types')->group(function () {
        Route::get('/', [WorkTypeController::class, 'index']);
        Route::get('/{id}', [WorkTypeController::class, 'show']);
    });

    Route::prefix('opls')->group(function () {
        Route::get('/', [OPLController::class, 'index']);
        Route::get('/{id}', [OPLController::class, 'show']);
        Route::post('/', [OPLController::class, 'store']);
        Route::post('/delete/{id}', [OPLController::class, 'destroy']); // Changed from DELETE
    });

    Route::prefix('improvements')->group(function () {
        Route::get('/', [ImprovementController::class, 'index']);
        Route::get('/{id}', [ImprovementController::class, 'show']);
        Route::post('/', [ImprovementController::class, 'store']);
        Route::post('/delete/{id}', [ImprovementController::class, 'destroy']); // Changed from DELETE
    });

    Route::prefix('rewards')->group(function () {
        Route::get('/', [RewardController::class, 'index']);
        Route::get('/{id}', [RewardController::class, 'show']);
        Route::post('/', [RewardController::class, 'update']); // Assuming update is a "store" action
        Route::post('/redeem', [RewardController::class, 'redeem']);
    });
});
