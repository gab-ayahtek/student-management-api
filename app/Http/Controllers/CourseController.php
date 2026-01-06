<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'string',
        ]);

        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($course, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return $course;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'string',
        ]);

        $course->title = $request->title;
        $course->description = $request->description;

        if ($course->isDirty())
            $course->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        Course::destroy($course->id);
    }

    /**
     * Retrieve all students that are enrolled in this course.
     */
    public function students(Course $course)
    {
        $res = [];
        foreach ($course->students as $student) {
            $res[] = $student->first_name . ' ' . $student->last_name;
        }

        return response()->json($res);
    }

    public function search(String $searchString)
    {
        $searchTerm = '%' . $searchString . '%';
        return Course::where('id', 'LIKE', $searchTerm)
            ->orWhereRaw('LOWER(title) LIKE ?', [strtolower($searchTerm)])
            ->get();
    }
}
