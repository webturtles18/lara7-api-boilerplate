<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        
        $validator = Validator::make($request->all(), [
            'name' => "required|string",
            'email' => "required|string|unique:users,email",
            'password' => "required|string|confirmed"
        ]);
        
        if ($validator->fails()) {
            return response($validator->errors(),400);
        }
        else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ];
            $user = User::create($data);
            
            $token = $user->createToken('token')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ],201);
        }
    }
    
    public function login(Request $request){
        
        $validator = Validator::make($request->all(), [
            'email' => "required|string|email",
            'password' => "required|string"
        ]);
        
        if ($validator->fails()) {
            return response($validator->errors(),400);
        }
        else{
            // Check email
            $user = User::where('email',$request->email)->first();
            
            // Check password
            if(!$user || !Hash::check($request->password,$user->password)){
                return response([
                    'message' => "Bad Credentials"
                ],401);
            }
            
            $token = $user->createToken('token')->plainTextToken;
            return response([
                'user' => $user,
                'token' => $token
            ],201);
        }
    }
    
    public function logout(Request $request){
        auth()->user()->tokens()->delete();
        
        return [
            'message' => "Logged out"
        ];
    }
}
