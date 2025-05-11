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
use App\PeminjamanRuang ; 
use App\PeminjamanPkp ; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Mail;
use App\Mail\SlipPeminjamanRuangDisetujui;
use App\Mail\SlipPeminjamanPerlengkapanDisetujui;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Tambahkan baris ini untuk mengimpor kelas DB


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

        return redirect('staff_daftar_kategori')->with('success', 'Data kategori berhasil ditambahkan.');
    }

    public function s_kategori_formedit($id_perlengkapan) { 
        $pkp = Perlengkapan::findOrFail($id_perlengkapan);

    // Pastikan $pkp->tanggal_beli_perlengkapan adalah objek Carbon
    if ($pkp->tanggal_beli_perlengkapan) {
        $pkp->tanggal_beli_perlengkapan = Carbon::parse($pkp->tanggal_beli_perlengkapan);
    }

    $kategori = Kategori::all();
    $ruang = Ruang::all();

    return view('staff.s_perlengkapan_formedit', [
        'key' => 'staff_daftar_perlengkapan',
        'pkp' => $pkp,
        'ruang' => $ruang,
        'kategori' => $kategori,
    ]);
    
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
        'jumlah_usulan_perbaikan' => 'required|integer|min:1',
        'alasan_perbaikan' => 'required|string|max:50',
        'estimasi_harga_perbaikan' => 'nullable|numeric|min:0',
        'tanggal_usulan_perbaikan' => 'required|date',
        'foto_perbaikan' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Foto sekarang opsional
        // 'tanggal_persetujuan_perbaikan' => 'nullable|date',
        // 'catatan_perbaikan_kaunit' => 'nullable|string|max:255',
    ]);

   // $prb->kode_perlengkapan = $request->kode_perlengkapan;
    $prb->jumlah_usulan_perbaikan = $request->jumlah_usulan_perbaikan;
    $prb->alasan_perbaikan = $request->alasan_perbaikan;
    $prb->estimasi_harga_perbaikan = $request->estimasi_harga_perbaikan;
    $prb->tanggal_usulan_perbaikan = $request->tanggal_usulan_perbaikan;
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

    public function delete_perbaikan($id_usulan_pengadaan){ 
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
    public function staff_peminjaman_ruang()
    {
        $peminjamans = PeminjamanRuang::with('ruang')->orderBy('id_peminjaman_ruang', 'desc')->paginate(10);
        return view('staff_peminjaman_ruang', [
            'key' => 'staff_peminjaman_ruang',
            'peminjamans' => $peminjamans
        ]);
    }

    public function form_validasi_peminjaman_ruang(PeminjamanRuang $peminjaman)
    {
        return view('form_validasi_peminjaman_ruang', [
            'key' => 'form_validasi_peminjaman_ruang',
            'peminjaman' => $peminjaman,
        ]);
    }

    public function save_validasi_peminjaman_ruang(Request $request, PeminjamanRuang $peminjaman)
{
    $request->validate([
        'status' => 'required|in:disetujui,ditolak,selesai',
        'catatan_staff' => 'nullable|string|max:1000',
    ]);

    if ($request->status === 'disetujui') {
        $bentrokan = PeminjamanRuang::overlapping(
            $peminjaman->id_ruang,
            $peminjaman->tanggal_mulai,
            $peminjaman->tanggal_selesai,
            $peminjaman->id_peminjaman_ruang // Exclude peminjaman saat ini
        )->where('status', 'disetujui')->exists(); // Cari semua peminjaman yang sudah disetujui

        if ($bentrokan) {
            return redirect()->back()->withErrors(['bentrokan' => 'Peringatan! Peminjaman ini memiliki bentrokan jadwal dengan peminjaman lain yang sudah disetujui. Harap periksa kembali.']);
        }
    }

    $peminjaman->update([
        'status' => $request->status,
        'catatan_staff' => $request->catatan_staff,
        'id_pj_peminjaman' =>  Auth::id(), // bisa juga pakai ->id atau ->email
    ]);

    try {
        Mail::to($peminjaman->email)->send(new SlipPeminjamanRuangDisetujui($peminjaman));
    } catch (\Exception $e) {
        Log::error('Gagal kirim email: ' . $e->getMessage());
        return redirect('staff_peminjaman_ruang')->with('error', 'Validasi berhasil, tapi email gagal dikirim.');
    }

    return redirect('staff_peminjaman_ruang')->with('success', 'Validasi peminjaman berhasil disimpan dan email terkirim.');
}


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Approval Peminjaman Perlengkapan 
public function staff_peminjaman_perlengkapan()
{
      $peminjamans = PeminjamanPkp::with('perlengkapan')->orderBy('id_peminjaman_pkp', 'desc')->paginate(10);

    return view('staff_peminjaman_perlengkapan', [
        'key' => 'staff_peminjaman_perlengkapan',
        'peminjamans' => $peminjamans
    ]);
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
        'catatan_staff' => 'nullable|string|max:1000',
    ]);

    try {
        DB::beginTransaction();

        $peminjaman->update([
            'status_pk' => $request->status_pk,
            'catatan_peminjaman_pk' => $request->catatan_peminjaman_pk,
            'id_pj_pengembalian_pk' => Auth::id(),
            'status_gladi_pk' => $peminjaman->butuh_gladi_pk
                ? ($request->status_pk === 'disetujui' ? 'belum' : 'ditolak')
                : 'tidak_ada_gladi',
        ]);

        // Jika ditolak, kembalikan stok
        if ($request->status_pk === 'ditolak') {
            foreach ($peminjaman->perlengkapan as $item) {
                $item->stok_perlengkapan += 1;
                $item->save();
            }
        }

        DB::commit();

        try {
            Mail::to($peminjaman->email_pk)->send(new SlipPeminjamanPerlengkapanDisetujui($peminjaman));
        } catch (\Exception $e) {
            Log::error('Gagal kirim email: ' . $e->getMessage());
            return redirect('staff_peminjaman_perlengkapan')->with('error', 'Validasi berhasil, tapi email gagal dikirim.');
        }

        return redirect('staff_peminjaman_perlengkapan')->with('success', 'Validasi berhasil dan email terkirim.');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error validasi peminjaman perlengkapan: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat memproses.']);
    }
}

