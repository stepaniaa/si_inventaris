<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kaunitController extends Controller
{
    public function kaunit_daftar_perlengkapan() { 
        return view('kaunit_daftar_perlengkapan',['key'=>'kaunit_daftar_perlengkapan']);
    }

    public function kaunit_daftar_kapel() { 
        return view('kaunit_daftar_kapel',['key'=>'kaunit_daftar_kapel']);
    }

    public function kaunit_validasi_pengadaan() { 
        return view('kaunit_validasi_pengadaan',['key'=>'kaunit_validasi_pengadaan']);
    }

    public function kaunit_validasi_perbaikan() { 
        return view('kaunit_validasi_perbaikan',['key'=>'kaunit_validasi_perbaikan']);
    }

    public function kaunit_validasi_penghapusan() { 
        return view('kaunit_validasi_penghapusan',['key'=>'kaunit_validasi_penghapusan']);
    }

    
}
