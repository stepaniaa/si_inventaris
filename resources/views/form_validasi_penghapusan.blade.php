@extends('layout.kaunit_main')
@section('title', 'Persetujuan Usulan Penghapusan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM PERSETUJUAN USULAN PENGHAPUSAN</strong></div>
    <div class="card-body">
        <form action="/kaunit_usulan_penghapusan/save_validasi_penghapusan/{{ $penghapusan->id_usulan_penghapusan }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_staff" class="form-label">Nama Staff</label>
                <input type="text" class="form-control" id="nama_staff" value="{{ $penghapusan->staff->name ?? '' }}" readonly>
            </div>

            <div class="mb-3">
                <label for="kode_perlengkapan" class="form-label">Kode Perlengkapan</label>
                <input type="text" class="form-control" id="kode_perlengkapan" value="{{ $penghapusan->perlengkapan->kode_perlengkapan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="alasan_penghapusan" class="form-label">Alasan Penghapusan</label>
                <textarea class="form-control" id="alasan_penghapusan" rows="2" readonly>{{ $penghapusan->alasan_penghapusan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="foto_perlengkapan" class="form-label">Foto Perlengkapan</label>
                @if ($penghapusan->foto_penghapusan)
                    <img src="{{ asset('storage/foto_penghapusan/' . $penghapusan->foto_penghapusan) }}" alt="Foto Perlengkapan" class="img-thumbnail" width="150">
                @else
                    <p>Tidak ada foto terlampir.</p>
                @endif
            </div>

            <div class="mb-3">
                <label for="status_usulan_penghapusan" class="form-label">Status Persetujuan</label>
                <select class="form-control" id="status_usulan_penghapusan" name="status_usulan_penghapusan">
                    <option value="diproses" {{ $penghapusan->status_usulan_penghapusan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="diterima" {{ $penghapusan->status_usulan_penghapusan == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $penghapusan->status_usulan_penghapusan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="catatan_penghapusan_kaunit" class="form-label">Catatan Kepala Unit (Opsional)</label>
                <textarea class="form-control" id="catatan_penghapusan_kaunit" name="catatan_penghapusan_kaunit" rows="2">{{ $penghapusan->catatan_penghapusan_kaunit }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Persetujuan</button>
            <a href="/kaunit_usulan_penghapusan" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection