<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (!Auth::attempt($request->only('email', 'password'))) {
          return response()->json(['message' => 'Unauthorized'], 401);
        }
       $token = Auth::user()->createToken('MyApp')->plainTextToken;
        return response()->json(['user'=>Auth::user(),'token' => $token], 200);
    }
}
