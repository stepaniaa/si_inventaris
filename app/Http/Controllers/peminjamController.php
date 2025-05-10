<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PeminjamanRuang ; 
use App\Ruang; 
use App\Perlengkapan; 
use App\PeminjamanPkp;
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

        $jadwal = [];

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

        return view('peminjaman_perlengkapan', compact('perlengkapan', 'jadwal'));
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

        // Gunakan transaksi database untuk memastikan konsistensi
        DB::beginTransaction();
        try {
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
                'tanggal_selesai_gladi_pk' => $request->tanggal_selesai_gladi_pk ?? false,
                'butuh_livestream_pk' => $request->butuh_livestream_pk ?? false,
                'butuh_operator_pk' => $request->butuh_operator_pk ?? false,
                'operator_sound_pk' => $request->operator_sound_pk,
                'operator_live_pk' => $request->operator_live_pk,
                'surat_peminjaman_pk' => $filename,
                'status_pk' => $status_pk,
                'status_gladi_pk' => $status_gladi,
                'id_user' => Auth::id(),
            ]);
            Log::info('Peminjaman dibuat dengan ID: ' . $peminjaman->id_peminjaman_pkp);

            foreach ($request->id_perlengkapan as $idPerlengkapan) {
                $perlengkapanItem = Perlengkapan::findOrFail($idPerlengkapan);
                if ($perlengkapanItem->stok_perlengkapan < 1) {
                    DB::rollback();
                    Log::error('Stok perlengkapan tidak mencukupi untuk ID: ' . $idPerlengkapan);
                    return redirect()->back()->withErrors(['stok' => 'Stok perlengkapan tidak mencukupi.'])->withInput();
                }
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
}
