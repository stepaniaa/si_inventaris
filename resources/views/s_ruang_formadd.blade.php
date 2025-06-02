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
                <label for="lokasi_ruang">Lokasi Ruang</label>
                <input type="text" name="lokasi_ruang" class="form-control" placeholder="Contoh: Lantai 2 Gedung Chara">
            </div>

            <div class="form-group">
                <label>Fasilitas Ruang</label>
                <input type="text" name="fasilitas_ruang" class="form-control" placeholder="Masukkan fasilitas ruang">
            </div>

            <div class="form-group">
                <label>Deskripsi Ruang</label>
                <input type="text" name="deskripsi_ruang" class="form-control" placeholder="Masukkan deskripsi ruang">
            </div>

            <div class="form-group">
                <label for="bisa_dipinjam">Perlu pengajuan peminjaman ? </label>
                <select name="bisa_dipinjam" class="form-control" required>
                <option value="ya">Ya</option>
                <option value="tidak">Tidak</option>
                </select>
            </div>


            

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection