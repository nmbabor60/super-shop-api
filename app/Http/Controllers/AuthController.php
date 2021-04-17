<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request){
       // return response()->json($request->all());
        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            $user = Auth::user();
            $result['token'] = $user->createToken('myApp')->accessToken;
            $result['name'] = $user->name;
            $result['email'] = $user->email;
            $result['id'] = $user->id;
            return response()->json(['message'=>'Successfully Logged in.','data'=>$result],200);

        }else{
            return response()->json(['error'=>'Credential Miss match'],401);
        }
    }
}
