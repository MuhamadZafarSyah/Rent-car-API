<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReturnController extends Controller
{
    public function index()
    {
        $return = Rent::where('status', 'returned')->get();

        return response()->json([
            'massage' => 'Success Get Return',
            'data' => $return
        ]);
    }

    public function show()
    {
    }

    public function ubahStatusPeminjaman(Request $request, $id)
    {
        if (Auth::user()->role === 'tenants') {
            return response()->json([
                'message' => 'Invalid Role'
            ], 403);
        }

        if (!$request->token) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        // $validator = Validator::make($request->all(), [

        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'message' => 'invalid field',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }

        $rent = Rent::where('id', $id)->where('status', 'borrow')->first();
        $rent->status = 'return';
        if ($request->id_penalties) {
            $rent->id_penalties = $request->id_penalties;
        }
        $rent->save();

        return response()->json([
            'massage' => 'Create Return Success'
        ], 200);
    }
}
