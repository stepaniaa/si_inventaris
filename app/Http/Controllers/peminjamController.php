<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Peminjaman ; 
use App\Ruang; 
use App\Perlengkapan; 
use App\PeminjamanPerlengkapan;

class peminjamController extends Controller
{
    public function peminjam_beranda() { 
        return view('peminjam_beranda',['key'=>'peminjam_beranda']);
    }


    public function peminjaman_ruang() {
        $ruangs = Ruang::all();
        $terbooking = [];
        $bulanIni = now()->month;
    
        foreach ($ruangs as $ruang) {
            $terbooking[$ruang->id_ruang] = Peminjaman::where('id_ruang', $ruang->id_ruang)
                ->whereMonth('tanggal_mulai', $bulanIni)
                ->where('status_peminjaman', 'diterima') // Tambahkan kondisi ini
                ->pluck('tanggal_mulai')
                ->toArray();
        }
    
        return view('peminjaman_ruang', ['key'=>'peminjaman_ruang'], compact('ruangs', 'terbooking'));
    }
    
    public function peminjaman_ruang_formadd($id_ruang = null) {
        $ruangs = Ruang::all(); // Atau cara lain Anda mengambil daftar ruang
        $selectedRuang = null;

        if ($id_ruang) {
            $selectedRuang = Ruang::findOrFail($id_ruang);
        }

        return view('peminjaman_ruang_formadd', [
            'key' => 'peminjaman_ruang_formadd',
            'ruangs' => $ruangs,
            'selectedRuang' => $selectedRuang,
        ]);
    }

    public function save_peminjaman_ruang(Request $request)
    {
        $request->validate([
            'nomor_induk' => 'required|string|max:20',
            'nama_peminjam' => 'required|string|max:50',
            'email' => 'nullable|email|max:50',
            'nomor_telpon' => 'required|string|max:20',
            'status_peminjam' => 'required|in:mahasiswa,dosen,staff',
            'asal_unit' => 'required|string|max:100',
            'nama_kegiatan' => 'required|string|max:100',
            'kegunaan_peminjaman' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'pukul_mulai' => 'required|date_format:H:i',
            'pukul_selesai' => 'required|date_format:H:i|after:pukul_mulai',
            'surat_peminjaman' => 'required|file|mimes:pdf|max:2048',
            'id_ruang' => 'nullable|exists:ruang,id_ruang', // Pastikan nama tabel ruang sesuai
        ]);

        // Upload file surat peminjaman
        if ($request->hasFile('surat_peminjaman')) {
            $suratPath = $request->file('surat_peminjaman')->store('public/surat_peminjaman');
            $namaFileSurat = basename($suratPath);
        } else {
            $namaFileSurat = null;
        }

        Peminjaman::create([
            'nomor_induk' => $request->nomor_induk,
            'nama_peminjam' => $request->nama_peminjam,
            'email' => $request->email,
            'nomor_telpon' => $request->nomor_telpon,
            'status_peminjam' => $request->status_peminjam,
            'asal_unit' => $request->asal_unit,
            'nama_kegiatan' => $request->nama_kegiatan,
            'kegunaan_peminjaman' => $request->kegunaan_peminjaman,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'pukul_mulai' => $request->pukul_mulai,
            'pukul_selesai' => $request->pukul_selesai,
            'surat_peminjaman' => $namaFileSurat,
            'status_peminjaman' => 'diproses', // Default status saat membuat peminjaman
            'id_ruang' => $request->id_ruang, // Jika ada pemilihan ruang
        ]);

        return redirect('peminjaman_ruang')->with('success_popup', 'Terima kasih! Pengajuan Anda akan segera diproses. Silahkan periksa email Anda secara berkala.');
    }

