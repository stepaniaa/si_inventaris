<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeminjamanRuang ; 
use App\PeminjamanRutin;
use App\Ruang; 
use App\Perlengkapan; 
use App\PeminjamanPkp;
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

    public function peminjaman_ruang()
    {
         Log::info('Akses halaman peminjaman ruang.');
$ruang = Ruang::all();
$peminjamanDisetujui = PeminjamanRuang::where('status', 'disetujui')->get();

$jadwal = [];
$tanggalSudahDitambahkan = []; // Array untuk melacak tanggal yang sudah ditambahkan

foreach ($peminjamanDisetujui as $p) {
    // Fungsi untuk menambahkan jadwal dengan pengecekan duplikasi
    $tambahJadwal = function ($nama_kegiatan, $tanggal_mulai, $tanggal_selesai, $jenis, $ruang) use (&$jadwal, &$tanggalSudahDitambahkan) {
        $tanggalMulaiStr = date('Y-m-d H:i:s', strtotime($tanggal_mulai)); //format tanggal
        if (!in_array($tanggalMulaiStr, $tanggalSudahDitambahkan)) {
            $jadwal[] = [
                'nama_kegiatan' => $nama_kegiatan,
                'tanggal_mulai' => $tanggal_mulai,
                'tanggal_selesai' => $tanggal_selesai,
                'jenis' => $jenis,
                'ruang' => $ruang,
            ];
            $tanggalSudahDitambahkan[] = $tanggalMulaiStr; // Tambahkan tanggal ke array pelacak
        }
    };

    // Jadwal Peminjaman Biasa
    $tambahJadwal($p->nama_kegiatan, $p->tanggal_mulai, $p->tanggal_selesai, 'Pelaksanaan', $p->ruang->nama_ruang);

    // Jadwal Gladi
    if ($p->butuh_gladi && $p->tanggal_gladi && $p->tanggal_pengembalian_gladi) {
        $tambahJadwal($p->nama_kegiatan . ' (Gladi)', $p->tanggal_gladi, $p->tanggal_pengembalian_gladi, 'Gladi', $p->ruang->nama_ruang);
    }

    // Jadwal Rutin dari JSON
    if ($p->rutin && $p->jadwal_rutin_json) {
        $jadwalRutin = json_decode($p->jadwal_rutin_json, true);
        if (isset($jadwalRutin['dates']) && is_array($jadwalRutin['dates'])) {
            foreach ($jadwalRutin['dates'] as $sesi) {
                $tanggalMulaiRutin = $sesi['tanggal'] . ' ' . $sesi['waktu_mulai'];
                $tanggalSelesaiRutin = $sesi['tanggal'] . ' ' . $sesi['waktu_selesai'];
                $tambahJadwal($p->nama_kegiatan . ' (Rutin)', $tanggalMulaiRutin, $tanggalSelesaiRutin, 'Rutin', $p->ruang->nama_ruang);
            }
        }
    }
}

usort($jadwal, fn($a, $b) => strtotime($a['tanggal_mulai']) - strtotime($b['tanggal_mulai']));

return view('peminjaman_ruang', compact('ruang', 'jadwal'));

    }
    
    public function peminjaman_ruang_formadd($id_ruang)
    {
        $ruang = Ruang::findOrFail($id_ruang);
        return view('peminjaman_ruang_formadd', compact('ruang'));
    }

    public function save_peminjaman_ruang(Request $request)
    {
        Log::info('Mencoba menyimpan pengajuan peminjaman ruang.');
        $validated = $request->validate([
            //data peminjam
            'nomor_induk' => 'required|string|max:50',
            'nama_peminjam' => 'required|string|max:100',
            'kontak' => 'required|string|max:20',
            'email' => 'required|email',
            //data peminjaman
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
            //tambahan 
             'asal_unit' => 'nullable|string',
             'peran' => 'nullable|string',
            'rutin' => 'nullable|boolean',
             'frekuensi' => 'nullable|in:harian,mingguan,bulanan',
            'hari_rutin' => 'nullable|string',
            'waktu_mulai_rutin' => 'nullable|date_format:H:i',
            'waktu_selesai_rutin' => 'nullable|date_format:H:i|after:waktu_mulai_rutin',
        ]);

        Log::info('Data yang divalidasi:', $validated);

        $ruangId = $request->id_ruang;
        $tanggalMulaiBaru = Carbon::parse($request->tanggal_mulai);
        $tanggalSelesaiBaru = Carbon::parse($request->tanggal_selesai);

        // Poin 3: Cek status pengembalian terakhir untuk RUANG ini (oleh siapapun)
       // $peminjamanBermasalah = PeminjamanRuang::where('id_ruang', $ruangId)
          //  ->whereIn('status_pengembalian', ['belum_dikembalikan', 'terlambat', 'rusak', 'hilang'])
          //  ->exists();

        //if ($peminjamanBermasalah) {
           // Log::warning('Ruang ID ' . $ruangId . ' tidak dapat dipesan karena status pengembalian bermasalah.');
           // return redirect()->back()->withErrors(['id_ruang' => "Ruang ini saat ini tidak dapat dipesan karena status pengembalian dari peminjaman sebelumnya belum selesai atau bermasalah."])->withInput();
        //}

        // Poin 2: Cek bentrokan jadwal (peminjaman biasa, gladi, dan rutin yang disetujui)
        $bentrok = PeminjamanRuang::where('id_ruang', $ruangId)
            ->where('status', 'disetujui')
            ->where(function ($query) use ($tanggalMulaiBaru, $tanggalSelesaiBaru) {
                // Bentrokan dengan peminjaman biasa
                $query->where('tanggal_mulai', '<', $tanggalSelesaiBaru)
                      ->where('tanggal_selesai', '>', $tanggalMulaiBaru);
            })
            ->orWhere(function ($query) use ($tanggalMulaiBaru, $tanggalSelesaiBaru) {
                // Bentrokan dengan gladi
                $query->where('tanggal_gladi', '<', $tanggalSelesaiBaru)
                      ->where('tanggal_pengembalian_gladi', '>', $tanggalMulaiBaru)
                      ->where('butuh_gladi', true);
            })
            ->orWhere(function ($query) use ($tanggalMulaiBaru, $tanggalSelesaiBaru, $ruangId) {
                // Bentrokan dengan sesi rutin
                $query->where('id_ruang', $ruangId)
                      ->where('status', 'disetujui')
                      ->where('rutin', true)
                      ->where('jadwal_rutin_json', '!=', null)
                      ->whereJsonLength('jadwal_rutin_json->dates', '>', 0)
                      ->where(function ($sq) use ($tanggalMulaiBaru, $tanggalSelesaiBaru) {
                          $sq->whereRaw('JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].tanggal") = ?', [$tanggalMulaiBaru->toDateString()])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_mulai")) < ?', [$tanggalSelesaiBaru->format('H:i')])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_selesai")) > ?', [$tanggalMulaiBaru->format('H:i')]);
                      })
                      ->orWhere(function ($sq) use ($tanggalMulaiBaru, $tanggalSelesaiBaru) {
                          $sq->whereRaw('JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].tanggal") = ?', [$tanggalSelesaiBaru->toDateString()])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_mulai")) < ?', [$tanggalSelesaiBaru->format('H:i')])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_selesai")) > ?', [$tanggalMulaiBaru->format('H:i')]);
                      })
                      ->orWhere(function ($sq) use ($tanggalMulaiBaru, $tanggalSelesaiBaru) {
                          $sq->whereRaw('JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].tanggal") > ?', [$tanggalMulaiBaru->toDateString()])
                             ->whereRaw('JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].tanggal") < ?', [$tanggalSelesaiBaru->toDateString()])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_mulai")) < ?', [$tanggalSelesaiBaru->format('H:i')])
                             ->whereRaw('TIME(JSON_EXTRACT(jadwal_rutin_json, "$.dates[*].waktu_selesai")) > ?', [$tanggalMulaiBaru->format('H:i')]);
                      });
            })
            ->exists();

        if ($bentrok) {
            Log::warning('Pengajuan peminjaman ruang ID ' . $ruangId . ' bentrok dengan jadwal lain.');
            return redirect()->back()->withErrors(['tanggal_mulai' => 'Ruang sudah dipesan pada waktu yang Anda pilih. Silakan cek jadwal.'])->withInput();
        }

        if ($request->hasFile('surat_peminjaman')) {
            $file = $request->file('surat_peminjaman');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/surat_peminjaman', $filename);
            $validated['surat_peminjaman'] = $filename;
            Log::info('Surat peminjaman disimpan di: ' . $path);
        }

        $validated['id_pj_peminjaman'] = auth()->id();
        $validated['rutin'] = $request->rutin ? true : false;
        $validated['jadwal_rutin_json'] = null;

        $peminjamanRuang = PeminjamanRuang::create($validated);
        Log::info('Pengajuan peminjaman ruang berhasil dibuat dengan ID: ' . $peminjamanRuang->id_peminjaman_ruang);

        // Jika peminjaman rutin
        if ($validated['rutin']) {
            $startDateRutin = Carbon::parse($request->tanggal_mulai);
            $endDateRutin = Carbon::parse($request->tanggal_selesai);
            $frekuensi = $request->frekuensi;
            $hariRutin = $request->hari_rutin;
            $waktuMulaiRutin = $request->waktu_mulai_rutin;
            $waktuSelesaiRutin = $request->waktu_selesai_rutin;

            $dates = $this->generateRepeatingDatesForJson($startDateRutin, $endDateRutin, $frekuensi, $hariRutin, $waktuMulaiRutin, $waktuSelesaiRutin);

            $validated['jadwal_rutin_json'] = json_encode([
                'frekuensi' => $frekuensi,
                'hari_rutin' => $hariRutin,
                'waktu_mulai_rutin' => $waktuMulaiRutin,
                'waktu_selesai_rutin' => $waktuSelesaiRutin,
                'tanggal_mulai_rutin' => $startDateRutin->toDateString(),
                'tanggal_selesai_rutin' => $endDateRutin->toDateString(),
                'dates' => $dates,
            ]);

            $peminjamanRuang->update(['jadwal_rutin_json' => $validated['jadwal_rutin_json']]);
            Log::info('Jadwal rutin berhasil disimpan untuk peminjaman ID: ' . $peminjamanRuang->id_peminjaman_ruang, ['jadwal' => $validated['jadwal_rutin_json']]);
        }

        Log::info('Redirecting setelah pengajuan peminjaman.');
        return redirect('/peminjaman_ruang')->with('success', 'Peminjaman berhasil diajukan.');
    }

    // Fungsi untuk generate tanggal rutin (untuk JSON)
   private function generateRepeatingDatesForJson($startDate, $endDate, $frekuensi, $hari_id, $waktuMulai, $waktuSelesai)
{
    $dates = [];
    $currentDate = $startDate->copy()->setTimeFromTimeString($waktuMulai);
    $endDateWithTime = $endDate->copy()->setTimeFromTimeString($waktuSelesai);
    $logData = [
        'startDate' => $startDate,
        'endDate' => $endDate,
        'frekuensi' => $frekuensi,
        'hari_id' => $hari_id,
        'waktuMulai' => $waktuMulai,
        'waktuSelesai' => $waktuSelesai
    ];
    Log::info('Memulai generate jadwal rutin.', $logData);

    // Mapping hari Indonesia ke Inggris
    $hariInggris = [
        'minggu' => 'Sunday',
        'senin' => 'Monday',
        'selasa' => 'Tuesday',
        'rabu' => 'Wednesday',
        'kamis' => 'Thursday',
        'jumat' => 'Friday',
        'sabtu' => 'Saturday',
    ];
    $hariInggrisDipilih = strtolower($hariInggris[$hari_id] ?? '');

    // Validasi frekuensi
    if (!in_array($frekuensi, ['harian', 'mingguan', 'bulanan'])) {
        Log::warning('Frekuensi tidak dikenali: ' . $frekuensi);
        return []; // Mengembalikan array kosong jika frekuensi tidak valid
    }

    // Jika hari rutin tidak valid
    if ($frekuensi !== 'harian' && !$hariInggrisDipilih) {
        Log::warning('Hari rutin tidak valid: ' . $hari_id);
        return [];
    }

    Log::info('Target Hari: ' . $hariInggrisDipilih);
    Log::info('Tanggal Mulai: ' . $currentDate->format('Y-m-d H:i:s'));
    Log::info('Tanggal Selesai: ' . $endDateWithTime->format('Y-m-d H:i:s'));


    while ($currentDate->lte($endDateWithTime)) {
        $tambahTanggal = false;
        if ($frekuensi === 'harian') {
            $tambahTanggal = true;
        } elseif ($frekuensi === 'mingguan' && strtolower($currentDate->format('l')) === $hariInggrisDipilih) {
            $tambahTanggal = true;
        } elseif ($frekuensi === 'bulanan' && $currentDate->format('d') === $startDate->format('d') && strtolower($currentDate->format('l')) === $hariInggrisDipilih) {
            $tambahTanggal = true;
        }

        if ($tambahTanggal) {
            $tanggalFormat = $currentDate->format('Y-m-d');
            $waktuMulaiSesi = $waktuMulai;
            $waktuSelesaiSesi = $waktuSelesai;
            $dates[] = [
                'tanggal' => $tanggalFormat,
                'waktu_mulai' => $waktuMulaiSesi,
                'waktu_selesai' => $waktuSelesaiSesi,
            ];
            Log::info('Menambahkan tanggal:', [
                'tanggal' => $tanggalFormat,
                'waktu_mulai' => $waktuMulaiSesi,
                'waktu_selesai' => $waktuSelesaiSesi,
                'hari_inggris' => strtolower($currentDate->format('l'))
            ]);
        }

        if ($frekuensi === 'harian') {
            $currentDate->addDay();
        } elseif ($frekuensi === 'mingguan') {
            $currentDate->addWeek();
        } elseif ($frekuensi === 'bulanan') {
             $currentDate->addMonth();
        }
    }

    Log::info('Selesai generate jadwal rutin. Jumlah tanggal: ' . count($dates));
    return $dates;
}





















    //-----------------------------------------------------------------------------------------------------]
    //Peminjaman Perlengkapan 
    public function peminjaman_perlengkapan()
    {
       $perlengkapan = Perlengkapan::all();

        // Tambahkan status saat ini ke setiap perlengkapan
        foreach ($perlengkapan as $item) {
            // Perbaikan: Periksa relasi dengan tabel pivot
            $sedangDipinjam = PeminjamanPkp::whereHas('perlengkapan', function ($query) use ($item) {
                $query->where('perlengkapan.id_perlengkapan', $item->id_perlengkapan); // Perjelas tabel perlengkapan
            })
                ->where('status_pk', 'disetujui')
                ->where(function ($query) {
                    $query->whereDate('tanggal_mulai_pk', '<=', now())
                        ->whereDate('tanggal_selesai_pk', '>=', now());
                })
                ->exists();

            $item->status_saat_ini = $sedangDipinjam ? 'Dipinjam' : 'Tersedia';
        }

        $peminjamanDisetujui = PeminjamanPkp::where('status_pk', 'disetujui')->get();

        $peminjamanPerKelompok = [];


        foreach ($peminjamanDisetujui as $p) {
            // Perbaikan: Iterasi melalui perlengkapan yang terkait dengan peminjaman
            foreach ($p->perlengkapan as $perlengkapanItem) {
                $jadwal[] = [
                    'nama_kegiatan_pk' => $p->nama_kegiatan_pk,
                    'tanggal_pk' => $p->tanggal_mulai_pk,
                    'waktu_selesai_pk' => $p->tanggal_selesai_pk,
                    'jenis_pk' => 'Pelaksanaan',
                    'perlengkapan' => $perlengkapanItem->nama_perlengkapan, // Akses nama perlengkapan
                ];
            }


            if ($p->butuh_gladi_pk && $p->tanggal_gladi_pk && $p->tanggal_selesai_gladi_pk) {
                foreach ($p->perlengkapan as $perlengkapanItem) {
                    $jadwal[] = [
                        'nama_kegiatan_pk' => $p->nama_kegiatan_pk . ' (Gladi)',
                        'tanggal_pk' => $p->tanggal_gladi_pk,
                        'waktu_selesai_pk' => $p->tanggal_selesai_gladi_pk,
                        'jenis_pk' => 'Gladi',
                        'perlengkapan' => $perlengkapanItem->nama_perlengkapan, // Akses nama perlengkapan
                    ];
                }
            }
        }

        usort($jadwal, fn ($a, $b) => strtotime($a['tanggal_pk']) - strtotime($b['tanggal_pk']));

        return view('peminjaman_perlengkapan', compact('perlengkapan', 'peminjamanPerKelompok'));
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
          $validator = Validator::make($request->all(), [
            'nomor_induk_pk' => 'required|string|max:50',
            'nama_peminjam_pk' => 'required|string|max:100',
            'kontak_pk' => 'required|string|max:20',
            'email_pk' => 'required|email',
            'nama_kegiatan_pk' => 'required|string|max:100',
            'keterangan_kegiatan_pk' => 'nullable|string',
            'id_perlengkapan' => 'required|array',
            'id_perlengkapan.*' => 'exists:perlengkapan,id_perlengkapan',
            'tanggal_mulai_pk' => 'required|date',
            'tanggal_selesai_pk' => 'required|date|after_or_equal:tanggal_mulai_pk',
            'butuh_gladi_pk' => 'nullable|boolean',
            'tanggal_gladi_pk' => 'nullable|date',
            'tanggal_selesai_gladi_pk' => 'nullable|date|after_or_equal:tanggal_gladi_pk',
            'butuh_livestream_pk' => 'nullable|boolean',
            'butuh_operator_pk' => 'nullable|boolean',
            'operator_sound_pk' => 'nullable|string|max:100',
            'operator_live_pk' => 'nullable|string|max:100',
            'surat_peminjaman_pk' => 'nullable|file|mimes:pdf|max:2048',
        ]);

       if ($validator->fails()) {
        Log::error('Validasi gagal: ' . json_encode($validator->errors()->all()));
        return redirect()->back()->withErrors($validator)->withInput();
    }

    // Gunakan transaksi database untuk memastikan konsistensi
        // Lakukan validasi bentrok jadwal untuk setiap perlengkapan yang dipilih
          // Gunakan transaksi database untuk memastikan konsistensi
    DB::beginTransaction();
    try {
        // Lakukan validasi bentrok jadwal untuk setiap perlengkapan yang dipilih
        foreach ($request->id_perlengkapan as $idPerlengkapan) {
            $bentrok_jadwal = PeminjamanPkp::whereHas('perlengkapan', function ($query) use ($idPerlengkapan) {
                $query->where('perlengkapan.id_perlengkapan', $idPerlengkapan);
            })
            ->where('status_pk', 'Disetujui')
            // Modifikasi di sini untuk memperbolehkan peminjaman di tanggal berikutnya DAN memperbaiki logika bentrok
            ->where(function ($q) use ($request) {
                $q->where(function ($q1) use ($request) {
                    $q1->where('tanggal_mulai_pk', '<', $request->tanggal_selesai_pk)
                       ->where('tanggal_selesai_pk', '>', $request->tanggal_mulai_pk);
                });
            })
            ->exists();

            if ($bentrok_jadwal) {
                $perlengkapan = Perlengkapan::findOrFail($idPerlengkapan);
                return redirect()->back()->withErrors(['id_perlengkapan' => 'Perlengkapan "' . $perlengkapan->nama_perlengkapan . '" sudah dipesan pada tanggal tersebut. Mohon perhatikan peminjaman akan datang pada menu peminjaman.'])->withInput();
            }
        }
    
        $status_gladi = $request->butuh_gladi_pk
            ? 'belum'
            : 'tidak_ada_gladi';

        $status_pk = 'diproses';

        $filename = null;
        if ($request->hasFile('surat_peminjaman_pk')) {
            $file = $request->file('surat_peminjaman_pk');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/surat_peminjaman_perlengkapan', $filename);
        }

        // Buat peminjaman baru
        $peminjaman = PeminjamanPkp::create([
            'nomor_induk_pk' => $request->nomor_induk_pk,
            'nama_peminjam_pk' => $request->nama_peminjam_pk,
            'kontak_pk' => $request->kontak_pk,
            'email_pk' => $request->email_pk,
            'nama_kegiatan_pk' => $request->nama_kegiatan_pk,
            'keterangan_kegiatan_pk' => $request->keterangan_kegiatan_pk,
            'tanggal_mulai_pk' => $request->tanggal_mulai_pk,
            'tanggal_selesai_pk' => $request->tanggal_selesai_pk,
            'butuh_gladi_pk' => $request->butuh_gladi_pk ?? false,
            'tanggal_gladi_pk' => $request->tanggal_gladi_pk,
            'tanggal_selesai_gladi_pk' => $request->tanggal_selesai_gladi_pk,
            'butuh_livestream_pk' => $request->butuh_livestream_pk ?? false,
            'butuh_operator_pk' => $request->butuh_operator_pk ?? false,
            'operator_sound_pk' => $request->operator_sound_pk,
            'operator_live_pk' => $request->operator_live_pk,
            'surat_peminjaman_pk' => $filename,
            'status_pk' => $status_pk,
            'status_gladi_pk' => $status_gladi,
            'id_pj_peminjaman_pk' => Auth::id(),
        ]);
        Log::info('Peminjaman dibuat dengan ID: ' . $peminjaman->id_peminjaman_pkp);



        foreach ($request->id_perlengkapan as $idPerlengkapan) {
            $perlengkapanItem = Perlengkapan::findOrFail($idPerlengkapan);
            $perlengkapanItem->stok_perlengkapan -= 1;
            $perlengkapanItem->save();
        }
        // Perbaikan: Gunakan attach untuk menyimpan relasi dengan data tambahan
        $peminjaman->perlengkapan()->attach($request->id_perlengkapan);
        Log::info('Perlengkapan diattach ke peminjaman.');

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Terjadi kesalahan: ' . $e->getMessage());
        return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
    }

    Log::info('Peminjaman berhasil diajukan.');
    return redirect('peminjaman_perlengkapan')->with('success', 'Peminjaman perlengkapan berhasil diajukan.');
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
