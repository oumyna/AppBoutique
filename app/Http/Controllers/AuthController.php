<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function auth_login(Request $request)
    {
        $remember = !empty($request->remember) ? true : false;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            return redirect('panel/dashboard');
        } else {
            return redirect()->back()->with('error', "Veuillez saisir votre adresse e-mail et votre mot de passe actuels");
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect(url(''));
    }
    
}

