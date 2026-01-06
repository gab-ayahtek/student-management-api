<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('students', StudentController::class);
Route::apiResource('courses', CourseController::class);

Route::get('/courses/search/{searchString}', [CourseController::class, 'search']);
Route::get('/students/search/{searchString}', [StudentController::class, 'search']);

// add student to a course
Route::post('/students/{student}/courses/{course}', [CourseStudentController::class, 'addStudentToCourse']);
// remove student from a course
Route::delete('/students/{student}/courses/{course}', [CourseStudentController::class, 'removeStudentFromCourse']);

// get all courses a student is enrolled in
Route::get('/students/{student}/courses', [StudentController::class, 'courses']);
// get all students enrolled in a course
Route::get('/courses/{course}/students', [CourseController::class, 'students']);
