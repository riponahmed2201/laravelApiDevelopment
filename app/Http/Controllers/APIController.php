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
}
