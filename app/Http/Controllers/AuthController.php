<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // =========================
    // LOGIN
    // =========================

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            // ADMIN
            if (Auth::user()->is_admin) {

                return redirect('/admin/dashboard')
                    ->with('success', 'Login sebagai Admin berhasil!');
            }

            // USER BIASA
            return redirect('/')
                ->with('success', 'Login berhasil! Selamat datang.');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password salah. Silakan cek kembali atau daftar akun terlebih dahulu.',
            ])
            ->withInput($request->only('email'));
    }


    // =========================
    // REGISTER
    // =========================

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // PENTING:
            // akun yang daftar otomatis USER BIASA
            'is_admin' => false,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect('/')
            ->with('success', 'Akun berhasil dibuat! Selamat datang di Galaxy Books.');
    }


    // =========================
    // LOGOUT
    // =========================

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Kamu berhasil logout.');
    }
}