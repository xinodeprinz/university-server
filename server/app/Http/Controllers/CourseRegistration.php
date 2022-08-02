<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseRegistration extends Controller
{
    public function store(Request $request)
    {
        $info = $request->validate([
            'data' => 'required|array',
            'dept_id' => 'required',
            'semester' => 'required|string',
            'level' => 'required|string'
        ]);
        $available_courses = [];
        $department = Department::find($info['dept_id']);
        foreach ($request->data as $data) {
            if (!Course::where('course_code', $data['COURSE CODE'])->exists()) {
                $department->courses()->create([
                    'course_code' => $data['COURSE CODE'],
                    'course_title' => strtoupper($data['COURSE TITLE']),
                    'credit_value' => $data['CREDIT VALUE'],
                    'course_master' => strtoupper($data['COURSE MASTER']),
                    'semester' => $info['semester'],
                    'level' => $info['level']
                ]);
            } else {
                $available_courses[] = Course::where('course_code', $data['COURSE CODE'])
                                       ->get(['course_code'])[0]
                                       ->course_code;
            }
        }
        $a_codes = '';
        if (count($available_courses) == 0) {
            return response(['message' => 'All the courses where uploaded successfully!']);
        } else {
            foreach ($available_courses as $i => $a) {
                ++$i;
                $a_codes .= " $i.$a";
            }
            return response([
                'message' => "The following courses where not uploaded because they already exits: $a_codes"
            ]);
        }
    }

    public function departmentCourses($dept_id)
    {
        $level = request()->query('level');
        $semester = request()->query('semester');
        $academic_year = request()->query('academic_year');
        $reg_table = auth()->user()->matricule;

        // Changing resit semesters to normal semesters
        $fetch_semester = '';
        if ($semester == 1) $fetch_semester = 1;
        else if ($semester == 2) $fetch_semester = 2;
        else if ($semester == 3) $fetch_semester = 1;
        else $fetch_semester = 2;
        // ends here

        $dept_courses = Department::find($dept_id)->courses()
            ->where('level', $level)
            ->where('semester', $fetch_semester)->get(); //object
        foreach ($dept_courses as $dc) {
            if ($dc->semester == 1 && $semester == 3) $dc->semester = 3;
            else if ($dc->semester == 2 && $semester == 4) $dc->semester = 4;
        }
        $registered_courses = [];
        if (Schema::connection('reg_courses')->hasTable($reg_table)) {
            $registered_courses = DB::connection('reg_courses')
            ->table($reg_table)
            ->get(['course_code', 'course_title', 'credit_value', 'course_master', 'semester', 'academic_year']);
        }
        $data = $result = [];
        foreach ($dept_courses as $r) {
            $data[] = $r;
        }
        if ($registered_courses) {
            foreach ($registered_courses as $yo) {
                foreach ($data as $d) {
                    if (
                        $yo->course_code === $d->course_code && 
                        $d->semester == $yo->semester && 
                        $yo->academic_year == $academic_year
                    ) {
                        $index = array_search($d, $data);
                        unset($data[$index]);
                    }
                }
            }
        }
        if (count($data) > 0) {
            foreach ($data as $da) {
                $result[] = $da;
            }
        }
        return $result;
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'courses' => ['required', 'array'],
            'semester' => ['required', 'string'],
            'academic_year' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 403,
                'messages' => $validator->messages()
            ]);
        }
        $courses = [];
        foreach ($request->courses as $code) {
            $course = DB::connection('mysql')
            ->select("SELECT course_code, course_title, credit_value, course_master 
            FROM courses WHERE course_code = ?", [$code]);
            if (!empty($course)) {
                $courses[] = $course[0];
            }
        }

        $table_name = auth()->user()->matricule;
        DB::connection('reg_courses')->unprepared("CREATE TABLE IF NOT EXISTS `$table_name`(
            `course_code` varchar(50), `course_title` varchar(512),
            `credit_value` int(10), `course_master` varchar(512), `ca_mark` int(10), 
            `exam_mark` int(10), `semester` int(10), `academic_year` varchar(10),
            PRIMARY KEY (course_code, semester, academic_year))"
        );

        $existing_courses = DB::connection('reg_courses')->table($table_name)->get();

        $my_data = [];
        foreach($courses as $course){
            $course->ca_mark = null;
            if ($request->semester == 3 || $request->semester == 4) {
                $greatest_ca = 0;
                foreach ($existing_courses as $ec) {
                   if ($course->course_code == $ec->course_code) {
                       if ($ec->ca_mark > $greatest_ca) $greatest_ca = $ec->ca_mark;
                   }
                }
                $course->ca_mark = $greatest_ca;
            }
            DB::connection('reg_courses')->insert("INSERT IGNORE INTO `$table_name`(course_code, course_title, credit_value, ca_mark, course_master, semester, academic_year)
                VALUES(?, ?, ?, ?, ?, ?, ?)", [$course->course_code, $course->course_title, $course->credit_value, $course->ca_mark, $course->course_master, $request->semester, $request->academic_year]
            );
        }
        return response(['message' => 'Courses registered successfully!']);
    }

    public function registeredCourses()
    {
        $registered_courses = [];
        $semester = request()->query('semester');
        $academic_year = request()->query('academic_year');
        $reg_table = auth()->user()->matricule;
        if (Schema::connection('reg_courses')->hasTable($reg_table)) {
            $registered_courses = DB::connection('reg_courses')->select("SELECT 
                course_code, course_title, credit_value, course_master
                FROM `$reg_table` WHERE academic_year = ? AND semester = ?", [$academic_year, $semester]);
            
        }
        return $registered_courses;
    }

    public function deleteCourse($code)
    {
        $semester = request()->query('semester');
        $academic_year = request()->query('academic_year');
        $reg_table = auth()->user()->matricule;
        $rows = DB::connection('reg_courses')->delete("DELETE FROM 
                `$reg_table` WHERE course_code = ? AND semester = ? AND 
                academic_year = ?", [$code, $semester, $academic_year]
            );
        if ($rows != 0) {
            return response(['message' => 'Course dropped successfully!']);
        }
        return response(['message' => 'Course not found!'], 404);
    }

    public function coursesForCAUpload($dept_id)
    {
        $data = [
            'level' => request()->query('level'),
            'semester' => request()->query('semester'),
            'dept_id' => $dept_id
        ];
        $validator = Validator::make($data, [
            'level' => ['required'],
            'semester' => ['required'],
            'dept_id' => ['required']
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 403,
                'messages' => $validator->messages()
            ]);
        }
        $level = request()->query('level');
        $semester = request()->query('semester');
        // changing resit semesters to normal semesters
        if ($semester == 3) {
            $semester = 1;
        } else if ($semester == 4) {
            $semester = 2;
        }
        // the end of the change
        $real_courses = Department::find($dept_id)
            ->courses()
            ->where('level', $level)
            ->where('semester', $semester)->get();

        $course_codes = [];
        foreach ($real_courses as $c) {
            $course_codes[] = $c->course_code;
        }
        return $course_codes;
    }

    public function uploadCA(Request $request)
    {
       $info = $request->validate([
        'data' => 'required|array',
        'current_semester' => 'required|string',
        'code' => 'required|string',
        'academic_year' => 'required|string'
       ]);
        $student_number = 0;
        foreach ($request->data as $data) {
            $table = $data['MATRICULE'];
            $ca = $data['CA MARK'];
            $code = $request->code;
            if (Schema::connection('reg_courses')->hasTable($table)) {
                $status = DB::connection('reg_courses')->table($table)
                ->where('course_code', $code)
                ->where('semester', $request->current_semester)
                ->where('academic_year', $request->academic_year)
                ->update(['ca_mark' => $ca]);
                $student_number = $status == 1 ? $student_number += 1 : $student_number;
            }
        }
        if ($student_number == count($request->data)) {
            return response(['message' => 'All the CA marks have been uploaded successfully!']);
        } else {
            $left = count($request->data) - $student_number;
            return response(['message' => "The CA mark of $left students has not been uploaded"]);
        }
    }

    public function getCAResults()
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $table = auth()->user()->matricule;
        if (Schema::connection('reg_courses')->hasTable($table)) {
            return DB::connection('reg_courses')->table($table)
            ->where('semester', $semester)
            ->where('academic_year', $academic_year)
            ->where('ca_mark','!=' , null)
            ->get();
        }
        return [];
    }

    public function uploadExam(Request $request)
    {
        $info = $request->validate([
            'data' => 'required|array',
            'current_semester' => 'required|string',
            'code' => 'required|string',
            'academic_year' => 'required|string'
        ]);
        foreach ($request->data as $data) {
            $table = $data['MATRICULE'];
            $exam = $data['EXAM MARK'];
            $code = $request->code;
            $student_number = 0;
            if (Schema::connection('reg_courses')->hasTable($table)) {
                $status = DB::connection('reg_courses')->table($table)
                ->where('course_code', $code)
                ->where('semester', $request->current_semester)
                ->where('academic_year', $request->academic_year)
                ->update(['exam_mark' => $exam]);
                $student_number = $status == 1 ? $student_number += 1 : $student_number;
            }
        }
        if ($student_number == count($request->data)) {
            return response(['message' => 'All the exam marks have been uploaded successfully!']);
        } else {
            $left = count($request->data) - $student_number;
            return response(['message' => "The exam mark of $left students has not been uploaded"]);
        }
    }

    public function getExamResults()
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $table = auth()->user()->matricule;
        if (Schema::connection('reg_courses')->hasTable($table)) {
            $courses =  DB::connection('reg_courses')->table($table)
            ->where('semester', $semester)
            ->where('academic_year', $academic_year)
            //->where('ca_mark','!=' , null)
            ->where('exam_mark','!=' , null)
            ->get();

            if (!empty($courses)) {
                $totalCredit = $credit_earned = $totalGP_and_CV = $subjects_passed = 0;
                for ($i = 0; $i < count($courses); $i++) {
                    $courses[$i]->ca_mark = $courses[$i]->ca_mark == null ? 0 : $courses[$i]->ca_mark;
                    $courses[$i]->exam_mark = $courses[$i]->exam_mark == null ? 0 : $courses[$i]->exam_mark;
                    $total_mark = $courses[$i]->ca_mark + $courses[$i]->exam_mark;
                    $courses[$i]->grade = $this::grade($total_mark)[0];
                    $totalGP_and_CV += ($this::grade($total_mark)[1] * $courses[$i]->credit_value);
                    $totalCredit += $courses[$i]->credit_value;
                    $credit_earned += ($this::grade($total_mark)[1] > 1.5) ? $courses[$i]->credit_value : 0;
                    $subjects_passed += ($this::grade($total_mark)[1] > 1.5) ? 1 : 0;
                }
                $gpa = $totalCredit > 0 ? number_format($totalGP_and_CV / $totalCredit, 2) : null;
    
                if ($gpa !== null) {
                    return response([
                        $courses,
                        array(
                            'gpa' => $gpa,
                            'total_credit' => $totalCredit,
                            'credit_earned' => $credit_earned,
                            'subjects_passed' => $subjects_passed
                        ),
                    ]);
                } else  { return []; }
            }
        }
        return [];
    }

    private static function grade($mark)
    {
        if ($mark < 45) {
            return ['F', 0];
        } else if ($mark < 45) {
            return ['D', 1];
        } else if ($mark < 50) {
            return ['D+', 1.5];
        } else if ($mark < 55) {
            return ['C', 2];
        } else if ($mark < 60) {
            return ['C+', 2.5];
        } else if ($mark < 70) {
            return ['B', 3];
        } else if ($mark < 80) {
            return ['B+', 3.5];
        } else {
            return ['A', 4];
        }
    }

    public function generateCourseList($code)
    {
        $academic_year = request()->query('academic_year');
        $semester = request()->query('semester');
        $names = $matricules = $students = [];
        $tables = DB::connection('reg_courses')->select("SHOW TABLES");
        foreach ($tables as $table) {
            $names[] = $table->Tables_in_registered_courses;
        }
        foreach ($names as $name) {
           if ( DB::connection('reg_courses')->table($name)
           ->where('course_code', $code)
           ->where('academic_year', $academic_year)
           ->where('semester', $semester)
           ->exists()) {
               $data_course = DB::connection('reg_courses')->table($name)
                    ->where('course_code', $code)
                    ->where('academic_year', $academic_year)
                    ->where('semester', $semester)
                    ->first(['ca_mark', 'exam_mark']);
               $matricules[] = [strtoupper($name), $data_course];
           }
        }

        $result = [];
        for ($i = 0; $i < count($matricules); $i++) {
            $data2 = User::where('matricule', $matricules[$i][0])
                ->first(['name', 'matricule', 'level']);
            array_shift($matricules[$i]);
            $matricules[$i][] = $data2;
        }
        foreach ($matricules as $student) {
            $result[] = [
                'NAME' => strtoupper($student[1]->name),
                'MATRICULE' => $student[1]->matricule,
                'LEVEL' => $student[1]->level,
                'CA MARK' => $student[0]->ca_mark ?? '',
                'EXAM MARK' => $student[0]->exam_mark ?? '',
            ];
        }

        return $result;
    }
}
