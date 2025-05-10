@extends('layout.staff_main')
@section('title', 'Validasi Peminjaman Ruang')

@section('content')
<div class="container mt-4">
    <h2>Form Validasi Peminjaman Ruang</h2>
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

    <div class="card mb-4">
        <div class="card-header">
            Detail Peminjaman
        </div>
        <div class="card-body">
            <p><strong>Ruang:</strong> {{ $peminjaman->ruang->nama_ruang ?? '-' }}</p>
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
            <p><strong>Nomor Induk:</strong> {{ $peminjaman->nomor_induk }}</p>
            <p><strong>Kontak:</strong> {{ $peminjaman->kontak }}</p>
            <p><strong>Email:</strong> {{ $peminjaman->email }}</p>
            <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</p>
            <p><strong>Keterangan Kegiatan:</strong> {{ $peminjaman->keterangan_kegiatan }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $peminjaman->tanggal_mulai }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $peminjaman->tanggal_selesai }}</p>
            <p><strong>Jumlah Kursi Tambahan:</strong> {{ $peminjaman->jumlah_kursi_tambahan ?? '-' }}</p>
            <p><strong>Butuh Gladi:</strong> {{ $peminjaman->butuh_gladi ? 'Ya' : 'Tidak' }}</p>
            @if($peminjaman->butuh_gladi)
                <p><strong>Tanggal Gladi:</strong> {{ $peminjaman->tanggal_gladi ?? '-' }}</p>
                <p><strong>Tanggal Pengembalian Gladi:</strong> {{ $peminjaman->tanggal_pengembalian_gladi ?? '-' }}</p>
            @endif
            <p><strong>Butuh Livestream:</strong> {{ $peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</p>
            <p><strong>Butuh Operator:</strong> {{ $peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</p>
            @if($peminjaman->butuh_operator)
                <p><strong>Operator Sound:</strong> {{ $peminjaman->operator_sound ?? '-' }}</p>
            @endif
            <p><strong>Surat Peminjaman:</strong> 
                @if($peminjaman->surat_peminjaman)
                    <a href="{{ asset('storage/surat_peminjaman/' . $peminjaman->surat_peminjaman) }}" target="_blank">Lihat Surat</a>
                @else
                    -
                @endif
            </p>
        </div>
    </div>

    <form action="/staff_peminjaman_ruang/save_validasi_peminjaman_ruang/{{ $peminjaman->id_peminjaman_ruang }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="status">Status Persetujuan</label>
            <select name="status" id="status" class="form-control" required>
                <option value="" disabled selected>-- Pilih Status --</option>
                <option value="disetujui">Setujui</option>
                <option value="ditolak">Tolak</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="catatan_staff">Catatan Staff (Opsional)</label>
            <textarea name="catatan_staff" id="catatan_staff" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Persetujuan</button>
        <a href="/staff_peminjaman_ruang" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
