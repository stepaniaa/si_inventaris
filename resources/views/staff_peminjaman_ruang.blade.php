@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')

@section('content')
<div class="container mt-4">
    <h2>Daftar Peminjaman Ruang</h2>

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
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Ruang</th>
                <th>Nama Peminjam</th>
                <th>Nomor Induk</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Nama Kegiatan</th>
                <th>Keterangan Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Kursi Tambahan</th>
                <th>Butuh Gladi</th>
                <th>Tanggal Gladi</th>
                <th>Tanggal Pengembalian Gladi</th>
                <th>Butuh Livestream</th>
                <th>Butuh Operator</th>
                <th>Operator Sound</th>
                <th>Status</th>
                <th>Catatan Staff</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($peminjamans as $index => $peminjaman)
            <tr>
                <td>{{ $index + $peminjamans->firstItem() }}</td>
                <td>{{ $peminjaman->ruang->nama_ruang ?? '-' }}</td>
                <td>{{ $peminjaman->nama_peminjam }}</td>
                <td>{{ $peminjaman->nomor_induk }}</td>
                <td>{{ $peminjaman->kontak }}</td>
                <td>{{ $peminjaman->email }}</td>
                <td>{{ $peminjaman->nama_kegiatan }}</td>
                <td>{{ $peminjaman->keterangan_kegiatan }}</td>
                <td>{{ $peminjaman->tanggal_mulai }}</td>
                <td>{{ $peminjaman->tanggal_selesai }}</td>
                <td>{{ $peminjaman->jumlah_kursi_tambahan ?? '-' }}</td>
                <td>{{ $peminjaman->butuh_gladi ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $peminjaman->tanggal_gladi ?? '-' }}</td>
                <td>{{ $peminjaman->tanggal_pengembalian_gladi ?? '-' }}</td>
                <td>{{ $peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $peminjaman->operator_sound ?? '-' }}</td>
                <td>{{ ucfirst($peminjaman->status) }}</td>
                <td>{{ $peminjaman->catatan_staff ?? '-' }}</td>
                <td>
                @if ($peminjaman->status === 'diproses')
                        <a href="/staff_peminjaman_ruang/form_validasi_peminjaman_ruang/{{ $peminjaman->id_peminjaman_ruang }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                    @else
                        <button class="btn btn-secondary btn-sm" disabled>Sudah Divalidasi</button>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
    {{ $peminjamans->links() }}
</div>
@endsection
