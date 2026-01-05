<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    public function addStudentToCourse(Student $student, Course $course)
    {
        $student->courses()->syncWithoutDetaching($course->id);

        return response()->json(null, 201);
    }

    public function removeStudentFromCourse(Student $student, Course $course)
    {
        $student->courses()->detach($course->id);
    }
}
