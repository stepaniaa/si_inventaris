<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengadaan ; 
use App\Perbaikan ; 
use App\Penghapusan ; 
use App\User ; 
use App\Ruang ; 
use App\Perlengkapan ; 
use Illuminate\Support\Facades\Auth; 
class kaunitController extends Controller
{
    public function createUserForm()
    {
        return view('kaunit.create_user');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'nomor_pegawai' => 'required|string|max:255',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|regex:/@ukdw\.ac\.id$/',
            'role' => 'required|in:staff,kaunit',
            'jabatan' => 'required|string|max:255',
        ]);

        $password = Str::random(10);

        $user = User::create([
            'nomor_pegawai' => $request->nomor_pegawai,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($password),
            'jabatan' => $request->jabatan,
        ]);

        // Kirim email
        Mail::to($user->email)->send(new AccountCreated($user, $password));

        return redirect()->back()->with('success', 'Akun berhasil dibuat. Email dikirim ke pengguna.');
    }

    public function kaunit_daftar_kapel() { 
        $rng = Ruang::orderby('id_ruang', 'asc')->paginate(5); 
        return view('kaunit_daftar_kapel',['key'=>'kaunit_daftar_kapel', 'rng'=>$rng]);
    }

    public function kaunit_daftar_perlengkapan() { 
        $pkp = Perlengkapan::with(['kategori', 'ruang']) ->orderBy('id_perlengkapan', 'asc')->paginate(5);
        return view('kaunit_daftar_perlengkapan',['key'=>'kaunit_daftar_perlengkapan', 'pkp'=>$pkp]);
    }

    //Kelola Pengadaan
    public function kaunit_usulan_pengadaan()
    {
        $usulans = Pengadaan::orderBy('id_usulan_pengadaan', 'asc')->paginate(10);
        return view('kaunit_usulan_pengadaan', ['key'=>'kaunit_usulan_pengadaan','usulans' => $usulans]);
    }

    public function form_validasi_pengadaan(Pengadaan $pengadaan)
    {
        $pengadaan->load('staff'); 
        return view('form_validasi_pengadaan', ['key' => 'form_validasi_pengadaan', 'pengadaan' => $pengadaan]);
    }

    public function save_validasi_pengadaan(Request $request, Pengadaan $pengadaan)
    {
        $request->validate([
            'status_usulan_pengadaan' => 'required|in:diterima,ditolak',
            'catatan_pengadaan_kaunit' => 'nullable|string|max:255',
        ]);

        $pengadaan->update([
            'status_usulan_pengadaan' => $request->status_usulan_pengadaan,
            'catatan_pengadaan_kaunit' => $request->catatan_pengadaan_kaunit,
            'tanggal_persetujuan_kaunit' => now(),
            'id_kaunit' => Auth::id(),
        ]);

        return redirect('kaunit_usulan_pengadaan')->with('success', 'Usulan pengadaan berhasil diupdate.');
    }

    //Kelola Perbaikan
    public function kaunit_usulan_perbaikan()
    {
        $usulans = Perbaikan::orderBy('id_usulan_perbaikan', 'desc')->paginate(10);
        return view('kaunit_usulan_perbaikan', ['key'=>'kaunit_usulan_perbaikan','usulans' => $usulans]);
    }

    public function form_validasi_perbaikan(Perbaikan $perbaikan)
    {
        $perbaikan->load('staff'); 
        return view('form_validasi_perbaikan', ['key' => 'form_validasi_perbaikan', 'perbaikan' => $perbaikan]);
    }

    public function save_validasi_perbaikan(Request $request,Perbaikan $perbaikan)
    {
        $request->validate([
            'status_usulan_perbaikan' => 'required|in:diterima,ditolak',
            'catatan_perbaikan_kaunit' => 'nullable|string|max:255',
        ]);

        $perbaikan->update([
            'status_usulan_perbaikan' => $request->status_usulan_perbaikan,
            'catatan_perbaikan_kaunit' => $request->catatan_perbaikan_kaunit,
            'tanggal_persetujuan_kaunit' => now(),
            'id_kaunit' => Auth::id(),
        ]);

        return redirect('kaunit_usulan_perbaikan')->with('success', 'Usulan perbaikan berhasil diupdate.');
    }


    //Kelola Penghapusan
    public function kaunit_usulan_penghapusan()
    {
        $usulans = Penghapusan::orderBy('id_usulan_penghapusan', 'desc')->paginate(10);
        return view('kaunit_usulan_penghapusan', ['key'=>'kaunit_usulan_penghapusan','usulans' => $usulans]);
    }

    public function form_validasi_penghapusan(Penghapusan $penghapusan)
    {
        $penghapusan->load('staff'); 
        return view('form_validasi_penghapusan', ['key' => 'form_validasi_penghapusan', 'penghapusan' => $penghapusan]);
    }

    public function save_validasi_penghapusan(Request $request,Penghapusan $penghapusan)
    {
        $request->validate([
            'status_usulan_penghapusan' => 'required|in:diterima,ditolak',
            'catatan_penghapusan_kaunit' => 'nullable|string|max:255',
        ]);

        $penghapusan->update([
            'status_usulan_penghapusan' => $request->status_usulan_penghapusan,
            'catatan_penghapusan_kaunit' => $request->catatan_penghapusan_kaunit,
            'tanggal_persetujuan_kaunit' => now(),
            'id_kaunit' => Auth::id(),
        ]);

        return redirect('kaunit_usulan_penghapusan')->with('success', 'Usulan penghapusan berhasil diupdate.');
    }


    


    
}
