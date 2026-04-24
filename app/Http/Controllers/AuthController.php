<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterPatientRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\StoreSecretaryRequest;
use App\Http\Resources\Auth\loginResource;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function registerPatient(RegisterPatientRequest $request){


    $validated = $request->validated();

    $validated['password']=Hash::make($validated['password']);

    if($request->hasFile('id_card')){
        $validated['id_card']=$request->file('id_card')->store('id_cards','public');
    }
    if ($request->hasFile('profile_image')){
        $validated['profile_image']=$request->file('profile_image')->store('profile_images','public');
    }

    $user=User::create([
    'first_name'=>$validated['first_name'],
        'last_name'=>$validated['last_name'],
        'phone'=>$validated['phone'],
        'password'=>$validated['password'],
        'role'=>'patient',
        'gender'=>$validated['gender'],
            'birth_date'=>$validated['birth_date'],
    ]

    );

    $user->patient()->create([
    'blood_group'=>$validated['blood_group'],
    'weight'=>$validated['weight'],
    'tall'=>$validated['tall'],
        'id_card'=>$validated['id_card'],
        'profile_image'=>$validated['profile_image']??null,

        ]);
    $user->load('patient');
    return response()->json([
        'message'=>'Patient Registered Successfully',
        'user'=>new registerResource($user)
    ],201);


}
public function registerDoctor(StoreDoctorRequest $request){

    $validated=$request->validated();


    $validated['password']=Hash::make($validated['password']);


    $user=User::create([
    'first_name'=>$validated['first_name'],
    'last_name'=>$validated['last_name'],
    'email'=>$validated['email'],
    'phone'=>$validated['phone'],
    'password'=>$validated['password'],
    'role'=>'doctor',
    'gender'=>$validated['gender'],
        'birth_date'=>$validated['birth_date'],
    ]);

    $user->doctor()->create([

        ]);
    $user->load('doctor');//load information from the model of user to bring the information about the patient
    return response()->json([
    'message'=>'Doctor Registered Successfully',
    'user'=>new registerResource($user)
    ],201);
}
public function registerSecretary(StoreSecretaryRequest $request){
    $validated=$request->validated();
    $validated['password']=Hash::make($validated['password']);
    $user=User::create([
        'first_name'=>$validated['first_name'],
        'last_name'=>$validated['last_name'],
        'email'=>$validated['email'],
        'phone'=>$validated['phone'],
        'password'=>$validated['password'],
        'role'=>'secretary',
        'gender'=>$validated['gender'],
        'birth_date'=>$validated['birth_date'],
    ]);
    $user->secretary()->create([
        'section'=>$validated['section'],
    ]);
    $user->load('secretary');
    return response()->json([
        'message'=>'Secretary Registered Successfully',
        'user'=>new registerResource($user)
    ],201);
}
public function login(LoginRequest $request){
$validated=$request->validated();
    $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
//if (!Auth::attempt($request->only($field,'password')))
    if (!Auth::attempt([$field => $request->login, 'password' => $request->password])) {
    return response()->json([
        'message'=>'Invalid Credentials'
    ],401);
}
$user=Auth::user();
$token=$user->createToken('authToken')->plainTextToken;
    return response()->json([
        'message'=>'Login Successful',
        'token' => $token,
        'user' => $user
    ]);
}
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout Successful'
        ],200);
    }

}

