<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TenantsController extends Controller
{
    public function index(Request $request)
    {
        // if (!$request->token) {
        //     return response()->json([
        //         'message' => 'forbidden'
        //     ], 403);
        // }

        $user = User::where('role', 'tenants')->with('tenant')->get();

        return response()->json([
            'message' => 'success get tenants',
            'data' => $user
        ], 200);
    }

    public function show(Request $request, $id)
    {
        // if (!$request->token) {
        //     return response()->json([
        //         'message' => 'forbidden'
        //     ], 403);
        // }

        $user = User::where('role', 'tenants')->with('tenant')->where('id', $id)->first();

        return response()->json([
            'message' => 'success get tenant',
            'data' => $user
        ], 200);
    }

    public function store(Request $request)
    {
        // if (Auth::user()->role === 'tenants') {
        //     return response()->json([
        //         'message' => 'Invalid Role'
        //     ], 403);
        // }


        // if (!$request->token) {
        //     return response()->json([
        //         'message' => 'forbidden'
        //     ], 403);
        // }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users,username|min:4',
            'password' => 'required|min:4',
            'no_ktp' => 'required|unique:tenants,no_ktp',
            'date_of_birth' => 'required',
            'name' => 'required',
            'role' => 'required',
            'profile_picture' => 'required|file|image',
            'email' => 'required|email',
            'phone' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'invalid field',
                'errors' => $validator->errors()
            ], 422);
        }



        $user = new User();
        $user->username = $request->username;
        $user->password = bcrypt($request->username);
        $user->role = 'tenants';
        $user->save();

        $gambar = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/profile_picture', $name);
            $gambar = "profile_picture/$name";
        }

        $tenant = new Tenant();
        $tenant->id_user = $user->id;
        $tenant->no_ktp = $request->no_ktp;
        $tenant->name = $request->name;
        $tenant->date_of_birth = $request->date_of_birth;
        $tenant->email = $request->email;
        $tenant->profile_picture = $gambar;
        $tenant->phone = $request->phone;
        $tenant->description = $request->description;
        $tenant->save();

        return response()->json([
            'message' => 'create register success'
        ], 200);
    }


    public function update(Request $request, $id)
    {
        // VALIDASI TOKEN
        // if (!$request->token) {
        //     return response()->json([
        //         'massage' => 'forbidden'
        //     ], 403);
        // }

        $tenant = Tenant::where('id_user', $id)->first();

        // VALIDASI REQUEST (REQUIRED, MIN, UNIQUE)
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:4|unique:users,username,' . $id,
            'password' => 'required|min:4',
            'no_ktp' => 'required|min:4|unique:tenants,no_ktp,' . $tenant->id,
            'date_of_birth' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'profile_picture' => 'required|file|image',
            'description' => 'required'

        ]);


        // RETURN JSON IF VALIDATION IS ERRORS

        if ($validator->fails()) {
            return response()->json([
                'massage' => 'Invalid field'
            ]);
        }

        // MAKE VARIABLE $USER USED IT FOR QUERY USER WHERE ID IS FROM PARAMETER $ID
        $user = User::where('role', 'tenants')->with('tenant')->where('id', $id)->first();

        $gambar = null;
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $name = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/bukti_transfer', $name);
            $gambar = "profile_picture/$name";
        }
        // UPDATE FIELD USER USE VARIABLE $USER (EXAMPLE: $USER->USERNAME = $REQ->USERNAME;)
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        // UPDATE FIELD FROM RELATION OF USERS (TENANT), EXAMPLE $USER->TENANT->NO_KTP = $REQ->NO_KTP;
        $user->tenant->no_ktp = $request->no_ktp;
        $user->profile_picture = $gambar;
        $user->tenant->name = $request->name;
        $user->tenant->date_of_birth = $request->date_of_birth;
        $user->tenant->email = $request->email;
        $user->tenant->phone = $request->phone;
        $user->tenant->description = $request->description;
        $user->save();
        $user->tenant->save();


        // LAST, U THROW RESPONSE JSON TO FRONTEND WITH MESSAGE "UPDATE TENANT SUCCESS" STATUS CODE 200

        return response()->json([
            'massage' => 'Update Tenant Success'
        ], 200);
    }

    public function destroy(Request $request, $id)
    {
        if (!$request->token) {
            return response([
                'massage' => 'Forbidden'
            ]);
        }

        $user = User::where('id', $id)->first();

        if (!$user) {
            return response()->json([
                'message' => 'Tenant Tidak Ditemukan'
            ], 404);
        }

        $tenant = Tenant::where('id_user', $id)->first();
        $tenant->delete();
        $user->delete();


        return response()->json([
            "massage" => "Berhasil Menghapus data"
        ]);
    }
}
