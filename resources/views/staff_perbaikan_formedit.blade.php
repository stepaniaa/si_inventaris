@extends('layout.staff_main')
@section('title', 'Perbaikan - Edit Usulan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT USULAN PERBAIKAN</strong></div>
    <div class="card-body">
        <form action="/staff_usulan_perbaikan/update_perbaikan/{{ $prb->id_usulan_perbaikan }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>ID Usulan Perbaikan</label>
                <input type="number" class="form-control" value="{{ $prb->id_usulan_perbaikan }}" readonly>
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" class="form-control" value="{{ $prb->perlengkapan->nama_perlengkapan ?? '-' }}" readonly>
            </div>

            <div class="form-group">
                <label>Alasan Perbaikan</label>
                <input type="text" name="alasan_perbaikan" class="form-control" value="{{ old('alasan_perbaikan', $prb->alasan_perbaikan) }}">
            </div>

            <div class="form-group">
                <label>Estimasi Harga</label>
                <input type="number" name="estimasi_harga_perbaikan" class="form-control" value="{{ old('estimasi_harga_perbaikan', $prb->estimasi_harga_perbaikan) }}">
            </div>

            <div class="form-group">
                <label>Foto Lama</label><br>
                @if($prb->foto_perbaikan)
                    <img src="{{ asset('storage/foto_perbaikan/' . $prb->foto_perbaikan) }}" width="120" alt="Foto Perbaikan">
                @else
                    <p class="text-muted">Tidak ada foto</p>
                @endif
            </div>

            <div class="form-group">
                <label>Ganti Foto (opsional)</label>
                <input type="file" name="foto_perbaikan" class="form-control">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto.</small>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="/staff_usulan_perbaikan" class="btn btn-secondary">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection
