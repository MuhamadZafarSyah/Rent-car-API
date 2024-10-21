<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Validator;
use Illuminate\support\Facades\Auth;

class PenaltiesController extends Controller
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

        $penalties = Penalty::all();

        return response()->json([
            'message' => 'Success Get Penalties',
            'data' => $penalties
        ], 200);
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

        $penalty = Penalty::findOrFail($id);

        return response()->json([
            'massage' => 'Succes Show Penalties',
            "data" => $penalty
        ]);
    }

    public function store(Request $request)
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

        $validator = Validator::make($request->all(), [
            'penalties_name' => 'required|min:4',
            'description' => 'required',
            'no_car' => 'required',
            'penalties_total' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $penalties = new Penalty();
        $penalties->penalties_name = $request->penalties_name;
        $penalties->description = $request->description;
        $penalties->no_car = $request->no_car;
        $penalties->penalties_total = $request->penalties_total;
        $penalties->save();

        return response()->json([
            'massasge' => 'Create Penalty Success',
        ]);
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

        $validator = Validator::make($request->all(), [
            'penalties_name' => 'required|min:4|unique:penalties,penalties_name,' . $id,
            'description' => 'required',
            'no_car' => 'required|unique:penalties,no_car,' . $id,
            'penalties_total' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }

        $penalties = Penalty::where('id', $id)->first();
        $penalties->penalties_name = $request->penalties_name;
        $penalties->description = $request->description;
        $penalties->no_car = $request->no_car;
        $penalties->penalties_total = $request->penalties_total;
        $penalties->save();

        return response()->json([
            'massage' => 'Update Penalties Success'
        ], 200);
    }

    public function destroy($id)
    {

        if (Auth::user()->role === 'tenants') {
            return response()->json([
                'message' => 'Invalid Role'
            ], 403);
        }

        $penalties = Penalty::findOrFail($id);
        $penalties->delete();

        return response()->json([
            'massage' => 'Delete Penalties Success'
        ]);
    }
}
