<?php

namespace App\Http\Controllers;

use App\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PeminjamAuthController extends Controller
{
     public function showRegistrationForm() {
        return view('auth.register_peminjam');
    }

    public function register_peminjam(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:peminjam',
            'password' => 'required|confirmed',
            'nim' => 'nullable',
        ]);

        $isUkdw = !empty($request->nim) && preg_match('/@(?:.*\.)?ukdw\.ac\.id$/i', $request->email);


$data = [
    'name' => $request->name,
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'nim' => $request->nim,
    'status_user' => $isUkdw ? 'ukdw' : 'non-ukdw',
    'peran' => $isUkdw ? $request->peran : 'Tamu Umum',
    'asal_unit' => $isUkdw ? $request->asal_unit : 'Eksternal / Umum',
        ];

        $peminjam = Peminjam::create($data);
        Auth::guard('peminjam')->login($peminjam);

        return redirect('/peminjam_beranda');
    }

    public function showLoginForm() {
        return view('auth.login_peminjam');
    }

    public function login_peminjam(Request $request) {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('peminjam')->attempt($credentials)) {
            return redirect('/peminjam_beranda');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    public function logout_peminjam() {
        Auth::guard('peminjam')->logout();
        return redirect('/login_peminjam');
    }

    public function dashboard() {
        $user = Auth::guard('peminjam')->user();
        return view('peminjam_beranda', compact('user'));
    }
}
