<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PersonalAccessToken;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $data = $request->validate([
            'matricule' => 'required|string',
            'dateOfBirth' => 'required|date',
        ]);

        $student = User::where('matricule', $data['matricule'])->first();
        if ($student) {
            if ($student->date_of_birth === $data['dateOfBirth']) {
                $tokenName = $student->createToken(time())->accessToken->name;
                $tokenId = $student->createToken(time())->accessToken->id;
                $reset_url = env('APP_URL') . "/password-reset/$tokenName/$tokenId";
                // Email user here
                $details = [
                    'link' => $reset_url
                ];
                // $gmail = new ResetPassword($details);
                // Mail::to($student->email)->send($gmail);
                return response(['email' => $student->email, 'url' => $reset_url]);
            }
        } else {
            return response([], 401);
        }
    }
    
    public function index($token_name, $id)
    {
        $data = PersonalAccessToken::findOrFail($id);

        // abort(419);
        abort_if($data->name !== $token_name, 419);

        return view('password_reset', [
                'name' => $token_name,
                'id' => $id
            ]);
    }

    public function store(Request $request, $token_name, $id)
    {
        $data = $request->validate([
            'newPassword' => 'required|string|min:5'
        ]);
        $user_id = PersonalAccessToken::find($id)->tokenable_id;
        $user = User::find($user_id);
        $user->password = Hash::make($request->newPassword);
        $user->update();
        return redirect(env('REACT_APP_URL').'/login');
    }
}
