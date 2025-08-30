<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $request->session()->regenerate();

            // Chuyển hướng tùy theo role
            if ($user->isRoleAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('home'); // Route cho người dùng thường
            }
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.'
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'quyen' => 'user' // Hoặc User::ROLE_USER nếu có hằng số trong model

        ]);
        if ($user) {
            Mail::to($user->email)->send(new WelcomeMail($user));
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
