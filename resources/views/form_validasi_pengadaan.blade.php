@extends('layout.kaunit_main')
@section('title', 'Persetujuan Usulan Pengadaan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM PERSETUJUAN USULAN PENGADAAN</strong></div>
    <div class="card-body">
        <form action="/kaunit_usulan_pengadaan/save_validasi_pengadaan/{{ $pengadaan->id_usulan_pengadaan }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
    <label for="nama_staff" class="form-label">Nama Staff</label>
    <input type="text" class="form-control" id="nama_staff" value="{{ $pengadaan->staff->name ?? '' }}" readonly>
</div>

            <div class="mb-3">
                <label for="nama_perlengkapan" class="form-label">Nama Perlengkapan</label>
                <input type="text" class="form-control" id="nama_perlengkapan" value="{{ $pengadaan->nama_perlengkapan_pengadaan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah</label>
                <input type="number" class="form-control" id="jumlah" value="{{ $pengadaan->jumlah_usulan_pengadaan }}" readonly>
            </div>

            <div class="mb-3">
                <label for="alasan" class="form-label">Alasan Pengadaan</label>
                <textarea class="form-control" id="alasan" rows="3" readonly>{{ $pengadaan->alasan_pengadaan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="status_usulan_pengadaan" class="form-label">Status Persetujuan</label>
                <select class="form-control" id="status_usulan_pengadaan" name="status_usulan_pengadaan">
                    <option value="diproses" {{ $pengadaan->status_usulan_pengadaan == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="diterima" {{ $pengadaan->status_usulan_pengadaan == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="ditolak" {{ $pengadaan->status_usulan_pengadaan == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="catatan_pengadaan_kaunit" class="form-label">Catatan Kepala Unit (Opsional)</label>
                <textarea class="form-control" id="catatan_pengadaan_kaunit" name="catatan_pengadaan_kaunit" rows="3">{{ $pengadaan->catatan_pengadaan_kaunit }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Persetujuan</button>
            <a href="/kaunit_usulan_pengadaan" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection