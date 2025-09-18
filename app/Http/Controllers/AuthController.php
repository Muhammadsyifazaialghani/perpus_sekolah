<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();

            if (Auth::user()->role !== 'user') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akses tidak sah untuk login pengguna.',
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
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'email' => ['required', 'email', 'unique:users,email', 'regex:/^[^@]+@gmail\.com$/'],
            'password' => ['required', 'confirmed', 'size:8'],
        ], [
            'username.unique' => 'Username sudah digunakan',
            'email.regex' => 'Email harus menggunakan @gmail.com',
            'password.size' => 'Password harus 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.login')
                ->withErrors($validator)
                ->withInput()
                ->with('registration_error', true);
        }

        $data = $validator->validated();
        $data['password'] = bcrypt($data['password']);
        $data['role'] = 'user';

        $user = \App\Models\User::create($data);
        Log::info('User created: ', ['user' => $user]);

        return redirect()->route('user.login')->with('success', 'Registrasi Berhasil.');
    }

    public function logout(Request $request)
    {
        // Periksa apakah user sudah login sebelum melakukan logout
        if (Auth::check()) {
            $role = Auth::user()->role;

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($role === 'admin') {
                return redirect('/admin/login')->with('success', 'kamu berhasil logout.');
            } else {
                return redirect()->route('user.login')->with('success', 'kamu berhasil logout.');
            }
        }

        // Jika user tidak login, redirect ke halaman login
        return redirect()->route('login')->with('error', 'Anda belum login.');
    }
}
