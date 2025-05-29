@extends('layout.staff_main')
@section('title', 'Ruang - Edit Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT RUANG</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_ruang/update_ruang/{{$rng->id_ruang}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Id Ruang</label>
                <input type="number" name="id_ruang" class="form-control" value="{{$rng->id_ruang}}"readonly>
            </div>
            <div class="form-group">
                <label>Nama Ruang</label>
                <input type="text" name="nama_ruang" class="form-control" value="{{$rng->nama_ruang}}">
            </div>
            <div class="form-group">
                <label>Kapasitas Ruang</label>
                <input type="text" name="kapasitas_ruang" class="form-control" value="{{$rng->kapasitas_ruang}}">
            </div>
            <div class="form-group">
                <label>Fasilitas Ruang</label>
                <input type="text" name="fasilitas_ruang" class="form-control" value="{{$rng->fasilitas_ruang}}">
            </div>

            <div class="form-group">
    <label for="lokasi_ruang">Lokasi Ruang</label>
    <input type="text" name="lokasi_ruang" class="form-control" value="{{ $rng->lokasi_ruang }}">
</div>
            <div class="form-group">
                <label>Deskripsi Ruang</label>
                <input type="text" name="deskripsi_ruang" class="form-control" value="{{$rng->deskripsi_ruang}}">
            </div>

            <div class="form-group">
    <label for="bisa_dipinjam">Bisa Dipinjam</label>
    <select name="bisa_dipinjam" class="form-control">
        <option value="ya" {{ $rng->bisa_dipinjam == 'ya' ? 'selected' : '' }}>Ya</option>
        <option value="tidak" {{ $rng->bisa_dipinjam == 'tidak' ? 'selected' : '' }}>Tidak</option>
    </select>
</div>
            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection