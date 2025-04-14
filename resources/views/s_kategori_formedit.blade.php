@extends('layout.staff_main')
@section('title', 'Kategori - Edit Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT KATEGORI</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_kategori/update_kategori/{{$ktg->id_kategori}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Id Kategori</label>
                <input type="number" name="id_kategori" class="form-control" value="{{$ktg->id_kategori}}"readonly>
            </div>
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" value="{{$ktg->nama_kategori}}">
            </div>
            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection