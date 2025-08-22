<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showUserLogin()
    {
        return view('auth.user-login');
    }

    public function returnBook()
    {
        return view('user.return_book');
    }

    public function userLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'user') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Unauthorized access for user login.',
                ]);
            }

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username Atau Password salah',
        ]);
    }

    public function showUserRegister()
    {
        return view('auth.user-register');
    }

    public function userRegister(Request $request)
    {
        Log::info('userRegister method called');
        $data = $request->validate([
            'username' => ['required', 'string', 'max:255','unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';

        $user = \App\Models\User::create($data);
        Log::info('User created: ', ['user' => $user]);

        return redirect()->route('user.login')->with('success', 'Registrasi Berhasil.');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['name' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'admin') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Unauthorized access for admin login.',
                ]);
            }

            // Redirect langsung ke panel admin Filament (/admin)
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
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
            return redirect()->route('admin.login')->with('success', 'kamu berhasil logout.');
        } else {
            return redirect()->route('user.login')->with('success', 'kamu berhasil logout.');
        }
    }
}
