<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log; // Import Log

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
                    return redirect('/staff_beranda');
                case 'kaunit':
                    return redirect('/kaunit_daftar_kapel');
                case 'volunteer':
                    return redirect('/peminjam_beranda');
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

        $request->validate([
            'username' => 'required|unique:users',
            'name' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users',
            'role' => 'required|in:staff,kaunit,volunteer',
            'bagian' => 'nullable|string|max:255',
        ]);

        // Buat Password Sementara
        $passwordSementara = Str::random(8);

        // Membuat Pengguna Baru
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'password' => Hash::make($passwordSementara),
            'role' => $request->role,
            'bagian' => $request->bagian,
            'reset_token' => null, // Tambahkan reset_token
        ]);

        // Jika Pengguna Memiliki Email, Kirimkan Password Sementara
        if ($user->email) {
            try {
                Mail::send('emails.new_user', ['user' => $user, 'password' => $passwordSementara], function ($message) use ($user) {
                    $message->to($user->email)->subject('Akun Sistem Inventaris Anda Telah Dibuat');
                });
                Log::info('Email berhasil dikirim ke: ' . $user->email); // Tambahkan log sukses
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email ke: ' . $user->email . ' dengan error: ' . $e->getMessage()); // Tambahkan log error
                // Opsional: Tampilkan pesan error kepada pengguna
                return back()->with('error', 'Gagal mengirim email. Silakan hubungi administrator.');
            }
        }

        return redirect('/kaunit_daftar_user')->with('success', 'Akun berhasil dibuat dengan password sementara.');
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
    $user = User::where('reset_token', $token)->first();
        if (!$user) {
            return redirect('/login')->withErrors(['token' => 'Token reset password tidak valid.']);
        }

        return view('auth.reset_password')->with(['token' => $token, 'email' => $user->email]);
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
        $user->reset_token = null; // Clear the token
        $user->save();

        return redirect('/login')->with('status', 'Password Anda telah berhasil direset!');
    }

    public function ubah_password()
    {
    $user = Auth::user();
        return view('ubah_password', compact('user'));
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user(); 

        if (!Hash::check($request->password_lama, $user->password)) {
            return back()>with('error', 'Kesalahan');
        }

        $user->password = Hash::make($request->password_baru);
        //$user->reset_token = null; // Clear the token
        $user->save();
        Auth::logout();

        return redirect('/login')->with('status', 'Password Anda telah berhasil direset!');
    }
}