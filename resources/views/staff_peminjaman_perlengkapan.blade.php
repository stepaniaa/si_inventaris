@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')
@section('content')
<div class="container mt-4">
    <h2>Daftar Peminjaman Perlengkapan</h2>
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nomor Induk</th>
                <th>Nama Peminjam</th>
                <th>Kontak</th>
                <th>Email</th>
                <th>Perlengkapan</th>
                <th>Nama Kegiatan</th>
                <th>Keterangan Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Butuh Livestream</th>
                <th>Butuh Operator</th>
                <th>Catatan Peminjaman</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $p)
            <tr>
                <td>{{ $p->nomor_induk_pk }}</td>
                <td>{{ $p->nama_peminjam_pk }}</td>
                <td>{{ $p->kontak_pk }}</td>
                <td>{{ $p->email_pk }}</td>
                <td>
    <ul>
        @foreach($p->perlengkapan as $item)
            <li>{{ $item->nama_perlengkapan }}</li>
        @endforeach
    </ul>
</td>
                <td>{{ $p->nama_kegiatan_pk }}</td>
                <td>{{ $p->keterangan_kegiatan_pk }}</td>
                <td>{{ $p->sesi->first()->tanggal_mulai_sesi ?? '-' }}</td>
                <td>{{ $p->sesi->first()->tanggal_selesai_sesi ?? '-' }}</td>
                <td>{{ ucfirst($p->status_pk) }}</td> 
                <td>{{ $p->butuh_livestream_pk ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $p->butuh_operator_pk ? 'Ya' : 'Tidak' }}</td>
                <td>{{ $p->catatan_peminjaman_pk ?? '-' }}</td>
                <td>
                @if ($p->status_pk === 'diproses')
                        <a href="/staff_peminjaman_perlengkapan/form_validasi_peminjaman_perlengkapan/{{ $p->id_peminjaman_pkp }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
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