<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getUsers($id=null)
    {
        if(empty($id)){
            $users = User::all();
            return response()->json(["users" => $users]);
        }else{
            $users = User::find($id);
            return response()->json(["users" => $users]);
        }
    }

    public function addUsers(Request $request){

        if($request->isMethod('post')){
            $userData = $request->input();

            // Simple Post API Validation

            //Check User Details
            if(empty($userData['name']) || empty($userData['email']) || empty($userData['password'])){
                $error_message = "Please enter complete user details!";
            }

            //Check if email valid
            if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
                $error_message = "Please enter valid Email!";
            }

            //Check if User Email Already Exists
            $userCount = User::where('email',$userData['email'])->count();
            if ($userCount>0) {
                $error_message = "Email already exists!";
            }

            if (isset($error_message) && !empty($error_message)) {
                return response()->json(["status" => false, "message" => $error_message],422);
            }

            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->save();

            return response()->json(['message' => 'User added successfully!']);
        }
    }

    public function addMultipleUsers(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData); die;

            foreach ($userData['users'] as $key => $value) {
                $user = new User();
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = bcrypt($value['password']);
                $user->save();
            }

            return response()->json(['message' => 'Users added successfully!']);
        }
    }
}
