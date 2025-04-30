@extends('layout.kaunit_main')
@section('title', 'Persetujuan Usulan Perbaikan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM PERSETUJUAN USULAN PERBAIKAN</strong></div>
    <div class="card-body">
        <form action="/kaunit_usulan_perbaikan/save_validasi_perbaikan/{{ $perbaikan->id_usulan_perbaikan }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_staff" class="form-label">Nama Staff</label>
                <input type="text" class="form-control" id="nama_staff" value="{{ $perbaikan->staff->name ?? '' }}" readonly>
            </div>

            <div class="mb-3">
                <label for="kode_perlengkapan" class="form-label">Kode Perlengkapan</label>
                <input type="text" class="form-control" id="kode_perlengkapan" value="{{ $perbaikan->perlengkapan->kode_perlengkapan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="estimasi_harga_perbaikan" class="form-label">Estimasi Biaya</label>
                <input type="number" class="form-control" id="estimasi_harga_perbaikan" value="{{ $perbaikan->estimasi_harga_perbaikan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="alasan_perbaikan" class="form-label">Alasan Perbaikan</label>
                <textarea class="form-control" id="alasan_perbaikan" rows="2" readonly>{{ $perbaikan->alasan_perbaikan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="foto_perlengkapan" class="form-label">Foto Perlengkapan</label>
                @if ($perbaikan->foto_perbaikan)
                    <img src="{{ asset('storage/foto_perbaikan/' . $perbaikan->foto_perbaikan) }}" alt="Foto Perlengkapan" class="img-thumbnail" width="150">
                @else
                    <p>Tidak ada foto terlampir.</p>
                @endif
            </div>

            <div class="mb-3">
                <label for="status_usulan_perbaikan" class="form-label">Status Persetujuan</label>
                <select class="form-control" id="status_usulan_perbaikan" name="status_usulan_perbaikan">
                    <option value="diproses" {{ $perbaikan->status_usulan_perbaikan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="diterima" {{ $perbaikan->status_usulan_perbaikan == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $perbaikan->status_usulan_perbaikan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="catatan_perbaikan_kaunit" class="form-label">Catatan Kepala Unit (Opsional)</label>
                <textarea class="form-control" id="catatan_perbaikan_kaunit" name="catatan_perbaikan_kaunit" rows="2">{{ $perbaikan->catatan_perbaikan_kaunit }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Persetujuan</button>
            <a href="/kaunit_usulan_perbaikan" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection