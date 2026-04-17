<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class registerDoORSe extends Controller
{

    function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'gender' => 'required',
            'role'=> 'required|in:doctor,secretary',
            'specialization' => 'required_if:role,doctor|string',
            'qualification'=>'required_if:role,doctor|string',
            'experience_years'=>'required_if:role,doctor|string',
            'bio'=>'required_if:role,doctor|string',
            'app'=>'required_if:role,secretary|string',

        ]);
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'gender' => $validated['gender'],
            'role' => $validated['role'],
        ]);
        $user->assignRole($validated['role']);
        if($validated['role'] === 'Doctor'){
            $user->Doctor()->create([

            ]);
            //attributes for doctor
        }
        if($validated['role'] === 'secretary'){
            $user->Secretary()->create([
                'app'=>$validated['app']
            ]);
            //attributes for secretary
        }
        $user->load($validated['role']);
        return  response()->json(['message'=>"{$validated['role']}is registered successfully"
       ,'user'=>$user],201);
    }
}
