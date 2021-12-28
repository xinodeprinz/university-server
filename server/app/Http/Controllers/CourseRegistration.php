<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CotLevel200Ce;

class CourseRegistration extends Controller
{
    public function store(Request $request)
    {
        foreach ($request->data as $data) {
            if (!CotLevel200Ce::where('course_code', $data['COURSE CODE'])->exists()) {
                $course = new CotLevel200Ce();
                $course->course_code = $data['COURSE CODE'];
                $course->course_title = $data['COURSE TITLE'];
                $course->credit_value = $data['CREDIT VALUE'];
                $course->course_master = $data['COURSE MASTER'];
                $course->save();
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Course uploaded successfully!'
        ]);
    }
}
