<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
//use Intervention\Image\Facades\Image;
use App\Models\User;

class StudentsController extends Controller
{
    public function updateProfilePhoto(Request $request)
    {
        $data = $request->validate(['imageUrl' => 'required|image']);
        $student = auth()->user();
        $student->image_url = $request->file('imageUrl')->store('student_profiles', 'public');
        $student->update();
        return response([
            'message' => 'Profile Photo updated successfully',
            'student' => $student
        ]);
    }
    
    public function checkCurrentPassword(Request $request)
    {
        $data = $request->validate(['currentPassword' => 'required|string']);
        $student = auth()->user();
        if (Hash::check($data['currentPassword'], $student->password)) {
            return response([]);
        } else {
            return response(['message' => 'Incorrect Password'], 401);
        }
    }
    
    public function updatePassword(Request $request)
    {
        $data = $request->validate(['newPassword' => 'required|string|min:5']);
        $student = auth()->user();
        $student->password = Hash::make($data['newPassword']);
        $student->update();
        auth()->user()->tokens()->delete();
        return response(['message' => 'Password Changed Successfully!']);
    }

    public function getUser()
    {
        return auth()->user();
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => "Logout Successful!"]);
    }
}            