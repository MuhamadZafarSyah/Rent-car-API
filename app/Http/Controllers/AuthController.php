<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username'  => 'required',
            'password' => 'required'
        ]);

        $user = User::firstWhere('username', $request->username);

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'massage' => 'invalid Login'
            ], 401);
        }

        return response()->json([
            "Token"  => $user->createToken('user login')->plainTextToken
        ]);
    }
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'massage' => 'logout success'
        ]);
    }
}
