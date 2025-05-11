@extends('layout.peminjam_main')
@section('title', 'Form Peminjaman Perlengkapan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Form Peminjaman Perlengkapan</h3>

    <form action="{{ url('/peminjaman_perlengkapan/save_peminjaman_perlengkapan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label for="nomor_induk_pk">Nomor Induk:</label>
            <input type="text" class="form-control" name="nomor_induk_pk" required>
        </div>

        <div class="form-group">
            <label for="nama_peminjam_pk">Nama Peminjam:</label>
            <input type="text" class="form-control" name="nama_peminjam_pk" required>
        </div>

        <div class="form-group">
            <label for="kontak_pk">Kontak:</label>
            <input type="text" class="form-control" name="kontak_pk" required>
        </div>

        <div class="form-group">
            <label for="email_pk">Email:</label>
            <input type="email" class="form-control" name="email_pk" required>
        </div>

        <div class="form-group">
            <label for="nama_kegiatan_pk">Nama Kegiatan:</label>
            <input type="text" class="form-control" name="nama_kegiatan_pk" required>
        </div>

        <div class="form-group">
            <label for="keterangan_kegiatan_pk">Keterangan Kegiatan:</label>
            <textarea class="form-control" name="keterangan_kegiatan_pk"></textarea>
        </div>

        <div class="form-group">
    <label>Perlengkapan:</label><br>
    @foreach ($perlengkapan as $item)
        <input type="hidden" name="id_perlengkapan[]" value="{{ $item->id_perlengkapan }}">
        {{ $item->nama_perlengkapan }}
    @endforeach
</div>


        <div class="form-group">
            <label for="tanggal_mulai_pk">Tanggal Mulai:</label>
            <input type="datetime-local" class="form-control" name="tanggal_mulai_pk" required>
        </div>

        <div class="form-group">
            <label for="tanggal_selesai_pk">Tanggal Selesai:</label>
            <input type="datetime-local" class="form-control" name="tanggal_selesai_pk" required>
        </div>

        <div class="form-group">
            <label for="butuh_gladi_pk">Butuh Gladi:</label>
            <input type="checkbox" name="butuh_gladi_pk" value="1">
        </div>

        <div class="form-group">
            <label for="tanggal_gladi_pk">Tanggal Gladi:</label>
            <input type="datetime-local" class="form-control" name="tanggal_gladi_pk">
        </div>

        <div class="form-group">
            <label for="tanggal_selesai_gladi_pk">Tanggal Selesai Gladi:</label>
            <input type="datetime-local" class="form-control" name="tanggal_selesai_gladi_pk">
        </div>

        <div class="form-group">
            <label for="butuh_livestream_pk">Butuh Livestream:</label>
            <input type="checkbox" name="butuh_livestream_pk" value="1">
        </div>

        <div class="form-group">
            <label for="butuh_operator_pk">Butuh Operator:</label>
            <input type="checkbox" name="butuh_operator_pk" value="1">
        </div>

        <div class="form-group">
            <label for="operator_sound_pk">Operator Sound:</label>
            <input type="text" class="form-control" name="operator_sound_pk">
        </div>

        <div class="form-group">
            <label for="operator_live_pk">Operator Live:</label>
            <input type="text" class="form-control" name="operator_live_pk">
        </div>

        <div class="form-group">
            <label for="surat_peminjaman_pk">Surat Peminjaman:</label>
            <input type="file" class="form-control" name="surat_peminjaman_pk">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
    </form>
</div>
@endsection
