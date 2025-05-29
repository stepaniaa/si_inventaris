@extends('layout.staff_main')
@section('title', 'Kategori - Add Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM TAMBAH DATA KATEGORI</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_kategori/save_kategori" method="POST">
            @csrf
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan nama kategori">
            </div>

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection