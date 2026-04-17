<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class registerPatient extends Controller
{
        function register(Request $request)
        {
            $validated= $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
                'phone' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'gender' => 'required',
                'blood_group' => 'required',
                'tall'=>'required',
                'weight'=>'required',

            ]);
            $validated['role'] = 'patient';
            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'gender' => $validated['gender'],
                'role' => $validated['role'],
            ]);
            $user->patient()->create([
                'blood_group' => $validated['blood_group'],
                'tall' => $validated['tall'],
                'weight' => $validated['weight'],
            ]);
            $user->assignRole('patient');
            return response()->json(['message' => 'User registered successfully',
                'user'=>$user],201);
        }
}

