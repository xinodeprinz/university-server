<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
//use Intervention\Image\Facades\Image;
use App\Models\User;

class StudentsController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $student = User::where('matricule', auth()->user()->matricule)->first();
        $student->image_url = $request->file('imageUrl')->store('student_profiles', 'public');
        $student->update();
        return response()->json([
            'status' => 200,
            'message' => 'Profile Photo updated successfully'
        ]);
    }
    
    public function checkCurrentPassword(Request $request)
    {
        $student = User::where('matricule', auth()->user()->matricule)->first();
        if (Hash::check($request->input('currentPassword'), $student->password)) {
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Incorrect Password'
            ]);
        }
    }
    
    public function updatePassword(Request $request)
    {
        $student = User::where('matricule', auth()->user()->matricule)->first();
        $student->password = Hash::make($request->input('newPassword'));
        $student->update();
        return response()->json([
            'status' => 200,
            'message' => 'Password Changed Successfully!'
        ]);
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => "Logout Successful!"
        ]);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        $student->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Student deleted successfully'
        ]);
    }
}            