<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeminjamanRuang ; 
use App\Ruang; 
use App\Perlengkapan; 
use App\PeminjamanPerlengkapan;

class peminjamController extends Controller
{
    public function peminjam_beranda() { 
        return view('peminjam_beranda',['key'=>'peminjam_beranda']);
    }

    public function peminjaman_ruang()
    {
        $ruang = Ruang::all();
        $peminjamanDisetujui = PeminjamanRuang::where('status', 'disetujui')->get();
    
        $jadwal = [];
    
        foreach ($peminjamanDisetujui as $p) {
            $jadwal[] = [
                'nama_kegiatan' => $p->nama_kegiatan,
                'tanggal' => $p->tanggal_mulai,
                'waktu_selesai' => $p->tanggal_selesai,
                'jenis' => 'Pelaksanaan',
                'ruang' => $p->ruang->nama_ruang,
            ];
    
            if ($p->butuh_gladi && $p->tanggal_gladi && $p->tanggal_pengembalian_gladi) {
                $jadwal[] = [
                    'nama_kegiatan' => $p->nama_kegiatan . ' (Gladi)',
                    'tanggal' => $p->tanggal_gladi,
                    'waktu_selesai' => $p->tanggal_pengembalian_gladi,
                    'jenis' => 'Gladi',
                    'ruang' => $p->ruang->nama_ruang,
                ];
            }
        }
    
        usort($jadwal, fn($a, $b) => strtotime($a['tanggal']) - strtotime($b['tanggal']));
    
        return view('peminjaman_ruang', compact('ruang', 'jadwal'));
    }
    public function peminjaman_ruang_formadd($id_ruang)
    {
        $ruang = Ruang::findOrFail($id_ruang);
        return view('peminjaman_ruang_formadd', compact('ruang'));
    }

    public function save_peminjaman_ruang(Request $request)
    {
        $validated = $request->validate([
            'nomor_induk' => 'required|string|max:50',
            'nama_peminjam' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'email' => 'required|email',
            'nama_kegiatan' => 'required|string|max:100',
            'keterangan_kegiatan' => 'nullable|string',
            'id_ruang' => 'required|exists:ruang,id_ruang',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jumlah_kursi_tetap' => 'nullable|integer|min:0',
            'jumlah_kursi_tambahan' => 'nullable|integer|min:0',
            'butuh_gladi' => 'boolean',
            'tanggal_gladi' => 'nullable|date',
            'tanggal_pengembalian_gladi' => 'nullable|date',
            'butuh_livestream' => 'boolean',
            'butuh_operator' => 'boolean',
            'operator_sound' => 'nullable|string',
            'operator_live' => 'nullable|string',
            'status' => 'nullable|string',
            'surat_peminjaman' => 'nullable|file|mimes:pdf,doc,docx|max:2048', // <--- validasi file
        ]);

        if ($request->butuh_gladi) {
            if (!$request->tanggal_gladi || !$request->tanggal_pengembalian_gladi) {
                return back()->withErrors([
                    'tanggal_gladi' => 'Tanggal gladi dan selesai gladi wajib diisi jika butuh gladi.'
                ])->withInput();
            }
    
            if ($request->tanggal_pengembalian_gladi < $request->tanggal_gladi) {
                return back()->withErrors([
                    'tanggal_pengembalian_gladi' => 'Tanggal selesai gladi harus setelah tanggal mulai gladi.'
                ])->withInput();
            }
        }
    
        $validated['status_gladi'] = $request->butuh_gladi ? 'belum' : 'tidak_ada_gladi';
        $validated['status'] = 'diproses';

        if ($request->hasFile('surat_peminjaman')) {
            $file = $request->file('surat_peminjaman');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_peminjaman', $filename);
    
            $validated['surat_peminjaman'] = $filename;
        }
    
        PeminjamanRuang::create($validated);
    
        return redirect('/peminjaman_ruang')->with('success', 'Peminjaman berhasil diajukan.');
    }

    public function detail_peminjaman_ruang($id_ruang)
    {
        $ruang = Ruang::all();

        $peminjamanDisetujui = PeminjamanRuang::where('status', 'disetujui')->get();
    
        $jadwal = [];
    
        foreach ($peminjamanDisetujui as $p) {
            // Tambah kegiatan utama
            $jadwal[] = [
                'nama_kegiatan' => $p->nama_kegiatan,
                'tanggal' => $p->tanggal_mulai,
                'waktu_selesai' => $p->tanggal_selesai,
                'jenis' => 'Pelaksanaan',
                'ruang' => $p->ruang->nama_ruang,
            ];
    
            // Tambah gladi jika ada
            if ($p->butuh_gladi && $p->tanggal_gladi && $p->tanggal_pengembalian_gladi) {
                $jadwal[] = [
                    'nama_kegiatan' => $p->nama_kegiatan . ' (Gladi)',
                    'tanggal' => $p->tanggal_gladi,
                    'waktu_selesai' => $p->tanggal_pengembalian_gladi,
                    'jenis' => 'Gladi',
                    'ruang' => $p->ruang->nama_ruang,
                ];
            }
        }
    
        // Urutkan
        usort($jadwal, fn($a, $b) => strtotime($a['tanggal']) - strtotime($b['tanggal']));
    
        return view('peminjaman_ruang', compact('ruang', 'jadwal'));
    }



    public function peminjam_daftar_riwayat_peminjaman() { 
        return view('peminjam_daftar_riwayat_peminjaman',['key'=>'peminjam_daftar_riwayat_peminjaman']);
    }
}
