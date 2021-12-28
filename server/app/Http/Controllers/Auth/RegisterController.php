<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;


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
        $student = User::where('matricule', request('matricule'))->first();
        if($student && Hash::check(request('password'), $student->password)){
            return response()->json([
                'status' => 200,
                'message' => 'Login Successful',
                'token' => $student->createToken(time())->plainTextToken
            ]);
        } else if($student && !Hash::check(request('password'), $student->password)) {
            return response()->json([
                'status' => 400,
                'message' => 'Invalid Password'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => "Matricule doesn't exist"
            ]);
        } 
    }
    public function register(Request $request)
    {
        $student = new User();
        $student->name = strtoupper($request->input('firstName').' '. $request->input('lastName'));
        $student->matricule = $request->input('matricule');
        $student->date_of_birth = $request->input('dateOfBirth');
        $student->sub_division = strtoupper($request->input('subDivision'));
        $student->place_of_birth = strtoupper($request->input('placeOfBirth'));
        $student->phone_number = $request->input('phoneNumber');
        $student->gender = strtoupper($request->input('gender'));
        $student->country = strtoupper($request->input('country'));
        $student->region = strtoupper($request->input('region'));
        $student->father_name = strtoupper($request->input('fatherName'));
        $student->mother_name = strtoupper($request->input('motherName'));
        $student->father_contact = $request->input('fatherContact');
        $student->mother_contact = $request->input('motherContact');
        $student->parent_address = strtoupper($request->input('parentAddress'));
        $student->faculty = strtoupper($request->input('faculty'));
        $student->department = strtoupper($request->input('department'));
        $student->image_url =  $request->file('imageUrl')->store('student_profiles', 'public');
        $student->birth_certificate =  $request->file('birthCertificate')->store('birth_certificates', 'public');
        $student->gce_ol =  $request->file('GCE_OL')->store('gce_ol', 'public');
        $student->gce_al =  $request->file('GCE_AL')->store('gce_al', 'public');
        $student->password = Hash::make($request->input('password'));
        $student->registered_date = date('Y-m-d H:i:s', time() - 3600);
        $student->save();
        return response()->json([
            'status' => 200,
            'message' => 'Student registered successfully'
        ]);
    }
}
