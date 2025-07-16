<?php

use Illuminate\Http\Request;
use App\Http\Middleware\role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::post('/login', [AuthController::class, 'Login']);
Route::post('/signup', [AuthController::class, 'Signup']);


//admin,teacher,student
Route::middleware('auth:sanctum', 'role:admin,teacher,student')->group(function () {
    Route::get('/courses', [CourseController::class, 'Courses']);
    Route::get('/course/srearch', [CourseController::class, 'search']);
});

//student
Route::middleware('auth:sanctum', 'role:student')->group(function () {
    Route::post('/course/{id}/enroll', [StudentController::class, 'enrollCourse']);
    Route::post('/course/{id}/cancel', [StudentController::class, 'cancelCourse']);
    Route::get('/myCourses', [StudentController::class, 'getMyCourses']);
});

//teacher
Route::middleware('auth:sanctum', 'role:teacher')->group(function () {
    Route::post('/course', [CourseController::class, 'store']);
    Route::patch('/course/{id}', [CourseController::class, 'update']);
    Route::delete('/course/{id}', [CourseController::class, 'destroy']);
});
//admin
Route::middleware('auth:sanctum', 'role:admin')->group(function () {
    Route::apiResource('users', UserController::class)->only(['index', 'destroy']);
    Route::delete('/course/{id}', [CourseController::class, 'destroy']);
    Route::put('course/{id}/restore', [CourseController::class, 'restore']);
    Route::put('user/{id}/restore', [UserController::class, 'restore']);
});
