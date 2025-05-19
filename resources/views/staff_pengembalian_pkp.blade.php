@php
use Carbon\Carbon;
@endphp

@extends('layout.staff_main')
@section('title', 'Daftar Pengembalian Peminjaman Perlengkapan')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Pengembalian (Belum Dikembalikan)</h4>
    @if($belum_dikembalikan->isEmpty())
        <p>Semua peminjaman sudah dikembalikan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Jenis Peminjaman</th> {{-- MODIFIKASI: tambah kolom jenis --}}
                <th>Nomor Induk</th>
                <th>Nama Peminjam</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status Sesi</th>
                <th>Tanggal Pengembalian</th> <!-- Kolom baru -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($belum_dikembalikan as $i => $sesi)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $sesi->id_peminjaman_pkp }}</td>
    <td>{{ $sesi->peminjaman->rutin ? 'Rutin' : 'Non-Rutin' }}</td>
    <td>{{ $sesi->peminjaman->nomor_induk_pk }}</td>
    <td>{{ $sesi->peminjaman->nama_peminjam_pk }}</td>
    <td>{{ $sesi->peminjaman->nama_kegiatan_pk }}</td>
    <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }}</td>
    <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</td>
    <td>
        <span class="badge badge-warning">Belum Dikembalikan</span>
    </td>
    <td>
        {{ $sesi->tanggal_pengembalian_sesi ? Carbon::parse($sesi->tanggal_pengembalian_sesi)->format('d-M-Y H:i') : '-' }}
    </td>
    <td>
        <a href="/staff_pengembalian_pkp/form_pengembalian_pkp/{{ $sesi->id_sesi_pkp }}" class="btn btn-primary btn-sm">Proses</a>
    </td>
</tr>
@endforeach
        </tbody>
    </table>
    @endif

    <h4 class="mt-5 mb-3">Daftar Pengembalian (Sudah Dikembalikan)</h4>
    @if($sudah_dikembalikan->isEmpty())
        <p>Belum ada peminjaman yang sudah dikembalikan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Nomor Induk</th>
                <th>Nama Peminjam</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Pengembalian</th>
                <th>Status Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sudah_dikembalikan as $i => $sesi)
<tr>
    <td>{{ $i+1 }}</td>
    <td>{{ $sesi->id_peminjaman_pkp }}</td>
    <td>{{ $sesi->peminjaman->nomor_induk_pk }}</td>
    <td>{{ $sesi->peminjaman->nama_peminjam_pk }}</td>
    <td>{{ $sesi->peminjaman->nama_kegiatan_pk }}</td>
    <td>{{ Carbon::parse($sesi->tanggal_pengembalian_sesi)->format('Y-m-d H:i:s') ?? '-' }}</td>
    <td>
        <span class="badge badge-success">Sudah Dikembalikan</span>
    </td>
</tr>
@endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
