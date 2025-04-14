<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruang ; 
use App\Kategori ; 
use App\Perlengkapan ; 
use App\Pengadaan ; 


class staffController extends Controller
{
    public function staff_beranda() { 
        return view('staff_beranda',['key'=>'staff_beranda']);
    }
    
// Pengelolaan kategori 
    public function staff_daftar_kategori() { 
        $ktg = Kategori::orderby('id_kategori', 'asc')->paginate(10); 
        return view('staff_daftar_kategori',['key'=>'staff_daftar_kategori', 'ktg'=>$ktg]);
    }

    public function s_kategori_formadd(){ 
        return view('s_kategori_formadd',['key'=>'staff_daftar_kategori']);

    }

    public function save_kategori(Request $request){ 
       // $minat=implode(',', $request->get('minat')); 
        Kategori::create([ 
            //'id_kategori'=>$request->nim, 
            'nama_kategori'=>$request->nama_kategori, 
        ]);

        return redirect('staff_daftar_kategori');
    }

    public function s_kategori_formedit($id_kategori) { 
        $ktg = Kategori::find($id_kategori); 
        return view('s_kategori_formedit', ['key'=>'staff_daftar_kategori','ktg'=>$ktg]);
    
    }

    public function update_kategori($id_kategori, Request $request){ 
       // $minat=implode(',', $request->get('minat')); 
        $ktg = Kategori::find($id_kategori); 
        $ktg->nama_kategori = $request->nama_kategori;
        $ktg->save();

        return redirect('staff_daftar_kategori');

    }

    public function delete_kategori($id_kategori){ 
        $ktg = Kategori::find($id_kategori); 
        $ktg->delete();

        return redirect('staff_daftar_kategori');
 
    }

// Pengelolaan ruang 
    public function staff_daftar_ruang() { 
        $rng = Ruang::orderby('id_ruang', 'asc')->paginate(5); 
        return view('staff_daftar_ruang',['key'=>'staff_daftar_ruang', 'rng'=>$rng]);
    }

    public function s_ruang_formadd(){ 
        return view('s_ruang_formadd',['key'=>'staff_daftar_ruang']);

    }

    public function save_ruang(Request $request){ 
        Ruang::create([ 
            'kode_ruang'=>$request->kode_ruang,
            'nama_ruang'=>$request->nama_ruang, 
            'fasilitas_ruang'=>$request->fasilitas_ruang, 
            'kapasitas_ruang'=>$request->kapasitas_ruang, 
            'deskripsi_ruang'=>$request->deskripsi_ruang, 
            
        ]);

        return redirect('staff_daftar_ruang');
    }

    public function s_ruang_formedit($id_ruang) { 
        $rng = Ruang::find($id_ruang); 
        return view('s_ruang_formedit', ['key'=>'staff_daftar_ruang','rng'=>$rng]);
    }

    public function update_ruang($id_ruang, Request $request){ 
        $rng = Ruang::find($id_ruang); 
        $rng->nama_ruang = $request->nama_ruang;
        $rng->kapasitas_ruang = $request->kapasitas_ruang;
        $rng->fasilitas_ruang = $request->fasilitas_ruang;
        $rng->deskripsi_ruang = $request->deskripsi_ruang;
        $rng->save();

        return redirect('staff_daftar_ruang');


    }

    public function delete_ruang($id_ruang){ 
        $rng = Ruang::find($id_ruang); 
        $rng->delete();

        return redirect('staff_daftar_ruang');

    }

// Pengelolaan Perlengkapan 
    public function staff_daftar_perlengkapan() { 
        $pkp = Perlengkapan::with(['kategori', 'ruang']) ->orderBy('id_perlengkapan', 'asc')->paginate(5);
        return view('staff_daftar_perlengkapan', ['key' => 'staff_daftar_perlengkapan','pkp' => $pkp]);
        
    }

        public function s_perlengkapan_formadd(){ 
            return view('s_perlengkapan_formadd', [
                'key' => 'staff_daftar_perlengkapan',
                'ruang' => Ruang::all(),
                'kategori' => Kategori::all()
            ]);

        }

        public function save_perlengkapan(Request $request){ 
            $fotoPath = null;
            if ($request->hasFile('foto_perlengkapan')) {
                $fotoPath = $request->file('foto_perlengkapan')->store('perlengkapan', 'public');
            }
    
            // Simpan data
            Perlengkapan::create([
                'kode_perlengkapan' => $request->kode_perlengkapan,
                'nama_perlengkapan' => $request->nama_perlengkapan,
                'stok_perlengkapan' => $request->stok_perlengkapan,
                'harga_satuan_perlengkapan' => $request->harga_satuan_perlengkapan,
                'tanggal_beli_perlengkapan' => $request->tanggal_beli_perlengkapan,
                'kondisi_perlengkapan' => $request->kondisi_perlengkapan,
                'deskripsi_perlengkapan' => $request->deskripsi_perlengkapan,
                'foto_perlengkapan' => $fotoPath,
                'id_ruang' => $request->id_ruang,
                'id_kategori' => $request->id_kategori,
            ]);
    
            return redirect('staff_daftar_perlengkapan')->with('pesan', 'Data berhasil ditambah');
        }

        public function s_perlengkapan_formedit($id_perlengkapan) { 
            $pkp = Perlengkapan::find($id_perlengkapan);
        
            return view('s_perlengkapan_formedit', [
                'key' => 'staff_daftar_perlengkapan',
                'pkp' => $pkp,
                'ruang' => Ruang::all(),
                'kategori' => Kategori::all()
            ]);
        }

        public function update_perlengkapan($id_perlengkapan, Request $request){ 
            $pkp = Perlengkapan::find($id_perlengkapan);
        
            // Upload gambar baru jika ada
            if ($request->hasFile('foto_perlengkapan')) {
                // Hapus gambar lama jika ada
                if ($pkp->foto_perlengkapan) {
                    Storage::disk('public')->delete($pkp->foto_perlengkapan);
                }
                $fotoPath = $request->file('foto_perlengkapan')->store('perlengkapan', 'public');
                $pkp->foto_perlengkapan = $fotoPath;
            }

             // Update data lainnya
            $pkp->kode_perlengkapan = $request->kode_perlengkapan;
            $pkp->nama_perlengkapan = $request->nama_perlengkapan;
            $pkp->stok_perlengkapan = $request->stok_perlengkapan;
            $pkp->harga_satuan_perlengkapan = $request->harga_satuan_perlengkapan;
            $pkp->tanggal_beli_perlengkapan = $request->tanggal_beli_perlengkapan;
            $pkp->kondisi_perlengkapan = $request->kondisi_perlengkapan;
            $pkp->deskripsi_perlengkapan = $request->deskripsi_perlengkapan;
            $pkp->id_ruang = $request->id_ruang;
            $pkp->id_kategori = $request->id_kategori;
            $pkp->save();

            return redirect('staff_daftar_perlengkapan')->with('pesan', 'Data berhasil diupdate');
            }

        public function delete_perlengkapan($id_perlengkapan){ 
            $pkp = Perlengkapan::find($id_perlengkapan);
        
            // Hapus gambar jika ada
            if ($pkp->foto_perlengkapan) {
                Storage::disk('public')->delete($pkp->foto_perlengkapan);
            }
            
            $pkp->delete();

            return redirect('staff_daftar_perlengkapan')->with('pesan', 'Data berhasil dihapus');

        }

    


// NEW  SECTION - Pengelolaan Pengadaan 

    //public function staff_pengajuan_pengadaan() { 
        //return view('staff_pengajuan_pengadaan',['key'=>'staff_pengajuan_pengadaan']);
    //}

    public function staff_usulan_pengadaan() { 
        $pgd = Pengadaan::orderby('id_usulan_pengadaan', 'asc'); 
        return view('staff_usulan_pengadaan',['key'=>'staff_usulan_pengadaan', 'pgd'=>$pgd]);
    }

    public function staff_pengadaan_formadd(){ 
        return view('staff_pengadaan_formadd',['key'=>'staff_usulan_pengadaan']);

    }

    public function save_pengadaan(Request $request){ 
        Ruang::create([ 
            'nama_perlengkapan_usulan'=>$request->nama_perlengkapan_usulan,
            'jumlah_usulan_pengadaan'=>$request->jumlah_usulan_pengadaan, 
            'alasan_pengadaan'=>$request->alasan_pengadaan, 
            'tanggal_usulan_pengadaan'=>$request->tanggal_usulan_pengadaan, 
            //'tanggal_validasi_pengadaan'=>$request->tanggal_validasi_pengadaan, 
            //'catatan_pengadaan_kaunit'=>$request->catatan_pengadaan_kaunit, 
            
        ]);

        return redirect('staff_usulan_pengadaan');
    }

    public function staff_pengadaan_formedit($id_usulan_pengadaan) { 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        return view('staff_pengadaan_formedit', ['key'=>'staff_usulan_pengadaan','pgd'=>$pgd]);
    }

    public function update_pengadaan($id_usulan_pengadaan, Request $request){ 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        $pgd->nama_perlengkapan_usulan = $request->nama_perlengkapan_usulan;
        $pgd->jumlah_usulan_pengadaan = $request->jumlah_usulan_pengadaan;
        $pgd->alasan_pengadaan = $request->alasan_pengadaan;
        $pgd->tanggal_usulan_pengadaan = $request->tanggal_usulan_pengadaan;
        //$pgd->tanggal_validasi_pengadaan = $request->tanggal_validasi_pengadaan;
        //$pgd->catatan_pengadaan_kaunit = $request->catatan_pengadaan_kaunit;
        $pgd->save();

        return redirect('staff_usulan_pengadaan');

    }

    public function delete_pengadaan($id_usulan_pengadaan){ 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        $pgd->delete();

        return redirect('staff_usulan_pengadaan');
    }
    
    // NEW SECTION - Pengajuan Perbaikan 

    public function staff_usulan_perbaikan() { 
        $prb = Perbaikan::orderby('id_usulan_perbaikan', 'asc'); 
        return view('staff_usulan_perbaikan',['key'=>'staff_usulan_perbaikan', 'prb'=>$prb]);
    }

    public function staff_perbaikan_formadd(){ 
        return view('staff_perbaikan_formadd',['key'=>'staff_usulan_perbaikan']);

    }

    // Kelola penghapusan 

    public function staff_usulan_penghapusan() { 
        $phs = Penghapusan::orderby('id_usulan_penghapusan', 'asc'); 
        return view('staff_usulan_penghapusan',['key'=>'staff_usulan_penghapusan', 'prb'=>$prb]);
    }

    public function staff_penghapusan_formadd(){ 
        return view('staff_penghapusan_formadd',['key'=>'staff_usulan_penghapusan']);

    }

    // Pengelolaan Penghapusan


    public function staff_daftar_peminjaman() { 
        return view('staff_daftar_peminjaman',['key'=>'staff_daftar_peminjaman']);
    }

    public function staff_pengajuan_peminjaman() { 
        return view('staff_pengajuan_peminjaman',['key'=>'staff_pengajuan_peminjaman']);
    }

}
