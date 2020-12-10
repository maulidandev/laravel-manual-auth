<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function formRegister(){
        return view("auth.register");
    }

    public function register(Request $request){
        $request->validate([
            "name" => "required|max:255",
            "email" => "required|email|max:255|unique:users",
            "password" => "required|min:6|confirmed"
        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        Auth::login($user);

        return redirect()->route("login")->with("success", "User successfully register. Login using your email and password.");
    }
}
