@extends('layout.staff_main')
@section('title', 'Ruang - Add Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM TAMBAH DATA RUANG</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_ruang/save_ruang" method="POST">
            @csrf

            <div class="form-group">
                <label>Kode Ruang</label>
                <input type="text" name="kode_ruang" class="form-control" placeholder="Masukkan kode ruang">
            </div>

            <div class="form-group">
                <label>Nama Ruang</label>
                <input type="text" name="nama_ruang" class="form-control" placeholder="Masukkan nama ruang">
            </div>

            <div class="form-group">
                <label>Kapasitas Ruang</label>
                <input type="text" name="kapasitas_ruang" class="form-control" placeholder="Masukkan kapasitas ruang">
            </div>

            <div class="form-group">
                <label>Fasilitas Ruang</label>
                <input type="text" name="fasilitas_ruang" class="form-control" placeholder="Masukkan fasilitas ruang">
            </div>

            <div class="form-group">
                <label>Deskripsi Ruang</label>
                <input type="text" name="deskripsi_ruang" class="form-control" placeholder="Masukkan deskripsi ruang">
            </div>

            

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection