<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registerPatient;
use App\Http\Controllers\registerDoORSe;
use App\Http\Controllers\loginController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('registerPatient',[registerPatient::class,'register']);
Route::post('login',[loginController::class,'login']);
Route::post('registerDoORSe', [registerDoORSe::class, 'register'])
    ->middleware(['auth:sanctum', 'permission:add_DoctorORSecretary']);
