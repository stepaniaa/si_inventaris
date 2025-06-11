@extends('layout.staff_main')
@section('title', 'Perbaikan - Edit Usulan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT USULAN PENGHAPUSAN</strong></div>
    <div class="card-body">
        <form action="/staff_usulan_penghapusan/update_penghapusan/{{ $phs->id_usulan_penghapusan }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>ID Usulan Penghapusan</label>
                <input type="number" class="form-control" value="{{ $phs->id_usulan_penghapusan }}" readonly>
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" class="form-control" value="{{ $phs->perlengkapan->nama_perlengkapan ?? '-' }}" readonly>
            </div>

            <div class="form-group">
                <label>Alasan Penghapusan</label>
                <input type="text" name="alasan_penghapusan" class="form-control" value="{{ old('alasan_penghapusan', $phs->alasan_penghapusan) }}">
            </div>

            <div class="form-group">
                <label>Foto Lama</label><br>
                @if($phs->foto_penghapusan)
                    <img src="{{ asset('storage/foto_penghapusan/' . $phs->foto_penghapusan) }}" width="120" alt="Foto Penghapusan">
                @else
                    <p class="text-muted">Tidak ada foto</p>
                @endif
            </div>

            <div class="form-group">
                <label>Ganti Foto (opsional)</label>
                <input type="file" name="foto_penghapusan" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/staff_usulan_penghapusan" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
