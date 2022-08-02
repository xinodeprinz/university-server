<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;

class AdminController extends Controller
{
    public function store()
    {
        $current_semester = 1;
        $current_academic_year = '2021/2022';
        $data = json_encode([
            'semesters' => [
                [ 'id' => 1, 'name' => 'first semester' ],
                [ 'id' => 2, 'name' => 'second semester' ],
                [ 'id' => 3, 'name' => 'first semester resit' ],
                [ 'id' => 4, 'name' => 'second semester resit' ],
            ],
            'levels' => [
                '200', '300', '400', '500', '600', '700', '800',
            ],
            'academic_years' => [
                '2020/2021', '2021/2022', '2022/2023', '2023/2024', '2024/2025',
                '2025/2026', '2026/2027', '2027/2028', '2028/2029', '2029/2030',
                '2030/2031', '2031/2032', '2032/2033', '2033/2034', '2034/2035',
                '2035/2036', '2036/2037', '2037/2038', '2038/2039', '2039/2040',
                '2040/2041', '2041/2042', '2042/2043', '2043/2044', '2044/2045',
                '2045/2046', '2046/2047', '2047/2048', '2048/2049', '2049/2050',
            ],
        ]);

        $to_store = [
            'current_semester' => $current_semester,
            'current_academic_year' => $current_academic_year,
            'data' => $data
        ];

        return Admin::create($to_store);
    }

    public function get()
    {
        $encoded_data = Admin::all()[0];
        $encoded_data->data = json_decode($encoded_data->data);
        return response($encoded_data);
    }

    public function update(Request $request) 
    {
        $request->validate([
            'semester' => 'required|string',
            'academic_year' => 'required|string',
        ]);

        $data = Admin::all()[0];
        $cur_arr = explode('/', $data->current_academic_year);
        $ex_arr = explode('/', $request->academic_year);

        if ($ex_arr[0] == $cur_arr[0]) { //&& $request->semester > $data->current_semester
            $data->current_semester = $request->semester;
            return $data->update();
        }
        if ($ex_arr[0] > $cur_arr[0]) {
            $data->current_semester = $request->semester;
            $data->current_academic_year = $request->academic_year;
            // Updating students class
            $students = User::all();
            foreach ($students as $student) {
                if ($student->level < 400 && !$student->has_graduated) {
                    $student->level += 100;
                    $student->update();
                } else if ($student->level == 400 && !$student->has_graduated) {
                    $student->level += 50;
                    $student->update();
                }
            }
            return $data->update();
        }
        return response(0, 400);
    }
}
