<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{


//  -------------- Login --------------
 public function login(Request $request) {

      $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:4',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors()
        ], 422);
    }
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Wrong email or password'
            ], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'token' => $token,
            'token_type' => 'Bearer',
             'user' => $user
        ]);
    }



 

    // ----------------- Log out ---------------

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['status' => true, 'message' => 'loged out completed']);
    }
}
