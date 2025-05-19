<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ruang; 
use App\Perlengkapan; 
use App\PeminjamanPkp;
use App\SesiPkp;
use App\PeminjamanKapel;
use App\SesiKapel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import kelas Log
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator; // Tambahkan baris ini

class peminjamController extends Controller
{
    public function peminjam_beranda() { 
        return view('peminjam_beranda',['key'=>'peminjam_beranda']);
    }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function peminjaman_kapel() {
    Log::info('Akses halaman peminjaman ruang.');
    $kapel = Ruang::all();
    $peminjamanDisetujui = PeminjamanKapel::where('status_pengajuan', 'disetujui')
        ->whereHas('sesi', function ($query) {
            $query->where('status_pengembalian_kp', '=', 'belum');
        })
        ->get();

    $jadwal = [];

    foreach ($peminjamanDisetujui as $peminjaman) {
            if ($peminjaman->ruang) {
                foreach ($peminjaman->sesi as $sesi) {
                    $jadwal[] = [
                        'nama_kegiatan' => $peminjaman->nama_kegiatan,
                        'tanggal' => Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s'),
                        'waktu_selesai' => Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s'),
                        'kapel' => $peminjaman->ruang->nama_ruang,
                    ];
                }
            }
        }

    // Urutkan jadwal berdasarkan tanggal mulai
    if (is_array($jadwal) && count($jadwal) > 1) {
        usort($jadwal, fn ($a, $b) => strtotime($a['tanggal']) - strtotime($b['tanggal']));
    }

    // Kirim data ke view
    return view('peminjaman_kapel', compact('kapel','jadwal'));
    }

    public function peminjaman_kapel_formadd($id_ruang)
    {
        $kapel = Ruang::findOrFail($id_ruang);
        return view('peminjaman_kapel_formadd', compact('kapel'));
    }

    public function save_peminjaman_kapel(Request $request)
    {
        \Log::info('Mulai proses penyimpanan peminjaman ruang dengan data: ' . json_encode($request->all()));
        
        $validator = Validator::make($request->all(), [
            'nomor_induk' => 'required|string|max:50',
            'nama_peminjam' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'asal_unit' => 'nullable|string|max:100',
            'peran' => 'nullable|string|max:50',
            'email' => 'required|email',
            'nama_kegiatan' => 'required|string|max:150',
            'keterangan_kegiatan' => 'nullable|string',
            'id_ruang' => 'required|exists:ruang,id_ruang',
            //'tanggal_mulai' => 'required|date',
            //'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'butuh_livestream' => 'nullable|boolean',
            'butuh_operator' => 'nullable|boolean',
            'operator_sound' => 'nullable|string|max:100',
            'operator_live' => 'nullable|string|max:100',
            'rutin' => 'nullable|boolean',
            'tipe_rutin' => 'required_if:rutin,1|in:mingguan,bulanan',
            'jumlah_perulangan' => 'required_if:rutin,1|integer|min:1',
            'tanggal_sesi_awal.mulai' => 'required|date',
            'tanggal_sesi_awal.selesai' => 'required|date|after_or_equal:tanggal_sesi_awal.mulai',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();
        try {
        $filename = null;
        if ($request->hasFile('surat_peminjaman')) {
            $file = $request->file('surat_peminjaman');
            \Log::info('File surat peminjaman ditemukan, nama file: ' . $file->getClientOriginalName());
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_peminjaman', $filename);
            \Log::info('File surat peminjaman berhasil disimpan dengan nama: ' . $filename);
        } else {
            \Log::info('Tidak ada file surat peminjaman yang diupload.');
        }
            $isRutin = $request->boolean('rutin', false);
            $jumlahPerulangan = $isRutin ? $request->jumlah_perulangan : 1; 
            $tipeRutin = $isRutin ? $request->tipe_rutin : null; 

            $start = Carbon::parse($request->input('tanggal_sesi_awal.mulai'));
            $end = Carbon::parse($request->input('tanggal_sesi_awal.selesai'));


            //Cek bentrok
            for ($i = 0; $i < $jumlahPerulangan; $i++) {
            $overlap = SesiKapel::whereHas('peminjaman', function($q) use ($request) {
                $q->where('id_ruang', $request->id_ruang)
                  ->where('status_pengajuan', 'disetujui'); // hanya peminjaman disetujui
            })
            ->whereIn('status_pengembalian_kp', ['belum', 'bermasalah'])
            ->where(function($q) use ($start, $end) {
                $q->whereBetween('tanggal_mulai_sesi', [$start, $end])
                  ->orWhereBetween('tanggal_selesai_sesi', [$start, $end])
                  ->orWhere(function($q2) use ($start, $end) {
                      $q2->where('tanggal_mulai_sesi', '<=', $start)
                         ->where('tanggal_selesai_sesi', '>=', $end);
                  });
            })->exists();

            if ($overlap) {
                return back()
                    ->withErrors(['error' => 'Jadwal bentrok: Kapel sudah digunakan pada waktu ini. Mohon cek jadwal yang tersedia.'])
                    ->withInput();
            }

            // Tambahan: geser tanggal sesi berikutnya jika rutin
            if ($isRutin) {
                if ($tipeRutin === 'mingguan') {
                    $start->addWeek();
                    $end->addWeek();
                } elseif ($tipeRutin === 'bulanan') {
                    $start->addMonth();
                    $end->addMonth();
                }
            }
        }


            $peminjaman = PeminjamanKapel::create([
                'nomor_induk' => $request->nomor_induk,
                'nama_peminjam' => $request->nama_peminjam,
                'kontak' => $request->kontak,
                'asal_unit' => $request->asal_unit,
                'peran' => $request->peran,
                'email' => $request->email,
                'nama_kegiatan' => $request->nama_kegiatan,
                'keterangan_kegiatan' => $request->keterangan_kegiatan,
                'id_ruang' => $request->id_ruang,
                'butuh_livestream' => $request->butuh_livestream ?? false,
                'butuh_operator' => $request->butuh_operator ?? false,
                'operator_sound' => $request->operator_sound,
                'operator_live' => $request->operator_live,
                //'tanggal_mulai' => Carbon::parse($request->tanggal_mulai)->format('Y-m-d H:i:s'),
                //'tanggal_selesai' => Carbon::parse($request->tanggal_selesai)->format('Y-m-d H:i:s'),
                'status_pengajuan' => 'proses',
                'rutin' => $isRutin,
                'tipe_rutin' => $isRutin ? $request->tipe_rutin : null,
                'jumlah_perulangan' => $isRutin ? $request->jumlah_perulangan : null,
            ]);

            // Buat sesi rutin dengan tipe datetime untuk tanggal mulai dan selesai sesi
            if ($isRutin) {
                $start = Carbon::parse($request->input('tanggal_sesi_awal.mulai'));
                $end = Carbon::parse($request->input('tanggal_sesi_awal.selesai'));

                for ($i = 0; $i < $request->jumlah_perulangan; $i++) {
                    $peminjaman->sesi()->create([
                        'tanggal_mulai_sesi' => $start->format('Y-m-d H:i:s'),
                        'tanggal_selesai_sesi' => $end->format('Y-m-d H:i:s'),
                    ]);

                    if ($request->tipe_rutin === 'mingguan') {
                        $start->addWeek();
                        $end->addWeek();
                    } else if ($request->tipe_rutin === 'bulanan') {
                        $start->addMonth();
                        $end->addMonth();
                    }
                }
            } else {
            // satu sesi saja untuk peminjaman non-rutin
            $peminjaman->sesi()->create([
                'tanggal_mulai_sesi' => $start->format('Y-m-d H:i:s'),
                'tanggal_selesai_sesi' => $end->format('Y-m-d H:i:s'),
            ]);
        }


            DB::commit();

            return redirect('peminjaman_kapel')->with('success', 'Sukses! Detail pengajuan dan info persetujuan segera dikirim melalui email Anda.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan peminjaman ruang: ' . $e->getMessage()])->withInput();
        }
    }
    























    //-----------------------------------------------------------------------------------------------------]
    //Peminjaman Perlengkapan 
    public function peminjaman_perlengkapan() {
    $perlengkapan = Perlengkapan::where('status_perlengkapan', 'aktif')->get();

    // Tambahkan status saat ini ke setiap perlengkapan

    // Ambil semua peminjaman yang disetujui
    

    // Inisialisasi variabel jadwal dan peminjamanPerKelompok sebagai array koson

    // Urutkan jadwal berdasarkan tanggal mulai

    // Kirim data ke view
    return view('peminjaman_perlengkapan', compact('perlengkapan'));
}

    public function peminjaman_perlengkapan_formadd()
    {
        $ids = session('id_perlengkapan_dipilih', []);
        $perlengkapan = Perlengkapan::whereIn('id_perlengkapan', $ids)->get();
        if ($perlengkapan->isEmpty()) {
            return redirect('/peminjaman_perlengkapan')->withErrors('Anda belum memilih perlengkapan untuk dipinjam.');
        }
        return view('peminjaman_perlengkapan_formadd', compact('perlengkapan'));
    } 

    public function save_peminjaman_perlengkapan(Request $request)
{
    \Log::info('Mulai proses penyimpanan peminjaman dengan data: ' . json_encode($request->all()));

    $validator = Validator::make($request->all(), [
        'nomor_induk_pk' => 'required|string|max:50',
        'nama_peminjam_pk' => 'required|string|max:100',
        'kontak_pk' => 'required|string|max:20',
        'email_pk' => 'required|email',
        'nama_kegiatan_pk' => 'required|string|max:100',
        'keterangan_kegiatan_pk' => 'nullable|string',
        'id_perlengkapan' => 'required|array',
        'id_perlengkapan.*' => 'exists:perlengkapan,id_perlengkapan',
        'butuh_livestream_pk' => 'nullable|boolean',
        'butuh_operator_pk' => 'nullable|boolean',
        'surat_peminjaman_pk' => 'nullable|file|mimes:pdf|max:2048',
        'rutin' => 'nullable|boolean',
        'tipe_rutin' => 'required_if:rutin,1|in:mingguan,bulanan',
        'jumlah_perulangan' => 'required_if:rutin,1|integer|min:1',
        'tanggal_sesi_awal.mulai' => 'required|date',
        'tanggal_sesi_awal.selesai' => 'required|date|after_or_equal:tanggal_sesi_awal.mulai',
    ]);

    if ($validator->fails()) {
        \Log::error('Validasi gagal: ' . json_encode($validator->errors()->all()));
        return redirect()->back()->withErrors($validator)->withInput();
    }

    DB::beginTransaction();
    try {
        // Parsing tanggal mulai dan selesai sebelum digunakan
        $tanggalMulaiAwal = Carbon::parse($request->input('tanggal_sesi_awal.mulai'));
        $tanggalSelesaiAwal = Carbon::parse($request->input('tanggal_sesi_awal.selesai'));

        $filename = null;
        if ($request->hasFile('surat_peminjaman_pk')) {
            $file = $request->file('surat_peminjaman_pk');
            \Log::info('File surat peminjaman ditemukan, nama file: ' . $file->getClientOriginalName());
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_peminjaman_perlengkapan', $filename);
            \Log::info('File surat peminjaman berhasil disimpan dengan nama: ' . $filename);
        } else {
            \Log::info('Tidak ada file surat peminjaman yang diupload.');
        }

        $isRutin = $request->boolean('rutin', false);
        $jumlahPerulangan = $isRutin ? (int)$request->jumlah_perulangan : 1;
        $tipeRutin = $isRutin ? $request->tipe_rutin : null;
        $idPerlengkapanDipilih = $request->input('id_perlengkapan');

        // Buat peminjaman terlebih dahulu
        $peminjaman = PeminjamanPkp::create([
            'nomor_induk_pk' => $request->nomor_induk_pk,
            'nama_peminjam_pk' => $request->nama_peminjam_pk,
            'kontak_pk' => $request->kontak_pk,
            'email_pk' => $request->email_pk,
            'nama_kegiatan_pk' => $request->nama_kegiatan_pk,
            'keterangan_kegiatan_pk' => $request->keterangan_kegiatan_pk,
            'butuh_livestream_pk' => $request->butuh_livestream_pk ?? false,
            'butuh_operator_pk' => $request->butuh_operator_pk ?? false,
            'surat_peminjaman_pk' => $filename,
            'status_pk' => 'diproses',
            'rutin' => $isRutin,
            'tipe_rutin' => $tipeRutin,
            'jumlah_perulangan' => $isRutin ? $jumlahPerulangan : null,
        ]);

        // Attach perlengkapan many-to-many
        $peminjaman->perlengkapan()->attach($idPerlengkapanDipilih);

        for ($i = 0; $i < $jumlahPerulangan; $i++) {
            // Hitung tanggal sesi berdasarkan tipe rutin
            if ($isRutin) {
                if ($tipeRutin === 'mingguan') {
                    $tanggalMulaiSesi = $tanggalMulaiAwal->copy()->addWeeks($i);
                    $tanggalSelesaiSesi = $tanggalSelesaiAwal->copy()->addWeeks($i);
                } elseif ($tipeRutin === 'bulanan') {
                    $tanggalMulaiSesi = $tanggalMulaiAwal->copy()->addMonths($i);
                    $tanggalSelesaiSesi = $tanggalSelesaiAwal->copy()->addMonths($i);
                } else {
                    // fallback jika tipe rutin tidak sesuai
                    $tanggalMulaiSesi = $tanggalMulaiAwal->copy();
                    $tanggalSelesaiSesi = $tanggalSelesaiAwal->copy();
                }
            } else {
                $tanggalMulaiSesi = $tanggalMulaiAwal->copy();
                $tanggalSelesaiSesi = $tanggalSelesaiAwal->copy();
            }

            // Cek bentrok untuk setiap perlengkapan di sesi ini
            foreach ($idPerlengkapanDipilih as $idPerlengkapan) {
                $overlap = SesiPkp::whereHas('peminjaman', function ($q) use ($idPerlengkapan) {
                    $q->whereHas('perlengkapan', function ($q2) use ($idPerlengkapan) {
                        $q2->where('perlengkapan.id_perlengkapan', $idPerlengkapan);
                    });
                    $q->where('status_pk', 'disetujui');
                })
                ->where('status_pengembalian', 'belum')
                ->where(function ($q) use ($tanggalMulaiSesi, $tanggalSelesaiSesi) {
                    $q->whereBetween('tanggal_mulai_sesi', [$tanggalMulaiSesi, $tanggalSelesaiSesi])
                      ->orWhereBetween('tanggal_selesai_sesi', [$tanggalMulaiSesi, $tanggalSelesaiSesi])
                      ->orWhere(function ($q2) use ($tanggalMulaiSesi, $tanggalSelesaiSesi) {
                          $q2->where('tanggal_mulai_sesi', '<=', $tanggalMulaiSesi)
                             ->where('tanggal_selesai_sesi', '>=', $tanggalSelesaiSesi);
                      });
                })
                ->exists();

                if ($overlap) {
                    DB::rollback();
                    return back()->withErrors(['error' => "Perlengkapan dengan ID {$idPerlengkapan} tidak tersedia pada tanggal yang Anda inginkan. Mohon cek jadwal agar tidak bentrok."])->withInput();
                }
            }

            // Simpan sesi peminjaman
            $peminjaman->sesi()->create([
                'tanggal_mulai_sesi' => $tanggalMulaiSesi,
                'tanggal_selesai_sesi' => $tanggalSelesaiSesi,
                'status_pengembalian' => 'belum',
            ]);

            \Log::info('Sesi peminjaman berhasil dibuat untuk tanggal ' . $tanggalMulaiSesi->toDateTimeString() . ' sampai ' . $tanggalSelesaiSesi->toDateTimeString());
        }

        DB::commit();
        \Log::info('Peminjaman berhasil disimpan dan transaksi selesai.');

        return redirect('peminjaman_perlengkapan')->with('success', 'Sukses! Detail pengajuan dan info persetujuan segera dikirim melalui email Anda.');
    } catch (\Exception $e) {
        DB::rollback();
        \Log::error('Terjadi kesalahan saat menyimpan peminjaman: ' . $e->getMessage());
        return redirect('peminjaman_perlengkapan')->withErrors(['error' => 'Gagal menyimpan peminjaman: ' . $e->getMessage()])->withInput();
    }
}


    public function kirimKeFormPeminjaman(Request $request)
    {
       Log::info('kirimKeFormPeminjaman dijalankan dengan data: ' . json_encode($request->all())); // Tambahkan log di sini
        try {
            $request->validate([
                'id_perlengkapan_dipilih' => 'required|array',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation Error: ' . json_encode($e->errors()));
            return redirect()->back()->withErrors($e->errors());
        }


        session(['id_perlengkapan_dipilih' => $request->id_perlengkapan_dipilih]);
        Log::info('Session id_perlengkapan_dipilih di set: ' . json_encode(session('id_perlengkapan_dipilih')));

        return redirect('/peminjaman_perlengkapan/peminjaman_perlengkapan_formadd');
    }

    public function detail_peminjaman_perlengkapan($id_peminjaman_pkp)
{
    // Ambil semua peminjaman yang disetujui
    $peminjamanDisetujui = PeminjamanPkp::where('status_pk', 'disetujui')->get();

    $peminjamanPerKelompok = [];

    foreach ($peminjamanDisetujui as $peminjaman) {
        $perlengkapanDipinjam = $peminjaman->perlengkapan->pluck('nama_perlengkapan')->toArray();

        $peminjamanPerKelompok[] = [
            'id_peminjaman_pkp' => $peminjaman->id_peminjaman_pkp,
            'nama_peminjam_pk' => $peminjaman->nama_peminjam_pk,
            'tanggal_mulai_pk' => $peminjaman->tanggal_mulai_pk,
            'tanggal_selesai_pk' => $peminjaman->tanggal_selesai_pk,
            'nama_kegiatan_pk' => $peminjaman->nama_kegiatan_pk,
            'perlengkapan' => $perlengkapanDipinjam,
        ];

        // Tambahkan juga informasi gladi jika ada
        if ($peminjaman->butuh_gladi_pk && $peminjaman->tanggal_gladi_pk && $peminjaman->tanggal_pengembalian_gladi_pk) {
            $peminjamanPerKelompok[] = [
                'id_peminjaman_pkp' => $peminjaman->id_peminjaman_pkp,
                'nama_peminjam_pk' => $peminjaman->nama_peminjam_pk,
                'tanggal_mulai_pk' => $peminjaman->tanggal_gladi_pk,
                'tanggal_selesai_pk' => $peminjaman->tanggal_pengembalian_gladi_pk,
                'nama_kegiatan_pk' => $peminjaman->nama_kegiatan_pk . ' (Gladi)',
                'perlengkapan' => $perlengkapanDipinjam,
            ];
        }
    }

    // Urutkan berdasarkan tanggal mulai
    usort($peminjamanPerKelompok, function ($a, $b) {
        return strtotime($a['tanggal_mulai_pk']) - strtotime($b['tanggal_mulai_pk']);
    });

    return view('peminjaman_perlengkapan', compact('peminjamanPerKelompok'));
}
    
}
