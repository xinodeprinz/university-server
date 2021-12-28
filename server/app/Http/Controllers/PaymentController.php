<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SchoolFee;

class PaymentController extends Controller
{
    public function schoolFee(Request $request)
    {
        $payment = new SchoolFee();
        $payment->phone_number = $request->input('phoneNumber');
        $payment->matricule = auth()->user()->matricule;
        $payment->amount = $request->input('amount');
        $token = $payment->getToken();
        $description = $request->input('description');
        $reference = $payment->requestToPay($token, $payment->phone_number, $description, $payment->amount);
        $status = $payment->paymentStatus($reference, $token);

        while ($status === 'PENDING')
        {
            $status = $payment->paymentStatus($reference, $token);
            if ($status === 'SUCCESSFUL') {
                $payment->payment_date = date('Y-m-d H:i:s');
                $payment->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Transaction Successful'
                ]);
                break;
            } else if ($status === 'FAILED') {
                return response()->json([
                    'status' => 400,
                    'message' => 'Transaction Failed'
                ]);
                break;
            }
        }
    }

    public function dummySchoolFee(Request $request)
    {
        if (SchoolFee::where('matricule', auth()->user()->matricule)->exists()) {
            return response()->json([
                'status' => 400,
                'message' => 'Student has already paid fees!'
            ]);
            exit;
        }
        $payment = new SchoolFee();
        $payment->phone_number = $request->input('phoneNumber');
        $payment->matricule = auth()->user()->matricule;
        $payment->amount = $request->input('amount');
        $payment->payment_date = date('Y-m-d H:i:s');
        $payment->save();
        return response()->json([
            'status' => 200,
            'message' => 'Payment Successful!'
        ]);
    }

    public function hasPaidFee()
    {
        if (SchoolFee::where('matricule', auth()->user()->matricule)->exists()) {
            return response()->json([
                'status' => 200,
                'hasPaidFee' => true
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'hasPaidFee' => false
            ]);
        }
    }
}
