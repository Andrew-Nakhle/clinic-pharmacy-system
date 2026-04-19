<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterPatientRequest;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
public function registerPatient(RegisterPatientRequest $request){


    $validated = $request->validated();

    $validated['password']=Hash::make($validated['password']);

    if($request->hasFile('id_card')){
        $validated['id_card']=$request->file('id_card')->store('id_cards','public');
    }

    $user=User::create([
    'firstname'=>$validated['firstname'],
        'lastname'=>$validated['lastname'],
        'phone'=>$validated['phone'],
        'password'=>$validated['password'],
        'role'=>'patient',
        'gender'=>$validated['gender'],
    ]

    );
    $user->patient()->create([
    'blood_group'=>$validated['blood_group'],
    'weight'=>$validated['weight'],
    'height'=>$validated['height'],
        ]);

    return response()->json([
        'message'=>'Patient Registered Successfully',
        'data'=>$user
    ]);


}
public function registerDoctor(StoreDoctorRequest $request){

    $validated=$request->validated();


    $validated['password']=Hash::make($validated['password']);

$user=User::create([
    'firstname'=>$validated['firstname'],
    'lastname'=>$validated['lastname'],
    'email'=>$validated['email'],
    'phone'=>$validated['phone'],
    'password'=>$validated['password'],
    'role'=>'doctor',
    'gender'=>$validated['gender'],
    ]);
$user->doctor()->create([
    's'

]);
}
public function registerSecretary(Request $request){

}
public function login(Request $request){

}
public function logout(Request $request){

}

}

