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
                <input type="text" name="kode_perlengkapan" class="form-control" placeholder="Masukkan kode perlengkapan" required>
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" name="nama_perlengkapan" class="form-control" placeholder="Masukkan nama perlengkapan" required>
            </div>

            <div class="form-group">
                <label>Kategori Perlengkapan</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="" disabled selected>Pilih kategori perlengkapan</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Lokasi Perlengkapan (Ruang)</label>
                <select name="id_ruang" class="form-control" required>
                    <option value="" disabled selected>Pilih lokasi ruang</option>
                    @foreach($ruang as $r)
                        <option value="{{ $r->id_ruang }}">{{ $r->nama_ruang }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Stok Perlengkapan</label>
                <input type="number" name="stok_perlengkapan" class="form-control" placeholder="Masukkan stok perlengkapan" required>
            </div>

            <div class="form-group">
                <label>Harga Satuan Perlengkapan</label>
                <input type="number" step="0.01" name="harga_satuan_perlengkapan" class="form-control" placeholder="Masukkan harga satuan perlengkapan" required>
            </div>

            <div class="form-group">
                <label>Tanggal Beli Perlengkapan</label>
                <input type="date" name="tanggal_beli_perlengkapan" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Kondisi Perlengkapan</label>
                <select class="form-control" name="kondisi_perlengkapan" required>
                    <option value="">Pilih Kondisi</option>
                    <option value="Baik">Baik</option>
                    <option value="Rusak">Rusak</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi Perlengkapan</label>
                <input type="text" name="deskripsi_perlengkapan" class="form-control" placeholder="Masukkan deskripsi perlengkapan">
            </div>

            <div class="form-group">
                <label>Foto Perlengkapan</label>
                <input type="file" name="foto_perlengkapan" class="form-control" accept="image/*">
            </div>

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection