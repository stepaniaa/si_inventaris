@extends('layout.peminjam_main')
@section('title', 'Form Peminjaman Perlengkapan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Form Peminjaman Perlengkapan</h3>

    {{-- Daftar Perlengkapan yang Dipilih --}}
    <div class="card mb-4">
        <div class="card-header">Perlengkapan yang Akan Dipinjam</div>
        <div class="card-body">
            @if ($perlengkapan->isEmpty())
                <p>Tidak ada perlengkapan yang dipilih.</p>
            @else
                <ul class="list-group">
                    @foreach ($perlengkapan as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $item->nama_perlengkapan }}
                            <span class="badge bg-secondary">{{ $item->kode_perlengkapan }}</span>
                        </li>
                        <input type="hidden" name="id_perlengkapan[]" value="{{ $item->id_perlengkapan }}">
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    {{-- Form Data Peminjaman --}}
    <form action="{{ url('/peminjaman_perlengkapan/save_peminjaman_perlengkapan') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nomor Induk</label>
                <input type="text" name="nomor_induk_pk" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Nama Peminjam</label>
                <input type="text" name="nama_peminjam_pk" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Kontak</label>
                <input type="text" name="kontak_pk" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email_pk" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan_pk" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Keterangan Kegiatan</label>
            <textarea name="keterangan_kegiatan_pk" class="form-control"></textarea>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai_pk" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai_pk" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-check">
                    <input type="checkbox" name="butuh_gladi_pk" value="1" class="form-check-input" id="butuhGladi">
                    <label class="form-check-label" for="butuhGladi">Butuh Gladi?</label>
                </div>
            </div>
            <div class="col-md-4">
                <label>Tanggal Gladi</label>
                <input type="date" name="tanggal_gladi_pk" class="form-control">
            </div>
            <div class="col-md-4">
                <label>Tanggal Selesai Gladi</label>
                <input type="date" name="tanggal_selesai_gladi_pk" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="butuh_livestream_pk" value="1" class="form-check-input" id="butuhLive">
                    <label class="form-check-label" for="butuhLive">Butuh Livestream?</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-check">
                    <input type="checkbox" name="butuh_operator_pk" value="1" class="form-check-input" id="butuhOperator">
                    <label class="form-check-label" for="butuhOperator">Butuh Operator?</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Operator Sound</label>
                <input type="text" name="operator_sound_pk" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Operator Live</label>
                <input type="text" name="operator_live_pk" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Upload Surat Peminjaman (PDF)</label>
            <input type="file" name="surat_peminjaman_pk" class="form-control" accept="application/pdf">
        </div>

        <div class="mb-3">
            <label>Jumlah Peminjaman (untuk semua perlengkapan)</label>
            <input type="number" name="jumlah_peminjaman_pk" class="form-control" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Ajukan Peminjaman</button>
    </form>
</div>
@endsection
