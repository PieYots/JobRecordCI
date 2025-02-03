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
use Illuminate\Support\Facades\Route;


/**
 * @OA\PathItem(
 *     path="/getUsers"
 * )
 */


Route::get('/getUsers', [UserController::class, 'index']);
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
Route::get('/subject-records', [SubjectRecordController::class, 'index']);
Route::get('/subject-records/{id}', [SubjectRecordController::class, 'show']);
Route::post('/subject-records', [SubjectRecordController::class, 'store']);
