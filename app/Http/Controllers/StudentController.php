<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private function validate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Student::orderByDesc('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['email' => 'unique:students']);
        $this->validate($request);
        $student = Student::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address' => $request->address,
        ]);

        return response()->json($student, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        return $student;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Student $student)
    {
        $this->validate($request);
        $student->email = $request->email;
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->address = $request->address;

        if ($student->isDirty())
            $student->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        Student::destroy($student->id);
    }

    /**
     * Get all courses a student is enrolled in.
     */
    public function courses(Student $student)
    {
        $res = [];
        foreach ($student->courses as $course) {
            $arr = [];
            $arr['id'] = $course->id;
            $arr['title'] = $course->title;
            $res[] = $arr;
        }

        return response()->json($res);
    }

    public function search(String $searchString)
    {
        $searchTerm = '%' . $searchString . '%';
        return Student::where('id', 'LIKE', $searchTerm)
            ->orWhereRaw('LOWER(first_name) LIKE ?', [strtolower($searchTerm)])
            ->orWhereRaw('LOWER(last_name) LIKE ?', [strtolower($searchTerm)])
            ->get();
    }
}
