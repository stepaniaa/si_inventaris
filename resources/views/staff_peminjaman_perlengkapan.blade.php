@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')
@section('content')
<div class="container">
    <h2>Daftar Peminjaman Perlengkapan</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Nama Peminjam</th>
                <th>Perlengkapan</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Peminjaman</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $p)
            <tr>
                <td>{{ $p->nama_peminjam_pk }}</td>
                <td>{{ $p->perlengkapan->nama_perlengkapan }}</td>
                <td>{{ $p->nama_kegiatan_pk }}</td>
                <td>{{ $p->tanggal_mulai_pk }} - {{ $p->tanggal_selesai_pk }}</td>
                <td>{{ ucfirst($p->status_pk) }}</td>
                <td>
                <a href="/staff_peminjaman_perlengkapan/form_validasi_peminjaman_perlengkapan/{{ $p->id_peminjaman_perlengkapan }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $peminjamans->links() }}
</div>
@endsection