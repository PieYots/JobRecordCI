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
    SupportStrategyController
};
use App\Models\SupportStrategy;

// General Routes
Route::prefix('users')->group(
    function () {
        Route::get('/', [UserController::class, 'index']);
        Route::put('/change-role', [UserController::class, 'changeRole']);
    }
);

Route::prefix('employees')->group(
    function () {
        Route::get('/', [EmployeeController::class, 'index']);
        Route::put('/update-score', [ScoreCriteriaController::class, 'updateScore']);
    }
);

Route::get('/roles', [RoleController::class, 'index']);
Route::get('/teams', [TeamController::class, 'index']);
Route::get('/machines', [MachineController::class, 'index']);
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/course-types', [CourseTypeController::class, 'index']);
Route::get('/support-strategy', [SupportStrategyController::class, 'index']);

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
    Route::post('/opl', [ApprovalController::class, 'approveOpl']);
    Route::post('/improvement', [ApprovalController::class, 'approveImprovement']);
    Route::post('/competitive-record', [ApprovalController::class, 'approveCompetitiveRecord']);
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
    Route::put('progress', [CompetitiveRecordController::class, 'updateProgress']);
});

Route::prefix('work-types')->group(function () {
    Route::get('/', [WorkTypeController::class, 'index']); // Get all work types
    Route::get('/{id}', [WorkTypeController::class, 'show']); // Get work type by ID
});

Route::prefix('opls')->group(function () {
    Route::get('/', [OPLController::class, 'index']); // Get all OPLs
    Route::get('/{id}', [OPLController::class, 'show']); // Get OPL by ID
    Route::post('/', [OPLController::class, 'store']); // Create OPL
    Route::delete('/{id}', [OPLController::class, 'destroy']); // Delete OPL
});

Route::prefix('improvements')->group(function () {
    Route::get('/', [ImprovementController::class, 'index']); // Get all improvements
    Route::get('/{id}', [ImprovementController::class, 'show']); // Get improvement by ID
    Route::post('/', [ImprovementController::class, 'store']); // Create improvement
    Route::delete('/{id}', [ImprovementController::class, 'destroy']); // Delete improvement
});

Route::prefix('rewards')->group(function () {
    Route::get('/', [RewardController::class, 'index']);           // Get all rewards
    Route::get('/{id}', [RewardController::class, 'show']);        // Get reward by ID
    Route::post('/', [RewardController::class, 'update']);      // Edit reward
    Route::post('/redeem', [RewardController::class, 'redeem']);   // Redeem reward
});
