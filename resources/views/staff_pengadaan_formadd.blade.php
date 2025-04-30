@extends('layout.staff_main')
@section('title', 'Usulan Pengadaan - Add Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM TAMBAH DATA PENGADAAN</strong></div>
    <div class="card-body">
        <form action="/staff_usulan_pengadaan/save_pengadaan" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" name="nama_perlengkapan_pengadaan" class="form-control" placeholder="Masukkan perlengkapan yang anda usulkan">
            </div>

            <div class="form-group">
                <label>Jumlah perlengkapan</label>
                <input type="number" name="jumlah_usulan_pengadaan" class="form-control" placeholder="Masukkan jumlah perlengkapan">
            </div>

            <div class="form-group">
                <label>Alasan usul pengadaan</label>
                <input type="text" name="alasan_pengadaan" class="form-control" placeholder="Masukkan alasan pengadaan">
            </div>

            <div class="form-group">
                <label>Estimasi Harga</label>
                <input type="number" name="estimasi_harga" class="form-control" placeholder="Masukkan estimasi harga">
            </div>

            <!--<div class="form-group">
                <label>Tanggal pengusulan</label>
                <input type="datetime-local" name="tanggal_usulan_pengadaan" class="form-control" placeholder="Masukkan tanggal saat ini">
            </div>-->

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection