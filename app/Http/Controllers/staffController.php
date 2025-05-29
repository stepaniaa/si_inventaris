<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Ruang ; 
use App\Kategori ; 
use App\Perlengkapan ; 
use App\Pengadaan ; 
use App\Penghapusan ; 
use App\Perbaikan ; 
use App\PeminjamanKapel ; 
use App\PeminjamanPkp ; 
use App\SesiPkp ; 
use App\SesiKapel ; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use App\Mail\SlipPeminjamanRuangDisetujui;
use App\Mail\SlipPeminjamanKapelDitolak;
use App\Mail\SlipPeminjamanPkpDisetujui;
use App\Mail\SlipPeminjamanPkpDitolak;
use App\Mail\KonfirmasiPembatalanSesiKapel;
use App\Mail\KonfirmasiPembatalanSesiPkp;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini untuk mengimpor kelas DB


class staffController extends Controller
{
    public function staff_beranda() { 

         return view('staff_beranda', [
        'jumlah_kategori' => Kategori::count(),
        'jumlah_ruang' => Ruang::count(),
        'jumlah_perlengkapan' => Perlengkapan::count(),
        'jumlah_pengadaan' => Pengadaan::count(),
        'jumlah_perbaikan' => Perbaikan::count(),
        'jumlah_penghapusan' => Penghapusan::count(),
        'jumlah_peminjaman_pkp' => SesiPkp::where('status_sesi', 'aktif')
            ->where('status_pengembalian', 'belum')
            ->count(),
        'jumlah_peminjaman_kapel' => SesiKapel::where('status_sesi', 'aktif')
            ->where('status_pengembalian_kp', 'belum')
            ->count(),
        'jumlah_peminjaman_pkp_wait' => PeminjamanPkp::where('status_pk', 'diproses')->count(),
        'jumlah_peminjaman_kpl_wait' => PeminjamanKapel::where('status_pengajuan', 'proses')->count(),
    ]);
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

        return redirect('staff_daftar_kategori')->with('success', 'Data kategori berhasil ditambahkan.');
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

        return redirect('staff_daftar_kategori')->with('success', 'Data kategori berhasil diubah.');

    }

    public function delete_kategori($id_kategori){ 
        $ktg = Kategori::find($id_kategori); 
        $ktg->delete();

        return redirect('staff_daftar_kategori')->with('danger', 'Data kategori berhasil dihapus.');
 
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
            'bisa_dipinjam' => $request->bisa_dipinjam,
            'lokasi_ruang' => $request->lokasi_ruang,

            
        ]);

        return redirect('staff_daftar_ruang')->with('success', 'Data kapel berhasil ditambahkan.');
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
        $rng->bisa_dipinjam = $request->bisa_dipinjam;
        $rng->lokasi_ruang = $request->lokasi_ruang;    
        $rng->save();

        return redirect('staff_daftar_ruang')->with('success', 'Data kapel berhasil diubah.');

    }

    public function delete_ruang($id_ruang){ 
        $rng = Ruang::find($id_ruang); 
        $rng->delete();

        return redirect('staff_daftar_ruang')->with('danger', 'Data kapel berhasil dihapus.');
    }

// Pengelolaan Perlengkapan 
    public function staff_daftar_perlengkapan() { 
        $pkp = Perlengkapan::with(['kategori', 'ruang']) ->orderBy('id_perlengkapan', 'asc')->paginate(5);
        return view('staff_daftar_perlengkapan', ['key' => 'staff_daftar_perlengkapan','pkp' => $pkp]);
        
    }

    //search 
    public function search(Request $request){ 
        $cari = $request->p; 
        $pkp = Perlengkapan::where('nama_perlengkapan','like','%'.$cari.'%')->paginate(10); 
        //$mhs = Mahasiswa::where('nama','like','%'.$cari.'%')->orwhere('nim','like','%'.$cari.'%')->paginate(10);
        $pkp->appends($request->all());
        return view('staff_daftar_perlengkapan',['key'=>'staff_daftar_perlengkapan','pkp'=> $pkp]);
    }


        public function s_perlengkapan_formadd(){ 
            return view('s_perlengkapan_formadd', [
                'key' => 'staff_daftar_perlengkapan',
                'ruang' => Ruang::all(),
                'kategori' => Kategori::all()
            ]);

        }

        public function save_perlengkapan(Request $request){ 
            $request->validate([
                'foto_perlengkapan' => 'image|mimes:jpeg,png,jpg|max:2048', // validasi file
            ]);
        
            $fotoPath = null;
            if ($request->hasFile('foto_perlengkapan')) {
                $fotoPath = $request->file('foto_perlengkapan')->store('perlengkapan', 'public');
            }
        
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
                'bisa_dipinjam_pk' => $request->bisa_dipinjam_pk,
                'status_perlengkapan' => 'aktif', // Set nilai default di sini
            ]);
        
            return redirect('staff_daftar_perlengkapan')->with('success', 'Data perlengkapan berhasil ditambahkan.');
        }
        

        public function s_perlengkapan_formedit($id_perlengkapan){

        $pkp = Perlengkapan::findOrFail($id_perlengkapan);

        // Pastikan tanggal_beli_perlengkapan adalah objek Carbon
        if ($pkp->tanggal_beli_perlengkapan) {
            $pkp->tanggal_beli_perlengkapan = Carbon::parse($pkp->tanggal_beli_perlengkapan);
        }

        return view('s_perlengkapan_formedit', [
            'key' => 'staff_daftar_perlengkapan',
            'pkp' => $pkp,
            'ruang' => Ruang::all(),
            'kategori' => Kategori::all()
        ]);
    }

    public function update_perlengkapan($id_perlengkapan, Request $request)
    {
        $request->validate([
            'foto_perlengkapan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $pkp = Perlengkapan::findOrFail($id_perlengkapan);

        if ($request->hasFile('foto_perlengkapan')) {
            if ($pkp->foto_perlengkapan) {
                Storage::disk('public')->delete($pkp->foto_perlengkapan);
            }
            $fotoPath = $request->file('foto_perlengkapan')->store('perlengkapan', 'public');
            $pkp->foto_perlengkapan = $fotoPath;
        }

        $pkp->kode_perlengkapan = $request->kode_perlengkapan;
        $pkp->nama_perlengkapan = $request->nama_perlengkapan;
        $pkp->stok_perlengkapan = $request->stok_perlengkapan;
        $pkp->harga_satuan_perlengkapan = $request->harga_satuan_perlengkapan;
        $pkp->tanggal_beli_perlengkapan = $request->tanggal_beli_perlengkapan;
        $pkp->kondisi_perlengkapan = $request->kondisi_perlengkapan;
        $pkp->deskripsi_perlengkapan = $request->deskripsi_perlengkapan;
        $pkp->id_ruang = $request->id_ruang;
        $pkp->id_kategori = $request->id_kategori;
        $pkp->bisa_dipinjam_pk = $request->bisa_dipinjam_pk;
        $pkp->status_perlengkapan = $request->status_perlengkapan;
        $pkp->save();

        return redirect('staff_daftar_perlengkapan')->with('success', 'Data perlengkapan berhasil diubah.');
    }

    public function delete_perlengkapan($id_perlengkapan)
    {
        $pkp = Perlengkapan::findOrFail($id_perlengkapan);

        // Hapus gambar jika ada
        if ($pkp->foto_perlengkapan) {
            Storage::disk('public')->delete($pkp->foto_perlengkapan);
        }

        $pkp->delete();

        return redirect('staff_daftar_perlengkapan')->with('danger', 'Data perlengkapan berhasil dihapus.');
    } 

    


// NEW  SECTION - Pengelolaan Pengadaan 


    public function staff_usulan_pengadaan() { 
        $pgd = Pengadaan::where('id_staff', Auth::id())->orderBy('id_usulan_pengadaan', 'desc')->paginate(5);
        return view('staff_usulan_pengadaan', ['key' => 'staff_usulan_pengadaan', 'pgd' => $pgd]);
    }

    public function staff_pengadaan_formadd(){ 
        return view('staff_pengadaan_formadd',['key'=>'staff_usulan_pengadaan']);

    }

    public function save_pengadaan(Request $request){ 
        $request->validate([
            'nama_perlengkapan_pengadaan' => 'required|string|max:255', // Sesuaikan validasi
            'jumlah_usulan_pengadaan' => 'required|integer|min:1',
            'alasan_pengadaan' => 'required|string|max:255',
            'estimasi_harga' => 'required|numeric|min:0',
            //'tanggal_usulan_pengadaan' => 'required|date',
        ]);

        Pengadaan::create([
            'id_staff' => Auth::id(), // Menggunakan ID staff yang sedang login
            'nama_perlengkapan_pengadaan' => $request->nama_perlengkapan_pengadaan, // Sesuaikan nama kolom
            'jumlah_usulan_pengadaan' => $request->jumlah_usulan_pengadaan,
            'alasan_pengadaan' => $request->alasan_pengadaan,
            'estimasi_harga' => $request->estimasi_harga,
            'tanggal_usulan_pengadaan' => now(),
            // Status awal bisa diatur di sini jika perlu, atau akan menggunakan default di migration ('diproses')
        ]);

        return redirect('staff_usulan_pengadaan')->with('success', 'Usulan pengadaan berhasil ditambahkan.'); // Tambahkan pesan sukses
    }

    public function staff_pengadaan_formedit($id_usulan_pengadaan) { 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        return view('staff_pengadaan_formedit', ['key'=>'staff_usulan_pengadaan','pgd'=>$pgd]);
    }

    public function update_pengadaan($id_usulan_pengadaan, Request $request){ 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        $pgd->nama_perlengkapan_pengadaan = $request->nama_perlengkapan_pengadaan;
        $pgd->jumlah_usulan_pengadaan = $request->jumlah_usulan_pengadaan;
        $pgd->alasan_pengadaan = $request->alasan_pengadaan;
        $pgd->estimasi_harga = $request->estimasi_harga;
        $pgd->tanggal_usulan_pengadaan = $request->tanggal_usulan_pengadaan;
        //$pgd->tanggal_validasi_pengadaan = $request->tanggal_validasi_pengadaan;
        //$pgd->catatan_pengadaan_kaunit = $request->catatan_pengadaan_kaunit;
        $pgd->save();

        return redirect('staff_usulan_pengadaan')->with('success', 'Usulan pengadaan berhasil diupdate.');;

    }

    public function delete_pengadaan($id_usulan_pengadaan){ 
        $pgd = Pengadaan::find($id_usulan_pengadaan); 
        $pgd->delete();

        return redirect('staff_usulan_pengadaan')->with('danger', 'Usulan pengadaan dihapus');;
    }
    

//------------------------------------------------------------------------------------------------------

    // Pengelolaan Perbaikan 

    public function staff_usulan_perbaikan() { 
        $prb = Perbaikan::where('id_staff', Auth::id())->orderBy('id_usulan_perbaikan', 'desc')->paginate(10);
        return view('staff_usulan_perbaikan', ['key' => 'staff_usulan_perbaikan', 'prb' => $prb]);
    }

    public function staff_perbaikan_formadd(){ 
        $perlengkapan = Perlengkapan::all(); 
        return view('staff_perbaikan_formadd', ['key' => 'staff_usulan_perbaikan', 'perlengkapan' => $perlengkapan]);

    }

    public function save_perbaikan(Request $request){ 
        $request->validate([
            'alasan_perbaikan' => 'required|string|max:50',
            'estimasi_harga_perbaikan' => 'nullable|numeric|min:0',
            'foto_perbaikan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $fotoPath = $request->file('foto_perbaikan')->store('public/foto_perbaikan');
    
        Perbaikan::create([
            'id_staff' => Auth::id(),
            'id_perlengkapan' => $request->id_perlengkapan,
            //'kode_perlengkapan' => $request->kode_perlengkapan, // Ini penting
            'alasan_perbaikan' => $request->alasan_perbaikan,
            'estimasi_harga_perbaikan' => $request->estimasi_harga_perbaikan,
            'tanggal_usulan_perbaikan' => now(),
            'foto_perbaikan' => basename($fotoPath),
        ]);
    
        return redirect('staff_usulan_perbaikan')->with('success', 'Usulan perbaikan berhasil ditambahkan.');
    }

    public function staff_perbaikan_formedit($id_usulan_perbaikan) { 
        $prb = Perbaikan::find($id_usulan_perbaikan); 
        return view('staff_perbaikan_formedit', ['key'=>'staff_usulan_perbaikan','prb'=>$prb]);
    }

    public function update_perbaikan($id_usulan_perbaikan, Request $request){ 
        $prb = Perbaikan::findOrFail($id_usulan_perbaikan);

    $request->validate([
        //'kode_perlengkapan' => 'required|string|max:50',
        //'jumlah_usulan_perbaikan' => 'required|integer|min:1',
        'alasan_perbaikan' => 'required|string|max:50',
        'estimasi_harga_perbaikan' => 'nullable|numeric|min:0',
       // 'tanggal_usulan_perbaikan' => 'required|date',
        'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto sekarang opsional
        // 'tanggal_persetujuan_perbaikan' => 'nullable|date',
        // 'catatan_perbaikan_kaunit' => 'nullable|string|max:255',
    ]);

   // $prb->kode_perlengkapan = $request->kode_perlengkapan;
   // $prb->jumlah_usulan_perbaikan = $request->jumlah_usulan_perbaikan;
    $prb->alasan_perbaikan = $request->alasan_perbaikan;
    $prb->estimasi_harga_perbaikan = $request->estimasi_harga_perbaikan;
    $prb->tanggal_usulan_perbaikan = now();
    // $prb->tanggal_persetujuan_perbaikan = $request->tanggal_persetujuan_perbaikan;
    // $prb->catatan_perbaikan_kaunit = $request->catatan_perbaikan_kaunit;

    // Handle update foto jika ada file yang diunggah
    if ($request->hasFile('foto_perbaikan')) {
        // Hapus foto lama jika ada
        if ($prb->foto_perbaikan) {
            Storage::delete('public/foto_perbaikan/' . $prb->foto_perbaikan);
        }

        // Simpan foto baru
        $fotoPath = $request->file('foto_perbaikan')->store('public/foto_perbaikan');
        $prb->foto_perbaikan = basename($fotoPath);
    }

    $prb->save();

    return redirect('staff_usulan_perbaikan')->with('success', 'Usulan perbaikan berhasil diupdate.');

    }

    public function delete_perbaikan($id_usulan_perbaikan) { 
    $prb = Perbaikan::findOrFail($id_usulan_perbaikan); 
    $prb->delete();
    return redirect('staff_usulan_perbaikan')->with('danger', 'Usulan perbaikan berhasil dihapus.');
}

    

    ///////////////////////////////////////////////////////////////////////////////////////////////////////

    //NEW SECTION - Pengelolaan Penghapusan

    public function staff_usulan_penghapusan() { 
        $phs = Penghapusan::where('id_staff', Auth::id())->orderBy('id_usulan_penghapusan', 'desc')->paginate(10);
        return view('staff_usulan_penghapusan', ['key' => 'staff_usulan_penghapusan', 'phs' => $phs]);
    }

    public function staff_penghapusan_formadd(){ 
        $perlengkapan = Perlengkapan::all(); 
        return view('staff_penghapusan_formadd', ['key' => 'staff_usulan_penghapusan', 'perlengkapan' => $perlengkapan]);

    }

    public function save_penghapusan(Request $request){ 
        $request->validate([
            'alasan_penghapusan' => 'required|string|max:50',
            'foto_penghapusan' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $fotoPath = $request->file('foto_penghapusan')->store('public/foto_penghapusan');
    
        Penghapusan::create([
            'id_staff' => Auth::id(),
            'id_perlengkapan' => $request->id_perlengkapan,
            'alasan_penghapusan' => $request->alasan_penghapusan,
            'tanggal_usulan_penghapusan' => now(),
            'foto_penghapusan' => basename($fotoPath),
        ]);
    
        return redirect('staff_usulan_penghapusan')->with('success', 'Usulan penghapusan berhasil ditambahkan.');
    }

    public function staff_penghapusan_formedit($id_usulan_penghapusan) { 
        $phs = Penghapusan::find($id_usulan_penghapusan); 
        return view('staff_penghapusan_formedit', ['key'=>'staff_usulan_penghapusan','phs'=>$phs]);
    }

    public function update_penghapusan($id_usulan_penghapusan, Request $request){ 
        $phs = Penghapusan::findOrFail($id_usulan_penghapusan);

    $request->validate([
        'jumlah_usulan_penghapusan' => 'required|integer|min:1',
        'alasan_penghapusan' => 'required|string|max:50',
        'tanggal_usulan_penghapusan' => 'required|date',
        'foto_penghapusan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto sekarang opsional
    ]);

   // $prb->kode_perlengkapan = $request->kode_perlengkapan;
    $prb->jumlah_usulan_penghapusan = $request->jumlah_usulan_penghapusan;
    $prb->alasan_penghapusan = $request->alasan_perbaikan;
    $prb->tanggal_usulan_penghapusan = $request->tanggal_usulan_penghapusan;
    // $prb->tanggal_persetujuan_perbaikan = $request->tanggal_persetujuan_perbaikan;
    // $prb->catatan_perbaikan_kaunit = $request->catatan_perbaikan_kaunit;

    // Handle update foto jika ada file yang diunggah
    if ($request->hasFile('foto_penghapusan')) {
        // Hapus foto lama jika ada
        if ($phs->foto_penghapusan) {
            Storage::delete('public/foto_penghapusan/' . $prb->foto_penghapusan);
        }

        // Simpan foto baru
        $fotoPath = $request->file('foto_penghapusan')->store('public/foto_penghapusan');
        $phs->foto_penghapusan = basename($fotoPath);
    }

    $phs->save();

    return redirect('staff_usulan_penghapusan')->with('success', 'Usulan penghapusan berhasil diupdate.');

    }

    public function delete_penghapusan($id_usulan_penghapusan){ 
        $phs = Penghapusan::findOrFail($id_usulan_penghapusan); 
        $phs->delete();

    return redirect('staff_usulan_penghapusan')->with('danger', 'Usulan penghapusan berhasil dihapus.');
    }


//------------------------------------------------------------------------------------------------------------
    //Pengelolaan peminjaman
    public function staff_peminjaman_kapel()
    {
       $peminjamans = PeminjamanKapel::with(['ruang', 'sesi','pjPeminjaman'])
        ->orderBy('id_peminjaman_kapel', 'desc')
        ->paginate(10);

    // Pisahkan peminjaman berdasarkan status
    $belumDivalidasi = $peminjamans->filter(function ($peminjaman) {
        return $peminjaman->status_pengajuan === 'proses'; // Status 'proses' berarti belum divalidasi
    });

    $sudahDivalidasi = $peminjamans->filter(function ($peminjaman) {
        return in_array($peminjaman->status_pengajuan, ['disetujui', 'ditolak']); // Status 'diterima' atau 'ditolak' berarti sudah divalidasi
    });


    return view('staff_peminjaman_kapel', [
        'key' => 'staff_peminjaman_kapel',
        'belumDivalidasi' => $belumDivalidasi,
        'sudahDivalidasi' => $sudahDivalidasi,
        'peminjamans' => $peminjamans
    ]);
    }

    public function form_validasi_peminjaman_kapel(PeminjamanKapel $peminjaman)
    {
        return view('form_validasi_peminjaman_kapel', [
            'key' => 'form_validasi_peminjaman_kapel',
            'peminjaman' => $peminjaman,
        ]);
    }

    public function save_validasi_peminjaman_kapel(Request $request, PeminjamanKapel $peminjaman)
{
    $request->validate([
        'status_pengajuan' => 'required|in:disetujui,ditolak',
        'catatan_persetujuan_kapel' => 'nullable|string|max:1000',
    ]);

    $peminjaman->update([
        'status_pengajuan' => $request->status_pengajuan,
        'catatan_persetujuan_kapel' => $request->catatan_persetujuan_kapel,
        'id_pj_peminjaman' =>  Auth::id(), // bisa juga pakai ->id atau ->email
        'tanggal_tervalidasi' => now(),

    ]);

    try {
        if ($peminjaman->status_pengajuan === 'disetujui') {
        Mail::to($peminjaman->email)->send(new SlipPeminjamanRuangDisetujui($peminjaman));
    } elseif ($peminjaman->status_pengajuan === 'ditolak') {
        Mail::to($peminjaman->email)->send(new SlipPeminjamanKapelDitolak($peminjaman));
    }
    return redirect('staff_peminjaman_kapel')->with('success', 'Validasi berhasil dan email terkirim.');

    } catch (\Exception $e) {
        Log::error('Gagal kirim email: ' . $e->getMessage());
        return redirect('staff_peminjaman_kapel')->with('error', 'Validasi berhasil, tapi email gagal dikirim.');
    }

    return redirect('staff_peminjaman_kapel')->with('success', 'Validasi peminjaman berhasil disimpan dan email terkirim.');
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Approval Peminjaman Perlengkapan 
public function staff_peminjaman_perlengkapan()
{
    $peminjamans = PeminjamanPkp::with(['perlengkapan', 'pjPeminjaman', 'sesi'])->orderBy('id_peminjaman_pkp', 'desc')->paginate(10);

    $belumDivalidasi = PeminjamanPkp::with(['sesi', 'perlengkapan'])
        ->where('status_pk', 'diproses')
        ->orderBy('id_peminjaman_pkp', 'desc')
        ->paginate(10, ['*'], 'belum');

    $sudahDivalidasi = PeminjamanPkp::with(['sesi', 'perlengkapan'])
        ->whereIn('status_pk', ['disetujui', 'ditolak'])
        ->orderBy('id_peminjaman_pkp', 'desc')
        ->paginate(10, ['*'], 'sudah');

    return view('staff_peminjaman_perlengkapan', compact('belumDivalidasi', 'sudahDivalidasi'));
}

public function form_validasi_peminjaman_perlengkapan(PeminjamanPkp $peminjaman)
{
    return view('form_validasi_peminjaman_perlengkapan', [
        'key' => 'form_validasi_peminjaman_perlengkapan',
        'peminjaman' => $peminjaman,
    ]);
}

public function save_validasi_peminjaman_perlengkapan(Request $request, PeminjamanPkp $peminjaman)
{
     $request->validate([
        'status_pk' => 'required|in:disetujui,ditolak,selesai',
        'catatan_persetujuan_pkp' => 'nullable|string|max:1000',
    ]);

    try {
        DB::beginTransaction();

        $peminjaman->update([
            'status_pk' => $request->status_pk,
            'catatan_persetujuan_pkp' => $request->catatan_persetujuan_pkp,
            'id_pj_peminjaman_pk' => Auth::id(),
             'tanggal_tervalidasi' => now(),

        ]);

        // Jika ditolak, kembalikan stok

if ($peminjaman->status_pk === 'disetujui') {
        Mail::to($peminjaman->email_pk)->send(new SlipPeminjamanPkpDisetujui($peminjaman));
    } elseif ($peminjaman->status_pk === 'ditolak') {
        Mail::to($peminjaman->email_pk)->send(new SlipPeminjamanPkpDitolak($peminjaman));
    }
 
    DB::commit(); // ✅ commit setelah semua proses berhasil

    return redirect('staff_peminjaman_perlengkapan')->with('success', 'Validasi berhasil dan email terkirim.');



        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error validasi peminjaman perlengkapan: ' . $e->getMessage());
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memproses.']);
        }
    }

////////////////////////////////////////////////PENGEMBALIAN PERLENGKAPAN???////

public function staff_pengembalian_pkp() {

        $belum_dikembalikan = SesiPkp::with('peminjaman')
        ->whereIn('status_pengembalian', ['belum', 'bermasalah'])
        ->whereHas('peminjaman', function($query) {
        $query->where('status_pk', 'disetujui');
    })
        ->where('status_sesi', '!=', 'batal') // Tambahkan kondisi untuk mengecualikan sesi yang dibatalkan
        ->get();


       $sudah_dikembalikan = SesiPkp::with('peminjaman')
        ->where('status_pengembalian', 'sudah')
        ->get();
        $dibatalkan = SesiPkp::where('status_sesi', 'batal')->get();

        
       //$dibatalkan = SesiPkp::where('status_sesi', 'batal')->get();

    return view('staff_pengembalian_pkp', compact('belum_dikembalikan', 'sudah_dikembalikan', 'dibatalkan'));
}

public function update_status_pengembalian_pkp(Request $request, $id_sesi_pkp)
{
    $request->validate([
        'status_pengembalian' => 'required|in:belum,sudah,bermasalah',
        //'id_pj_pengembalian' =>  Auth::id(),
        'catatan' => 'required_if:status_pengembalian,bermasalah|string|max:255',
    ]);

    $sesi = SesiPkp::findOrFail($id_sesi_pkp);
    $sesi->status_pengembalian = $request->status_pengembalian;
    $sesi->peminjaman->id_pj_pengembalian_pk = Auth::id();

    if ($request->status_pengembalian === 'sudah') {
        $sesi->tanggal_pengembalian_sesi = Carbon::now();
        $sesi->catatan = $request->catatan;
    } else {
        // status 'belum' atau lainnya
        $sesi->tanggal_pengembalian_sesi = null;
        $sesi->catatan = null;
    }

    $sesi->save();

    return redirect('/staff_pengembalian_pkp')->with('success', 'Status pengembalian berhasil diperbarui.');
}

public function form_pengembalian_pkp($id_sesi_pkp)
{
    $peminjaman = SesiPkp::with('peminjaman')->findOrFail($id_sesi_pkp);

    return view('form_pengembalian_pkp', compact('peminjaman'));
}

public function batalkan_sesi_pkp(Request $request, $id_sesi_pkp)
    {
        $sesi = SesiPkp::findOrFail($id_sesi_pkp);

        // Pastikan status sesi adalah 'aktif' agar bisa dibatalkan
        if ($sesi->status_sesi === 'batal') {
            return back()->with('error', 'Sesi ini sudah dibatalkan.');
        }

        // Validasi alasan pembatalan
        $request->validate([
            'alasan_dibatalkan' => 'required|string|max:1000',
        ]);
        Log::info('Alasan pembatalan diterima: ' . $request->input('alasan_dibatalkan'));

        DB::beginTransaction();

        try {
            // Ubah status sesi menjadi batal dan simpan alasan pembatalan
        $sesi->status_sesi = 'batal';
        $sesi->alasan_dibatalkan = $request->input('alasan_dibatalkan');
        $sesi->save();

        Log::info('Status sesi ID ' . $id_sesi_pkp . ' berhasil diperbarui menjadi batal.');

        // Kirim email konfirmasi pembatalan
        Mail::to($sesi->peminjaman->email_pk)->send(new KonfirmasiPembatalanSesiPkp($sesi));
        Log::info('Email konfirmasi pembatalan terkirim ke: ' . $sesi->peminjaman->email_pk);

        DB::commit();
        Log::info('Proses pembatalan sesi ID ' . $id_sesi_pkp . ' selesai dengan sukses.');

        return back()->with('success', 'Sesi berhasil dibatalkan dan email konfirmasi telah dikirim.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal membatalkan sesi ID ' . $id_sesi_pkp . ': ' . $e->getMessage());

        return back()->with('error', 'Gagal membatalkan sesi: ' . $e->getMessage());
    }
}





//-------------------------------------------------------------------------------------------------------------
public function staff_pengembalian_kapel() {

        $belum_dikembalikan = SesiKapel::with('peminjaman')
    ->whereIn('status_pengembalian_kp', ['belum', 'bermasalah'])
    ->whereHas('peminjaman', function($query) {
        $query->where('status_pengajuan', 'disetujui');
    })
        ->where('status_sesi', '!=', 'batal') // Tambahkan kondisi untuk mengecualikan sesi yang dibatalkan
        ->get();

        $sudah_dikembalikan = SesiKapel::with('peminjaman')
        ->where('status_pengembalian_kp', 'sudah')
        ->get();
        $dibatalkan = SesiKapel::where('status_sesi', 'batal')->get();


        return view('staff_pengembalian_kapel', compact('belum_dikembalikan', 'sudah_dikembalikan', 'dibatalkan'));
}

public function update_status_pengembalian_kapel(Request $request, $id_sesi_kapel)
{
     Log::info('STATUS: ' . $request->status_pengembalian_kp);
    Log::info('FULL REQUEST: ', $request->all());
    $request->validate([
        'status_pengembalian_kp' => 'required|in:belum,sudah,bermasalah',
        //'id_pj_pengembalian' =>  Auth::id(), // bisa juga pakai ->id atau ->email
        'catatan_kp' => 'required_if:status_pengembalian_kp,bermasalah|string|max:255',
    ]);

    $sesi = SesiKapel::findOrFail($id_sesi_kapel);
    $sesi->status_pengembalian_kp = $request->status_pengembalian_kp;
    $sesi->peminjaman->id_pj_pengembalian = Auth::id();

    if ($request->status_pengembalian_kp === 'sudah') {
        $sesi->tanggal_pengembalian_sesi_kp = Carbon::now();
        $sesi->catatan_kp = $request->catatan_kp;
    } else {
        // status 'belum' atau lainnya
    $sesi->tanggal_pengembalian_sesi_kp = null;
      $sesi->catatan_kp = null;
    }

    $sesi->save();

    return redirect('/staff_pengembalian_kapel')->with('success', 'Status pengembalian berhasil diperbarui.');
}

public function form_pengembalian_kapel($id_sesi_kapel)
{
    $peminjaman = SesiKapel::with('peminjaman')->findOrFail($id_sesi_kapel);

    return view('form_pengembalian_kapel', compact('peminjaman'));
}

public function batalkan_sesi_kapel(Request $request, $id_sesi_kapel)
    {
        $sesi = SesiKapel::findOrFail($id_sesi_kapel);

        // Pastikan status sesi adalah 'aktif' agar bisa dibatalkan
        if ($sesi->status_sesi === 'batal') {
            return back()->with('error', 'Sesi ini sudah dibatalkan.');
        }

        // Validasi alasan pembatalan
        $request->validate([
            'alasan_dibatalkan' => 'required|string|max:1000',
        ]);
        Log::info('Alasan pembatalan diterima: ' . $request->input('alasan_dibatalkan'));

        DB::beginTransaction();

        try {
            // Ubah status sesi menjadi batal dan simpan alasan pembatalan
        $sesi->status_sesi = 'batal';
        $sesi->alasan_dibatalkan = $request->input('alasan_dibatalkan');
        $sesi->save();

        Log::info('Status sesi ID ' . $id_sesi_kapel . ' berhasil diperbarui menjadi batal.');

        // Kirim email konfirmasi pembatalan
        Mail::to($sesi->peminjaman->email)->send(new KonfirmasiPembatalanSesiKapel($sesi));
        Log::info('Email konfirmasi pembatalan terkirim ke: ' . $sesi->peminjaman->email);

        DB::commit();
        Log::info('Proses pembatalan sesi ID ' . $id_sesi_kapel . ' selesai dengan sukses.');

        return back()->with('success', 'Sesi berhasil dibatalkan dan email konfirmasi telah dikirim.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Gagal membatalkan sesi ID ' . $id_sesi_kapel . ': ' . $e->getMessage());

        return back()->with('error', 'Gagal membatalkan sesi: ' . $e->getMessage());
    }
}






























}
