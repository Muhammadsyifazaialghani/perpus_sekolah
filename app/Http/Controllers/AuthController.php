<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showUserLogin()
    {
        return view('auth.user-login');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'user') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Unauthorized access for user login.',
                ]);
            }

            return redirect()->intended('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showUserRegister()
    {
        return view('auth.user-register');
    }

    public function userRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';

        \App\Models\User::create($data);

        return redirect()->route('login')->with('success', 'Registration successful. Please login.');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Unauthorized access for admin login.',
                ]);
            }

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function showAdminRegister()
    {
        return view('auth.admin-register');
    }

    public function adminRegister(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'admin';

        \App\Models\User::create($data);

        return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
    }

    public function logout(Request $request)
    {
        $role = Auth::user() ? Auth::user()->role : null;

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($role === 'admin') {
            return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
        } else {
            return redirect()->route('login')->with('success', 'You have been successfully logged out.');
        }
    }
}
