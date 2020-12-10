<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function formLogin(){
        return view("auth.login");
    }

    public function login(Request $request){
        $request->validate([
            "email" => "required|email|max:255",
            "password" => "required|min:6",
        ]);

        $credentials = $request->only("email", "password");
        $remember = $request->has("remember");

        if (Auth::attempt($credentials, $remember)){
            $request->session()->regenerate();

            return redirect()->intended("/");
        }

        return back()->withErrors([
            "email" => "Email atau Password salah."
        ]);
    }
}
