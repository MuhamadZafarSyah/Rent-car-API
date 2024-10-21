<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rent;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    public function index(Request $request)
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

        $rent = Rent::all();

        return response()->json([
            'massage' => 'Success Get Rents',
            'data' => $rent
        ]);
    }

    public function show(Request $request, $id)
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


        $rent = Rent::find($id)->first();
        

        return response()->json([
            'massage' => 'Succes Show Rents',
            'data' => $rent
        ]);
    }

    public function store(Request $request)
    {

        if (Auth::user()->role === 'tenant') {
            return response()->json([
                'message' => 'Invalid Role'
            ], 403);
        }

        if (!$request->token) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'no_car' => 'required',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'discount' => 'required',
            'total' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }


        $rent = new Rent();
        $rent->tenant = $request->tenant;
        $rent->no_car = $request->no_car;
        $rent->date_borrow = $request->date_borrow;
        $rent->date_return = $request->date_return;
        $rent->down_payment = $request->down_payment;
        $rent->discount = $request->discount;
        $rent->total = $request->total;
        $rent->status = 'borrow';
        $rent->save();

        return response()->json([
            'massage' => 'Create Rent Success'
        ], 200);
    }

    public function update(Request $request, $id)
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

        $rent = Rent::where('id', $id)->first();

        if (!$rent) {
            return response()->json([
                'message' => 'Rent Not Found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'tenant' => 'required',
            'no_car' => 'required',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'discount' => 'required',
            'total' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'massage' => 'Update rent Success'
            ], 422);
        }

        $rent->tenant = $request->tenant;
        $rent->no_car = $request->no_car;
        $rent->date_borrow = $request->date_borrow;
        $rent->date_return = $request->date_return;
        $rent->down_payment = $request->down_payment;
        $rent->discount = $request->discount;
        $rent->total = $request->total;
        $rent->status = 'borrow';
        $rent->save();

        return response()->json([
            'massage' => 'Update Rent Success'
        ], 200);
    }
}
