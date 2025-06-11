@php
use Carbon\Carbon;
@endphp

@extends('layout.staff_main')
@section('title', 'Form Pengembalian Peminjaman')

@section('content')
<div class="container mt-4">
    <h3>Pengembalian Peminjaman: {{ $peminjaman->peminjaman->nama_kegiatan_pk }}</h3>
    <p>Peminjam: {{ $peminjaman->peminjaman->nama_peminjam_pk }}</p>

    <div class="card mb-3 p-3">
        <strong>Sesi: {{ Carbon::parse($peminjaman->tanggal_mulai_sesi)->format('d M Y') }} - {{ Carbon::parse($peminjaman->tanggal_selesai_sesi)->format('d M Y') }}</strong><br>
        <form action="/staff_pengembalian_pkp/update_status_pengembalian_pkp/{{ $peminjaman->id_sesi_pkp }}" method="POST">
            @csrf
            @method('PUT')
<div class="form-group">
                <label for="catatan" class="mt-2">Catatan Pengembalian (opsional):</label>
                <textarea name="catatan" class="form-control" rows="3">{{ $peminjaman->catatan }}</textarea>
     </div>
<div class="form-group">
            <label>Status Pengembalian:</label>
           <select name="status_pengembalian" class="form-control">
                <option value="belum" {{ $peminjaman->status_pengembalian == 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="sudah" {{ $peminjaman->status_pengembalian == 'sudah' ? 'selected' : '' }}>Sudah</option>
                <option value="bermasalah" {{ $peminjaman->status_pengembalian == 'bermasalah' ? 'selected' : '' }}>Bermasalah</option>
            </select>
              </div>
            @if($peminjaman->status_pengembalian == 'sudah')
                <small class="text-success">Dikembalikan pada {{ Carbon::parse($peminjaman->tanggal_pengembalian_sesi)->format('Y-m-d H:i:s') }}</small>
            @elseif($peminjaman->status_pengembalian == 'bermasalah')
                <small class="text-danger">Perlu ditinjau</small>
            @endif
                <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
        </form>
    </div>
</div>
@endsection
