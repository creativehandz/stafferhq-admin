<?php

namespace App\Http\Controllers;
use App\Models\User;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getUsersByRole($role)
{
    $users = User::where('role', $role)->get();
    return response()->json($users);
}
}
