<?php

namespace App\Http\Controllers;

// use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class logincontroller extends Controller
{
    public function halamanlogin()
    {
        $user = Auth::user();
        return view('login.loginaplikasi', ['user' => $user]);
    }
    public function postlogin(Request $request)
    {
        if (Auth::attempt($request->only('username', 'password'))) {
            $role = Auth::user()->role;
    
            if($role == 'customer') {
                return redirect('/');
            } elseif ($role == 'seller') {
                return redirect('/home');
            } elseif ($role == 'admin') {
                return redirect('/home');
            }
        }
        return redirect('/');
    }
    
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
