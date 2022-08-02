<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function mobile_money(Request $request)
    {
        $data = $request->validate([
            'number' => 'required|string|size:9|number',
            'type' => 'required|string',
            'academic_year' => 'required|string'
        ]);
        $amount = 2;
        try {
            $transaction = new Transaction();
            $token = $transaction->getToken();
            $reference = $transaction->requestToPay($token, $request->number, $request->type, $amount);
            $status = $transaction->paymentStatus($reference, $token);
        } catch (\Throwable $th) {
            return response([], 400);
        }

        while ($status === 'PENDING')
        {
            try {
                $status = $transaction->paymentStatus($reference, $token);
            } catch (\Throwable $th) {
                return response([], 400);
            }
            if ($status === 'SUCCESSFUL') {
                auth()->user()->transactions()->create([
                    'number' => $data['number'],
                    'type' => strtoupper($data['type']),
                    'amount' => $amount,
                    'method' => 'MTN / Orange mobile money',
                    'academic_year' => $data['academic_year']
                ]);
                return response([]);
            } else if ($status === 'FAILED') {
                return response([], 400);
            }
        }
    }

    public function dummy_transaction(Request $request)
    {
        $data = [
            'number' => $request->number,
            'type' => $request->type,
            'academic_year' => $request->academic_year,
        ];
        $validator = Validator::make($data, [
            'number' => ['required', 'string', 'size:9'],
            'type' => ['required', 'string'],
            'academic_year' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response(['status' => 403]);
        }
        $amount = 2;
        $exits = auth()->user()->transactions()
        ->where('type', 'SCHOOL FEE')
        ->where('academic_year', $data['academic_year'])
        ->exists();
        if ($exits) {
            return response(['message' => 'Has already paid fee'], 401);
        }
        auth()->user()->transactions()->create([
            'number' => $data['number'],
            'type' => strtoupper($data['type']),
            'amount' => $amount,
            'method' => 'MTN / Orange mobile money',
            'academic_year' => $data['academic_year']
        ]);
        return response([
            'status' => 200,
            'message' => 'Transaction Successful!'
        ]);
    }

    public function hasPaidFee()
    {
        $academic_year = request()->query('academic_year');
        $transaction = auth()->user()->transactions()
        ->where('type', 'SCHOOL FEE')
        ->where('academic_year', $academic_year)
        ->first();
        return $transaction ? true : false;
    }

    public function getTransactions()
    {
        return auth()->user()->transactions()->get();
    }

    public function testing(Request $request)
    {
        //return $request->file('image')->store(public_path('public').'/');
    }
}
