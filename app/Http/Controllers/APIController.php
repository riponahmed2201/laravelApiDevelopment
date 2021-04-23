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
