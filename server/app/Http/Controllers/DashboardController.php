<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function facultyData()
    {
        $data = [
            [
                'name' => 'FACULTY OF ARTS', 
                'image' => 'faculty/arts.png', 
                'password' => Hash::make('arts'),
                'description' => 'Trains talented artists in different fields'
            ],
            [
                'name' => 'FACULTY OF SCIENCE', 
                'image' => 'faculty/science.png',
                'password' => Hash::make('science'),
                'description' => 'Trains talented scientists in different fields'
            ],
            [
                'name' => 'FACULTY OF EDUCATION', 
                'password' => Hash::make('education'),
                'image' => 'faculty/education.png',
                'description' => 'Impacts knowledge on the general society'
            ],
            [
                'name' => 'FACULTY OF ENGINEERING', 
                'password' => Hash::make('engineering'),
                'image' => 'faculty/engineering.png',
                'description' => 'Trains well and talented Engineers'
            ],
            [
                'name' => 'COLLEGE OF TECHNOLOGY', 
                'password' => Hash::make('cot'),
                'image' => 'faculty/cot.png',
                'description' => 'Trains professional Technicians'
            ],
            [
                'name' => 'FACULTY OF HEALTH SCIENCES', 
                'password' => Hash::make('health'),
                'image' => 'faculty/health.png',
                'description' => 'Trains talented medical scientist'
            ],
            [
                'name' => 'FACULTY OF LAW', 
                'password' => Hash::make('law'),
                'image' => 'faculty/law.png',
                'description' => 'Impacts the society with great skills in law'
            ],
            [
                'name' => 'FACULTY OF POLITICS', 
                'password' => Hash::make('politics'),
                'image' => 'faculty/politics.png',
                'description' => 'Trains Politicians to govern the country'
            ],
        ]; // Faculty::insert($data);
        foreach ($data as $d) {
            Faculty::create($d);
        }
        return response(['message' => 'Faculties created successfully']);
    }

    public function departmentData()
    {
        $data = [
            ['name' => 'HISTORY', 'faculties_id' => 1, 'image' => 'department/history.jpg', 'description' => 'Focuses on impacting citizens with knowledge on the history of the country'],
            ['name' => 'GEOGRAPHY', 'faculties_id' => 1, 'image' => 'department/geography.jpg', 'description' => 'Tells students about their geographical environment'],
            ['name' => 'ECONOMICS', 'faculties_id' => 1, 'image' => 'department/economics.jpg', 'description' => 'This is a good'],
            ['name' => 'LANGUAGE', 'faculties_id' => 1, 'image' => 'department/language.jpg', 'description' => 'This is a good'],

            ['name' => 'CHEMISTRY', 'faculties_id' => 2, 'image' => 'department/chemistry.jpg', 'description' => 'This is a good'],
            ['name' => 'BIOLOGY', 'faculties_id' => 2, 'image' => 'department/biology.jpg', 'description' => 'This is a good'],
            ['name' => 'PHYSICS', 'faculties_id' => 2, 'image' => 'department/physics.jpg', 'description' => 'This is a good'],
            ['name' => 'MATHEMATICS', 'faculties_id' => 2, 'image' => 'department/mathematics.jpg', 'description' => 'This is a good'],

            ['name' => 'CURRICULUM', 'faculties_id' => 3, 'image' => 'department/curriculum.jpg', 'description' => 'This is a good'],
            ['name' => 'HISTORY', 'faculties_id' => 3, 'image' => 'department/history.jpg', 'description' => 'This is a good'],
            ['name' => 'ENGLISH', 'faculties_id' => 3, 'image' => 'department/english.jpg', 'description' => 'This is a good'],
            ['name' => 'GEOGRAPHY', 'faculties_id' => 3, 'image' => 'department/geography.jpg', 'description' => 'This is a good'],

            ['name' => 'COMPUTER ENGINEERING', 'faculties_id' => 4, 'image' => 'department/computer.jpg', 'description' => 'This is a good'],
            ['name' => 'ELECTRICAL ENGINEERING', 'faculties_id' => 4, 'image' => 'department/electrical.jpg', 'description' => 'This is a good'],
            ['name' => 'CIVIL ENGINEERING', 'faculties_id' => 4, 'image' => 'department/civil.jpg', 'description' => 'This is a good'],

            ['name' => 'COMPUTER ENGINEERING', 'faculties_id' => 5, 'image' => 'department/computer.jpg', 'description' => 'This is a good'],
            ['name' => 'ELECTRICAL ENGINEERING', 'faculties_id' => 5, 'image' => 'department/electrical.jpg', 'description' => 'This is a good'],
            ['name' => 'MECHANICAL ENGINEERING', 'faculties_id' => 5, 'image' => 'department/mechanical.jpg', 'description' => 'This is a good'],
            
            ['name' => 'GENERAL MEDICINE', 'faculties_id' => 6, 'image' => 'department/general_medicine.jpg', 'description' => 'This is a good'],
            ['name' => 'NURSING', 'faculties_id' => 6, 'image' => 'department/nursing.jpg', 'description' => 'This is a good'],
            ['name' => 'LABORATORY SCIENCES', 'faculties_id' => 6, 'image' => 'department/laboratory_science.jpg', 'description' => 'This is a good'],
            
            ['name' => 'GENERAL LAW', 'faculties_id' => 7, 'image' => 'department/general_law.jpg', 'description' => 'This is a good'],
            ['name' => 'ENGLISH LAW', 'faculties_id' => 7, 'image' => 'department/english_law.jpg', 'description' => 'This is a good'],
            ['name' => 'FRENCH LAW', 'faculties_id' => 7, 'image' => 'department/french_law.jpg', 'description' => 'This is a good'],
            
            ['name' => 'GENERAL POLITICS', 'faculties_id' => 8, 'image' => 'department/general_politics.jpg', 'description' => 'This is a good'],
            ['name' => 'SOCIO-ECONOMIC POLITICS', 'faculties_id' => 8, 'image' => 'department/socio_economic_politics.jpg', 'description' => 'This is a good'],
            ['name' => 'GOVERNMENTAL POLITICS', 'faculties_id' => 8, 'image' => 'department/govt_politics.jpg', 'description' => 'This is a good']
        ];

        foreach ($data as $d) {
            Department::create($d);
        }
        return response(['message' => 'Departments created successfully!']);
    }

    public function checkPassword(Request $request)
    {
        $data = $request->validate([
            'id' => 'required',
            'password' => 'required|string'
        ]);    
        $faculty = Faculty::find($data['id']);
        if ($faculty && Hash::check($data['password'], $faculty->password)) {
            return response([]);
        } 
        return response([], 401);
    }

    public function departments($id)
    {
        return Faculty::find($id)->departments()->get();
    }

    public function getFaculties()
    {
        return Faculty::all();
    }
}
