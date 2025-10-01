<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserList;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'mobileNumber' => 'required',
            'password' => 'required',
        ]);

        $user = UserList::where('loginId', $request->mobileNumber)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->has('remember'));
            return redirect()->intended('dashboard'); // Replace 'dashboard' with your intended route
        }

        return back()->withErrors([
            'loginId' => "Credentials Don't Match Our Records.",
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
        return redirect()->route('login');
    }
}