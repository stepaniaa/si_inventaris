@extends('layout.staff_main')
@section('title', 'Validasi Peminjaman Ruang')
@section('content')
<div class="container">
    <h2>Validasi Peminjaman Perlengkapan</h2>

    <div class="card mt-4 mb-4">
        <div class="card-body">
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam_pk }}</p>
            <p><strong>Email:</strong> {{ $peminjaman->email_pk }}</p>
            <p><strong>Perlengkapan:</strong> {{ $peminjaman->perlengkapan->nama_perlengkapan }}</p>
            <p><strong>Jumlah:</strong> {{ $peminjaman->jumlah_peminjaman_pk }}</p>
            <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan_pk }}</p>
            <p><strong>Tanggal:</strong> {{ $peminjaman->tanggal_mulai_pk }} - {{ $peminjaman->tanggal_selesai_pk }}</p>
            @if ($peminjaman->butuh_gladi_pk)
                <p><strong>Gladi:</strong> {{ $peminjaman->tanggal_gladi_pk }} - {{ $peminjaman->tanggal_selesai_gladi_pk }}</p>
            @endif
        </div>
    </div>

    <form action="/staff_peminjaman_perlengkapan/save_validasi_peminjaman_perlengkapan/{{ $peminjaman->id_peminjaman_perlengkapan }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="status">Status Persetujuan</label>
            <select name="status_pk" id="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="catatan_staff">Catatan (Opsional)</label>
            <textarea name="catatan_staff_pk" id="catatan_staff" rows="4" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan Validasi</button>
        <a href="/staff_peminjaman_perlengkapan" class="btn btn-secondary mt-3">Kembali</a>
    </form>
</div>
@endsection