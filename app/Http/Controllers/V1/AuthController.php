<?php

namespace App\Http\Controllers\V1;
use Validator;
use Hash;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()) return response()->json($validator->messages(), 400);
        $data = $request->all();
        $token = auth()->attempt($data);
        return response()->json([
            'token' => $token
        ]);
        
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:20',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' =>  'required|min:8|confirmed',
        ]);
        if($validator->fails()) return response()->json($validator->messages(), 400);
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        unset($data['password_confirmation']);

        $created_user = User::create($data);
        if(!$created_user) return response()->json([
            'error' => 'error when creating a user'
        ], 500);
        $token = auth('api')->login($created_user);
        return response()->json([
            "token" => $token
        ]);
    }
}
