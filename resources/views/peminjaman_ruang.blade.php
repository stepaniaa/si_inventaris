@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Ruang ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container-fluid px-3 py-4">
    <div class="row">
        <div class="col-md-8 border rounded p-3 mb-3">
            <h4>Daftar Kapel</h4>
            @if (session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mt-2">
        {{ session('error') }}
    </div>
@endif
            <p class="mb-4">
                <i><b>Penting:</b> Periksa jadwal peminjaman yang akan datang untuk menghindari bentrok jadwal.</i>
            </p>
            <div class="row gx-4">
                @foreach ($ruang as $r)
                    <div class="col-md-12 mb-4"> <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $r->nama_ruang }}</h5>
                                <p class="card-text">
                                    Deskripsi : {{ $r->deskripsi_ruang }}<br>
                                    Kapasitas : {{ $r->kapasitas_ruang }}<br>
                                </p>
                                <a href="/peminjaman_ruang/peminjaman_ruang_formadd/{{ $r->id_ruang }}" class="btn btn-primary btn-sm">Tambah Peminjaman</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-4 border rounded p-3 mb-3">
    <h4>Peminjaman Yang Akan Datang</h4>
    @forelse ($jadwal as $j)
        <div class="card p-2 mb-2">
            <strong>{{ $j['ruang'] }}</strong> |
            {{ \Carbon\Carbon::parse($j['tanggal_mulai'])->format('d - M - Y') }} |
            {{ \Carbon\Carbon::parse($j['tanggal_mulai'])->format('H:i') }} -
            {{ \Carbon\Carbon::parse($j['tanggal_selesai'])->format('H:i') }}<br>
            {{ $j['nama_kegiatan'] }}
        </div>
    @empty
        <p>Belum ada peminjaman yang disetujui.</p>
    @endforelse>
</div>
    </div>
</div>
@endsection