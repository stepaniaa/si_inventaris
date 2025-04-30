<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;
            switch ($role) {
                case 'staff':
                    return redirect('/staff_daftar_perlengkapan');
                case 'kaunit':
                    return redirect('/kaunit_daftar_kapel');
                default:
                    return redirect('/peminjam_beranda');
            }
        }

        return redirect('/login')->withErrors(['username' => 'Kredensial tidak valid.']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegistrationForm()
    {
        if (!Auth::check() || Auth::user()->role !== 'kaunit') {
            return redirect('/login')->with('error', 'Anda tidak memiliki izin untuk membuat akun pengguna.');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'kaunit') {
            return redirect('/login')->with('error', 'Anda tidak memiliki izin untuk membuat akun pengguna.');
        }

        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'name' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users',
            'role' => 'required|in:staff,kaunit',
            
        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        $password = Str::random(10);
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => $request->role,
        ]);

        if ($user->email) {
            Mail::send('emails.new_user', ['user' => $user, 'password' => $password], function ($message) use ($user, $password) {
                $message->to($user->email)->subject('Akun Sistem Inventaris Anda Telah Dibuat');
            });
        }

        return redirect('/register')->with('success', 'Akun berhasil dibuat dan detail login telah dikirim ke email pengguna (jika ada).');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.']);
        }

        $token = Str::random(60);
        $user->reset_token = Hash::make($token);
        $user->save();

        Mail::send('emails.reset_password', ['token' => $token, 'user' => $user], function ($message) use ($user) {
            $message->to($user->email)->subject('Permintaan Reset Password');
        });

        return back()->with('status', 'Tautan reset password telah dikirim ke email Anda.');
    }

    public function showResetForm(string $token)
    {
        $user = User::where('reset_token', Hash::make($token))->first();

        if (!$user) {
            return redirect('/login')->withErrors(['token' => 'Token reset password tidak valid.']);
        }

        return view('auth.passwords.reset')->with(['token' => $token, 'email' => $user->email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->token, $user->reset_token)) {
            return redirect('/login')->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->save();

        return redirect('/login')->with('status', 'Password Anda telah berhasil direset!');
    }
}