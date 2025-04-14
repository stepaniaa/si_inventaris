<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class peminjamController extends Controller
{
    public function peminjam_beranda() { 
        return view('peminjam_beranda',['key'=>'peminjam_beranda']);
    }

    public function peminjam_peminjaman_barang() { 
        return view('peminjam_peminjaman_barang',['key'=>'peminjam_peminjaman_barang']);
    }

    public function peminjam_peminjaman_ruang() { 
        return view('peminjam_peminjaman_ruang',['key'=>'peminjam_peminjaman_ruang']);
    }

    public function peminjam_daftar_riwayat_peminjaman() { 
        return view('peminjam_daftar_riwayat_peminjaman',['key'=>'peminjam_daftar_riwayat_peminjaman']);
    }
}
