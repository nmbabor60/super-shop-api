<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(){
        return view('users.index');
    }


    public function getAllUsers(){
       $users = User::get();
       // 200 = ok
       return response()->json($users);
    }

    public function storeUser(Request $request){
        $input = $request->all();
        $validator = Validator::make($input,[
           'name'=>'required',
           'email'=>'required|unique:users',
           'password'=>'required|min:8|confirmed'
        ]);
        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()],403);
        }


        $input['password'] = Hash::make($request->password);


       $user =  User::create($input);
       return response()->json($user,201);


    }

    public function userDelete($id){

        try{
            $user = User::find($id);
            if($user==''){
                return response()->json('User not found!',404);
            }
            $user->delete();


            return response()->json('Successfully Deleted!',200);

        }catch(\Exception $e){

            return response()->json(['error'=>$e->errorInfo[2]],500);
        }

    }



}
