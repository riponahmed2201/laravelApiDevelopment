<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class APIController extends Controller
{
    public function getUsers($id=null)
    {
        if(empty($id)){
            $users = User::all();
            return response()->json(["users" => $users],200);
        }else{
            $users = User::find($id);
            return response()->json(["users" => $users],200);
        }
    }

    public function addUsers(Request $request){

        if($request->isMethod('post')){
            $userData = $request->input();

            // Simple Post API Validation

            // //Check User Details
            // if(empty($userData['name']) || empty($userData['email']) || empty($userData['password'])){
            //     $error_message = "Please enter complete user details!";
            // }

            // //Check if email valid
            // if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            //     $error_message = "Please enter valid Email!";
            // }

            // //Check if User Email Already Exists
            // $userCount = User::where('email',$userData['email'])->count();
            // if ($userCount>0) {
            //     $error_message = "Email already exists!";
            // }

            // if (isset($error_message) && !empty($error_message)) {
            //     return response()->json(["status" => false, "message" => $error_message],422);
            // }

            // Advanced Post API Validations

            $rules =[
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ];

            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'email.email' => 'Valid Email is required',
                'email.unique' => 'Email already exists in database',
                'password.required' => 'Password is required',
            ];

            $validators = Validator::make($userData, $rules,$customMessage);
            if ($validators->fails()) {
               return response()->json($validators->errors(),422);
            }

            $user = new User();
            $user->name = $userData['name'];
            $user->email = $userData['email'];
            $user->password = bcrypt($userData['password']);
            $user->save();

            return response()->json(['message' => 'User added successfully!'],201);
        }
    }

    public function addMultipleUsers(Request $request){
        if($request->isMethod('post')){
            $userData = $request->input();
            // echo "<pre>"; print_r($userData); die;

            $rules =[
                'users.*.name' => 'required|regex:/^[\pL\s\-]+$/u',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required'
            ];

            $customMessage = [
                'users.*.name.required' => 'Name is required',
                'users.*.email.required' => 'Email is required',
                'users.*.email.email' => 'Valid Email is required',
                'users.*.email.unique' => 'Email already exists in database',
                'users.*.password.required' => 'Password is required',
            ];

            $validators = Validator::make($userData, $rules,$customMessage);
            if ($validators->fails()) {
               return response()->json($validators->errors(),422);
            }

            foreach ($userData['users'] as $key => $value) {
                $user = new User();
                $user->name = $value['name'];
                $user->email = $value['email'];
                $user->password = bcrypt($value['password']);
                $user->save();
            }

            return response()->json(['message' => 'Users added successfully!'],201);
        }
    }
}
