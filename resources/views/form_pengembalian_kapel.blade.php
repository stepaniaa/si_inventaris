@php
use Carbon\Carbon;
@endphp

@extends('layout.staff_main')
@section('title', 'Form Pengembalian Peminjaman Kapel')

@section('content')
<div class="container mt-4">
    <h3>Pengembalian Peminjaman: {{ $peminjaman->peminjaman->nama_kegiatan }}</h3>
    <p>Peminjam: {{ $peminjaman->peminjaman->nama_peminjam }}</p>

    <div class="card mb-3 p-3">
        <strong>Sesi: {{ Carbon::parse($peminjaman->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }} - {{ Carbon::parse($peminjaman->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</strong><br>
        <form action="/staff_pengembalian_kapel/update_status_pengembalian_kapel/{{ $peminjaman->id_sesi_kapel }}" method="POST">
            @csrf
            @method('PUT')

            <label>Status Pengembalian:</label>
            <select name="status_pengembalian_kp" onchange="this.form.submit()">
                <option value="belum" {{ $peminjaman->status_pengembalian_kp == 'belum' ? 'selected' : '' }}>Belum</option>
                <option value="sudah" {{ $peminjaman->status_pengembalian_kp == 'sudah' ? 'selected' : '' }}>Sudah</option>
                <option value="bermasalah" {{ $peminjaman->status_pengembalian_kp == 'bermasalah' ? 'selected' : '' }}>Bermasalah</option>
            </select>

            @if($peminjaman->status_pengembalian_kp == 'sudah')
                <small class="text-success">Dikembalikan pada {{ Carbon::parse($peminjaman->tanggal_pengembalian_sesi_kp)->format('Y-m-d H:i:s') }}</small>
            @elseif($peminjaman->status_pengembalian_kp == 'bermasalah')
                <small class="text-danger">Perlu tindak lanjut</small>
            @endif
        </form>
    </div>

    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
