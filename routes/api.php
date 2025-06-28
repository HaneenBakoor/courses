<?php

use Illuminate\Http\Request;
use App\Http\Middleware\role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->group(function(){
Route::post('/logout',[AuthController::class, 'logout']);

});
Route::post('/login',[AuthController::class, 'Login']);
Route::post('/signup',[AuthController::class, 'Signup']);


//admin,teacher,student
Route::middleware('auth:sanctum','role:admin,teacher,student')->group(function(){
Route::get('/courses',[CourseController::class, 'index']);
});

//student
Route::middleware('auth:sanctum','role:student')->group(function(){
Route::post('/course/{id}/enroll',[StudentController::class, 'enrollCourse']);
Route::get('/myCourses',[StudentController::class, 'getMyCourses']);
});

//teacher
Route::middleware('auth:sanctum','role:teacher')->group(function(){
Route::post('/course',[CourseController::class, 'store']);
Route::patch('/course/{id}',[CourseController::class, 'update']);
Route::delete('/course/{id}',[CourseController::class, 'destroy']);
});



