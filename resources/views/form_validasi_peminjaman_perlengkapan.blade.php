@extends('layout.staff_main')
@section('title', 'Validasi Peminjaman Ruang')
@section('content')
<div class="container">
    <h2>Validasi Peminjaman Perlengkapan</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam_pk }}</p>
            <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan_pk }}</p>
           <p><strong>Tanggal Awal Mulai:</strong> {{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
           <p><strong>Tanggal Awal Selesai:</strong> {{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
            <p><strong>Perlengkapan:</strong></p>
            <ul>
                @foreach($peminjaman->perlengkapan as $item)
                    <li>{{ $item->nama_perlengkapan }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <form action= "/staff_peminjaman_perlengkapan/save_validasi_peminjaman_perlengkapan/{{ $peminjaman->id_peminjaman_pkp }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group mb-3">
            <label>Status Validasi</label>
            <select name="status_pk" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>
        <div class="form-group mb-3">
            <label>Catatan Staff</label>
            <textarea name="catatan_peminjaman" class="form-control" rows="4"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Validasi</button>
    </form>
</div>
@endsection