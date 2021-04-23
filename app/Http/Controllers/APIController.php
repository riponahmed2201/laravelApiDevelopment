<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
    public function getUsers()
    {
        $users = User::all();
        return response()->json(["users" => $users]);
    }
}