    // Peminjaman Perlengkapan 
    public function peminjaman_perlengkapan()
    {
        // Ambil peminjaman perlengkapan yang statusnya 'diterima', kelompokkan berdasarkan ID perlengkapan.
        $peminjamanPerlengkapan = PeminjamanPerlengkapan::with('peminjaman', 'perlengkapan')
            ->whereHas('peminjaman', function ($q) {
                $q->where('status_peminjaman', 'diterima');
            })
            ->get()
            ->groupBy('id_perlengkapan')
            ->map(function ($items) {
                $tanggalPeminjaman = [];
                foreach ($items as $item) {
                    // Pastikan tanggal_mulai ada dan bukan null
                    if ($item->peminjaman && $item->peminjaman->tanggal_mulai) {
                        $tanggalPeminjaman[] = date('Y-m-d', strtotime($item->peminjaman->tanggal_mulai));
                    }
                }
                return $tanggalPeminjaman; // Mengembalikan array tanggal
            });

        // Ambil peminjaman ruangan yang terjadi di bulan ini.
        $ruanganTerbooking = Peminjaman::where('tanggal_mulai', '>=', now()->startOfMonth())
            ->where('tanggal_mulai', '<=', now()->endOfMonth())
            ->whereNotNull('id_ruang')
            ->get()
            ->groupBy('id_ruang')
            ->map(function ($items) {
                $tanggalPeminjamanRuangan = [];
                foreach ($items as $item) {
                    if ($item->tanggal_mulai) {
                        $tanggalPeminjamanRuangan[] = [
                            'tanggal_mulai' => date('Y-m-d', strtotime($item->tanggal_mulai)),
                            'id_ruang' => $item->id_ruang, // Tambahkan id_ruang
                        ];
                    }
                }
                return $tanggalPeminjamanRuangan;
            });

        // Ambil semua data perlengkapan.
        $perlengkapan = Perlengkapan::all();

        // Inisialisasi variabel $terbooking sebagai array kosong.
        $terbooking = [];

        // Gabungkan data peminjaman perlengkapan.
        foreach ($peminjamanPerlengkapan as $perlengkapanId => $tanggalPeminjaman) {
            $terbooking[$perlengkapanId] = $tanggalPeminjaman;
        }

        // Iterasi melalui peminjaman ruangan untuk mendapatkan perlengkapan yang terbooking.
        foreach ($ruanganTerbooking as $ruangId => $peminjamanRuangan) {
            // Dapatkan perlengkapan yang dipinjam untuk ruang ini pada tanggal-tanggal tersebut.
            $tanggalRuangan = array_column($peminjamanRuangan, 'tanggal_mulai');

            // Debug: Periksa nilai variabel
            // dd($ruangId, $tanggalRuangan);

            $perlengkapanTerpakai = PeminjamanPerlengkapan::whereHas('peminjaman', function ($query) use ($tanggalRuangan, $ruangId) {
                $query->where('id_ruang', $ruangId);
                $query->whereIn('tanggal_mulai', $tanggalRuangan);
            })->pluck('id_perlengkapan')->toArray();

            // Jika ada perlengkapan yang terpakai, tambahkan ke array $terbooking.
            if (!empty($perlengkapanTerpakai)) {
                foreach ($perlengkapanTerpakai as $perlengkapanId) {
                    // Pastikan key untuk perlengkapanId ada di array $terbooking
                    if (!array_key_exists($perlengkapanId, $terbooking)) {
                        $terbooking[$perlengkapanId] = [];
                    }
                    // Tambahkan tanggal peminjaman ruangan.
                    foreach ($peminjamanRuangan as $ruangan) {
                        if (!in_array($ruangan['tanggal_mulai'], $terbooking[$perlengkapanId])) {
                            $terbooking[$perlengkapanId][] = $ruangan['tanggal_mulai'];
                        }
                    }
                }
            }
        }

        // Debug: Tampilkan isi array $terbooking sebelum di kirim ke view
        // dd($terbooking);

        // Return data yang diperlukan.
        return view('peminjaman_perlengkapan', [
            'perlengkapan' => $perlengkapan,
            'terbooking' => $terbooking,
        ]);
    }
    
    
    
    


    public function peminjam_daftar_riwayat_peminjaman() { 
        return view('peminjam_daftar_riwayat_peminjaman',['key'=>'peminjam_daftar_riwayat_peminjaman']);
    }
}
