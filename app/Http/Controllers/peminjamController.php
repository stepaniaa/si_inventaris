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
    $kapel = Ruang::where('bisa_dipinjam', 'ya')->get();
     $peminjamanDisetujui = PeminjamanKapel::where('status_pengajuan', 'disetujui')
         ->whereHas('sesi', function ($query) {
        $query->where('status_sesi', '!=', 'batal');  // Ini prioritas utama, langsung skip sesi batal
    })
    ->whereHas('sesi', function ($query) {
        $query->where('status_pengembalian_kp', '!=', 'sudah')
              ->whereNotNull('status_pengembalian_kp');
    })
    ->get();

foreach ($peminjamanDisetujui as $peminjaman) {
    if ($peminjaman->ruang) {
        foreach ($peminjaman->sesi as $sesi) {
            $jadwal[] = [
                'nama_kegiatan' => $peminjaman->nama_kegiatan,
                'tanggal_mulai' => Carbon::parse($sesi->tanggal_mulai_sesi)->translatedFormat('d F Y H:i'),
                'tanggal_selesai' => Carbon::parse($sesi->tanggal_selesai_sesi)->translatedFormat('d F Y H:i'),
                'kapel' => $peminjaman->ruang->nama_ruang,
            ];
        }
    }
}

// Urutkan berdasarkan tanggal mulai
usort($jadwal, fn ($a, $b) => strtotime($a['tanggal_mulai']) - strtotime($b['tanggal_mulai']));

    // Kirim data ke view
    return view('peminjaman_kapel', compact('kapel','jadwal'));
    }

    public function peminjaman_kapel_formadd($id_ruang)
    {
        $kapel = Ruang::findOrFail($id_ruang);

    // Cegah akses jika ruang tidak bisa dipinjam
    if ($kapel->bisa_dipinjam !== 'ya') {
        return redirect()->back()->with('error', 'Ruang ini tidak tersedia untuk dipinjam.');
    }

    return view('peminjaman_kapel_formadd', compact('kapel'));
    }

    public function save_peminjaman_kapel(Request $request)
    {
        \Log::info('Mulai proses penyimpanan peminjaman ruang dengan data: ' . json_encode($request->all()));

        $isKapelAtas = $request->id_ruang == 1;

        $emailRules = ['required', 'email'];
        
        $validator = Validator::make($request->all(), [
            'nomor_induk' => $isKapelAtas ? 'required|string|max:50' : 'nullable|string|max:50',
            'nama_peminjam' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'asal_unit' => 'nullable|string|max:100',
            'peran' => 'nullable|string|max:50',
             'email' => $emailRules,
            'nama_kegiatan' => 'required|string|max:150',
            'keterangan_kegiatan' => 'nullable|string',
            'id_ruang' => 'required|exists:ruang,id_ruang',
            //'tanggal_mulai' => 'required|date',
            //'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'butuh_livestream' => $isKapelAtas ? 'nullable|boolean' : 'prohibited', // HANYA untuk Kapel Atas
            'butuh_operator' => $isKapelAtas ? 'nullable|boolean' : 'prohibited',
            'operator_sound' => $isKapelAtas ? 'nullable|string|max:100' : 'prohibited',
            'operator_live' => $isKapelAtas ? 'nullable|string|max:100' : 'prohibited',
            'rutin' => 'nullable|boolean',
            'tipe_rutin' => 'required_if:rutin,1|in:mingguan,bulanan',
            'jumlah_perulangan' => 'required_if:rutin,1|integer|min:1',
            'tanggal_sesi_awal.mulai' => 'required|date',
            'tanggal_sesi_awal.selesai' => 'required|date|after_or_equal:tanggal_sesi_awal.mulai',
            'surat_peminjaman' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', 
             'bukti_ukdw' => $isKapelAtas ? 'required|file|mimes:pdf,jpg,jpeg,png|max:2048' : 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
         ],
    [
         'bukti_ukdw.required' => 'Wajib upload bukti jika meminjam Kapel Atas.',
    ]
);

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

        $buktiUKDWFile = null;
        if ($request->hasFile('bukti_ukdw')) {
            $buktiFile = $request->file('bukti_ukdw');
            $buktiUKDWFile = time() . '_ukdw_' . $buktiFile->getClientOriginalName();
            $buktiFile->storeAs('public/bukti_ukdw', $buktiUKDWFile);
            \Log::info('File bukti_ukdw disimpan: ' . $buktiUKDWFile);
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
            ->where('status_sesi', 'aktif')  // Pastikan hanya sesi yang aktif
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
                'jumlah_kursi' => $request->jumlah_kursi,
                'id_ruang' => $request->id_ruang,
                'butuh_livestream' => $isKapelAtas ? ($request->has('butuh_livestream') ? 1 : 0) : 0,
                'butuh_operator' => $isKapelAtas ? ($request->has('butuh_operator') ? 1 : 0) : 0,
                'operator_sound' => $isKapelAtas ? $request->operator_sound : null,
                'operator_live' => $isKapelAtas ? $request->operator_live : null,
                //'tanggal_mulai' => Carbon::parse($request->tanggal_mulai)->format('Y-m-d H:i:s'),
                //'tanggal_selesai' => Carbon::parse($request->tanggal_selesai)->format('Y-m-d H:i:s'),
                'status_pengajuan' => 'proses',
                'rutin' => $isRutin,
                'tipe_rutin' => $isRutin ? $request->tipe_rutin : null,
                'jumlah_perulangan' => $isRutin ? $request->jumlah_perulangan : null,
                 'surat_peminjaman' => $filename, // SIMPAN NAMA FILE
                  'bukti_ukdw' => $buktiUKDWFile,
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
    $perlengkapan = Perlengkapan::where('status_perlengkapan', 'aktif')
    ->where('bisa_dipinjam_pk', 'ya')
    ->get();
    $now = Carbon::now();
    $peminjamansAkanDatang = PeminjamanPkp::where('status_pk', 'disetujui')
        ->whereHas('sesi', function ($q) use ($now) {
            $q->where('tanggal_mulai_sesi', '>', $now);
        })
        ->with(['perlengkapan', 'sesi' => function ($q) use ($now) {
            $q->where('tanggal_mulai_sesi', '>', $now)->orderBy('tanggal_mulai_sesi', 'asc');
        }])
        ->orderBy('id_peminjaman_pkp', 'desc')
        ->paginate(5);

    return view('peminjaman_perlengkapan', compact('perlengkapan', 'peminjamansAkanDatang'));
}

    public function peminjaman_perlengkapan_formadd()
    {
        $ids = session('id_perlengkapan_dipilih', []);
        $perlengkapan = Perlengkapan::whereIn('id_perlengkapan', $ids)
         ->where('bisa_dipinjam_pk', 'ya')
         ->get();

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
        'email_pk' => 'required|email|regex:/ukdw\\.ac\\.id$/i',
        'nama_kegiatan_pk' => 'required|string|max:100',
        'keterangan_kegiatan_pk' => 'nullable|string',
        'lokasi_kegiatan_pk' => 'required|string|max:255', // DITAMBAHKAN
        'id_perlengkapan' => 'required|array',
        'id_perlengkapan.*' => 'exists:perlengkapan,id_perlengkapan',
        //'butuh_livestream_pk' => 'nullable|boolean',
        //'butuh_operator_pk' => 'nullable|boolean',
        'surat_peminjaman_pk' => 'nullable|file|mimes:pdf|max:2048',
        'rutin' => 'nullable|boolean',
        'tipe_rutin' => 'required_if:rutin,1|in:mingguan,bulanan',
        'jumlah_perulangan' => 'required_if:rutin,1|integer|min:1',
        'tanggal_sesi_awal.mulai' => 'required|date',
        'tanggal_sesi_awal.selesai' => 'required|date|after_or_equal:tanggal_sesi_awal.mulai',
    ], [
        'email_pk.regex' => 'Email harus menggunakan domain ukdw.ac.id.', // DITAMBAHKAN
        'lokasi_kegiatan_pk.required' => 'Lokasi kegiatan wajib diisi.' // DITAMBAHKAN
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
            'lokasi_kegiatan_pk' => $request->lokasi_kegiatan_pk,
            //'butuh_livestream_pk' => $request->butuh_livestream_pk ?? false,
            //'butuh_operator_pk' => $request->butuh_operator_pk ?? false,
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
                ->where('status_sesi', 'aktif')  // Pastikan hanya sesi yang aktif
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

    public function peminjaman_perlengkapan_akan_datang()
{
    $now = Carbon::now();

    // Ambil peminjaman yang punya sesi mulai di masa depan dan status disetujui
    $peminjamans = PeminjamanPkp::where('status_pk', 'disetujui')
        ->whereHas('sesi', function ($query) use ($now) {
            $query->where('tanggal_mulai_sesi', '>', $now);
        })
        ->with(['sesi' => function ($query) use ($now) {
            $query->where('tanggal_mulai_sesi', '>', $now)
                  ->orderBy('tanggal_mulai_sesi', 'asc');
        }, 'perlengkapan'])
        ->orderBy('id_peminjaman_pkp', 'desc')
        ->paginate(10);

    return view('peminjaman_perlengkapan_akan_datang', compact('peminjamans'));
}
    
}
