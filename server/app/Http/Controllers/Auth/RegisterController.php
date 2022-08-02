<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use App\Mail\Gmail;
use Illuminate\Support\Facades\Mail;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'date_of_birth' => ['required', 'date'],
            'place_of_birth' => ['required', 'string'],
            'country' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'region' => ['required', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['firstname'].' '. $data['lastname'],
            'date_of_birth' => $data['date_of_birth'],
            'place_of_birth' => $data['date_of_birth'],
            'country' => $data['country'],
            'gender' => $data['gender'],
            'phone_number' => $data['phone_number'],
            'region' => $data['region'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function login()
    {
        $data = request()->validate([
            'matricule' => 'required|string',
            'password' => 'required|string'
        ]);
        $student = User::where('matricule', $data['matricule'])->first();
        $student->date_of_birth = date('jS\ F Y', strtotime($student->date_of_birth));
        $student->registered_date = date('jS\ F Y', strtotime($student->registered_date));
        $academics = Admin::all(['current_semester', 'current_academic_year'])[0];
        if($student && Hash::check($data['password'], $student->password)){
            $faculty = Faculty::where('name', $student->faculty)->first();
            $dept = $faculty->departments()->where('name', $student->department)->first();
            return response([
                'message' => 'Login Successful',
                'token' => $student->createToken(time())->plainTextToken,
                'dept_id' => $dept->id,
                'student' => $student,
                'academics' => $academics
            ]);
        } else {
            return response(['message' => "The credentials you've provided seem to be invalid."], 401);
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'fatherName' => 'required|string',
            'motherName' => 'required|string',
            'fatherContact' => 'required|string|size:9',
            'motherContact' => 'required|string|size:9',
            'parentAddress' => 'required|string',
            'imageUrl' => 'required|image',
            'birthCertificate' => 'required|file',
            'gce_ol' => 'required|file',
            'gce_al' => 'required|file'
        ]);

        // Creating the students matricule
        $matricule = $request->matricule;
        $count = User::where('matricule', 'like', "$matricule%")->count();
        $count += 1;
        if ($count < 10) {
            $matricule .= "00$count"; 
        } else if ($count < 100) {
            $matricule .= "0$count"; 
        } else {
            $matricule .= $count;
        }

        // The end of the matricule creation

        $name = $request->firstName.' '. $request->lastName;
        $faculty = $request->faculty;
        $student = new User();
        $student->name = ucwords(strtolower($name));
        $student->matricule = $matricule;
        $student->email = $request->input('email');
        $student->level = '200';
        $student->date_of_birth = $request->input('dateOfBirth');
        $student->sub_division = ucwords(strtolower($request->input('subDivision')));
        $student->place_of_birth = ucwords(strtolower($request->input('placeOfBirth')));
        $student->phone_number = $request->input('phoneNumber');
        $student->gender = ucwords(strtolower($request->input('gender')));
        //$student->country = ucwords($request->input('country'));
        $student->region = ucwords(strtolower($request->input('region')));
        $student->father_name = ucwords(strtolower($request->input('fatherName')));
        $student->mother_name = ucwords(strtolower($request->input('motherName')));
        $student->father_contact = $request->input('fatherContact');
        $student->mother_contact = $request->input('motherContact');
        $student->parent_address = ucwords(strtolower($request->input('parentAddress')));
        $student->faculty = ucwords(strtolower($request->input('faculty')));
        $student->department = ucwords(strtolower($request->input('department')));
        $student->has_graduated = false;
        $student->image_url =  $request->file('imageUrl')->store('student_profiles', 'public');
        $student->birth_certificate =  $request->file('birthCertificate')->store('birth_certificates', 'public');
        $student->gce_ol =  $request->file('gce_ol')->store('gce_ol', 'public');
        $student->gce_al =  $request->file('gce_al')->store('gce_al', 'public');
        $student->password = Hash::make($request->input('password'));
        $student->registered_date = date('Y-m-d H:i:s', time() - 3600);
        $student->save();

        //Emailing the user
        // $details = [
        //     'matricule' => $request->matricule,
        //     'password' => $request->password,
        //     'faculty' => $request->faculty,
        //     'department' => $request->department,
        //     'name' => strtoupper($request->input('firstName').' '. $request->input('lastName')),
        //     'date_of_birth' =>$request->dateOfBirth
        // ];
        // $gmail = new Gmail($details);
        // Mail::to($request->email)->send($gmail);
        return response($matricule);
    }

    public function validateStudentInfo(Request $request)
    {
        return $request->validate([
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'subDivision' => 'required|string',
            'dateOfBirth' => 'required|date',
            'placeOfBirth' => 'required|string',
            'phoneNumber' => 'required|size:9',
            'gender' => 'required|string',
            'region' => 'required|string'
        ]);
    }
}