public function staff_pengembalian_ruang()
{
    $ruangBelum = PeminjamanRuang::with('ruang')
        ->where('status', 'disetujui')
        ->whereNull('tanggal_pengembalian')
        ->get()
        ->map(function ($item) {
            $item->jenis = 'peminjaman';
            $item->status_pengembalian = 'Belum Dikembalikan';
            return $item;
        });

    // Belum dikembalikan - Gladi
    $gladiBelum = PeminjamanRuang::with('ruang')
        ->where('butuh_gladi', true)
        ->where('status_gladi', 'belum')
        ->whereNull('pengembalian_gladi_aktual')
        ->get()
        ->map(function ($item) {
            $item->jenis = 'gladi';
            $item->status_pengembalian = 'Belum Dikembalikan';
            return $item;
        });

    // Sudah dikembalikan - Ruang
    $ruangSelesai = PeminjamanRuang::with('ruang', 'pjPengembalian')
        ->whereNotNull('tanggal_pengembalian')
        ->get()
        ->map(function ($item) {
            $item->jenis = 'peminjaman';
            $item->status_pengembalian = 'Dikembalikan';
            return $item;
        });

    // Sudah dikembalikan - Gladi
    $gladiSelesai = PeminjamanRuang::with('ruang', 'pjPengembalian')
        ->where('butuh_gladi', true)
        ->where('status_gladi', 'selesai')
        ->whereNotNull('pengembalian_gladi_aktual')
        ->get()
        ->map(function ($item) {
            $item->jenis = 'gladi';
            $item->status_pengembalian = 'Dikembalikan';
            return $item;
        });

    return view('staff_pengembalian_ruang', [
        'belum_dikembalikan' => $ruangBelum->merge($gladiBelum),
        'sudah_dikembalikan' => $ruangSelesai->merge($gladiSelesai),
         'key' => 'pengembalian'
    ]);
}

public function form_pengembalian_ruang(PeminjamanRuang $peminjaman)
{
    return view('form_pengembalian_ruang', [
        'key' => 'form_pengembalian_ruang',
        'peminjaman' => $peminjaman,
    ]);
}

public function form_pengembalian_gladi(PeminjamanRuang $peminjaman)
{
    return view('form_pengembalian_gladi', [
        'key' => 'form_pengembalian_gladi',
        'peminjaman' => $peminjaman,
    ]);
}

public function save_pengembalian_ruang(Request $request, PeminjamanRuang $peminjaman)
{
    $request->validate([
        'tanggal_pengembalian' => 'required|date',
        'catatan_pengembalian' => 'nullable|string|max:1000',
    ]);

    $peminjaman->update([
        'tanggal_pengembalian' => $request->tanggal_pengembalian,
        'catatan_pengembalian' => $request->catatan_pengembalian,
        'status' => 'selesai',
        'id_pj_pengembalian' =>  Auth::id(), // bisa juga pakai ->id atau ->email
    ]);

    return redirect('staff_pengembalian_ruang')->with('success', 'Pengembalian ruang berhasil dicatat.');
}

public function save_pengembalian_gladi(Request $request, $id_peminjaman_ruang)
{
    $request->validate([
        'pengembalian_gladi_aktual' => 'required|date',
    ]);

    $peminjaman = PeminjamanRuang::findOrFail($id_peminjaman_ruang);
    $peminjaman->pengembalian_gladi_aktual = $request->pengembalian_gladi_aktual;
    $peminjaman->status_gladi = 'selesai';
    $peminjaman->id_pj_pengembalian = Auth::id();
    
    $peminjaman->save();

    return redirect('staff_pengembalian_ruang')->with('success', 'Pengembalian gladi berhasil disimpan.');
}


    

}
