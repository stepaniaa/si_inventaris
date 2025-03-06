<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    //User - Peminjam -------------------------------------------------------------------------------------------
    public function peminjam_home() { 
        return view('peminjam_home',['key'=>'peminjam_home']);
    }

    //Staff LPKKSK -----------------------------------------------------------------------------------------------

    public function staff_home() { 
        return view ('staff_home');
    }

    public function staff_daftar_kategori() { 
        return view ('staff_daftar_kategori');
    }

    public function staff_daftar_ruang() { 
        return view ('staff_daftar_ruang');
    }

    public function staff_daftar_barang () { 
        return view ('staff_daftar_barang');
    }

    public function staff_pengadaan() { 
        return view ('staff_pengadaan');
    }

    public function staff_perbaikan() { 
        return view ('staff_perbaikan');
    }

    public function staff_penghapusan() { 
        return view ('staff_penghapusan');
    }

    public function staff_daftar_peminjaman() { 
        return view ('staff_daftar_peminjaman');
    }

    public function staff_pengajuan_peminjaman() { 
        return view ('staff_pengajuan_peminjaman');
    }

    //Ketua LPKKSK -----------------------------------------------------------------------------------------------

}
