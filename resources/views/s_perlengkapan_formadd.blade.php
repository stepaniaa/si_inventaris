@extends('layout.staff_main')
@section('title', 'Perlengkapan - Add Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM TAMBAH DATA PERLENGKAPAN</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_perlengkapan/save_perlengkapan" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label>Kode Perlengkapan</label>
                <input type="text" name="kode_perlengkapan" class="form-control" placeholder="Masukkan kode perlengkapan">
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" name="nama_perlengkapan" class="form-control" placeholder="Masukkan nama perlengkapan">
            </div>

            <div class="form-group">
                <label>Kategori Perlengkapan</label>
                <input type="text" name="id_kategori" class="form-control" placeholder="Masukkan kategori perlengkapan">
            </div>

            <div class="form-group">
                <label>Lokasi Perlengkapan</label>
                <input type="text" name="id_ruang" class="form-control" placeholder="Masukkan lokasi perlengkapan">
            </div>

            <div class="form-group">
                <label>Stok Perlengkapan</label>
                <input type="text" name="stok_perlengkapan" class="form-control" placeholder="Masukkan stok perlengkapan">
            </div>

            <div class="form-group">
                <label>Harga Satuan Perlengkapan</label>
                <input type="text" name="harga_satuan_perlengkapan" class="form-control" placeholder="Masukkan harga satuan perlengkapan">
            </div>

            <div class="form-group">
                <label>Tanggal Beli Perlengkapan</label>
                <input type="date" name="tanggal_beli_perlengkapan" class="form-control" placeholder="Masukkan tanggal beli perlengkapan">
            </div>

            <div class="form-group">
                <label>Kondisi Perlengkapan</label>
                <input type="text" name="kondisi_perlengkapan" class="form-control" placeholder="Masukkan kondisi perlengkapan">
            </div>

            <div class="form-group">
                <label>Deskripsi Perlengkapan</label>
                <input type="text" name="deskripsi_perlengkapan" class="form-control" placeholder="Masukkan deskripsi perlengkapan">
            </div>

            <div class="form-group">
                <label>Foto Perlengkapan</label>
                <input type="image" name="foto_perlengkapan" class="form-control" placeholder="Masukkan tanggal beli perlengkapan">
            </div>

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection