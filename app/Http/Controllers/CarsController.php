<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Validation\Validator as ValidationValidator;
use Symfony\Contracts\Service\Attribute\Required;

class CarsController extends Controller
{
    public function index(Request $request)
    {

        // if (Auth::user()->role === 'tenants') {
        //     return response()->json([
        //         'message' => 'Invalid Role'
        //     ], 403);
        // }

        if (!$request->token) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $cars = Car::all();

        return response()->json([
            'massage' => 'Success Get Cars',
            'data' => $cars
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

        $cars = Car::find($id);

        return response()->json([
            'massage' => 'Success show cars',
            'data' => $cars
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
            'name' => 'required|min:4|',
            'nopol' => 'required|min:4|unique:cars,nopol',
            'profile_picture' => 'required|file|image'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }



        $cars = new Car();
        $cars->name = $request->name;
        $cars->nopol = $request->nopol;
        $cars->status = 'Available';
        $cars->save();

        return response()->json([
            'massage' => 'Create cars success'
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
        if (!$request->token) {
            return response()->json([
                'message' => 'forbidden'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'nopol' => 'required|unique:cars,nopol,' . $id,
            'status' => 'required|',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'massage' => 'Invalid field'
            ]);
        }

        $cars = Car::where('id', $id)->first();

        $cars->name = $request->name;
        $cars->nopol = $request->nopol;
        $cars->status = $request->status;
        $cars->save();


        return response()->json([
            'massage' => 'Cars Update Success'
        ], 200);
    }

    public function destroy(Request $request, $id)
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
        $cars = Car::findOrFail($id);
        $cars->delete();

        return response()->json([
            'massage' => 'Cars Destroy Success'
        ]);
    }
}
