@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')
@section('content')
<div class="container">

    <h4 class="mb-3">Daftar Pengembalian (Belum Dikembalikan)</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Induk</th>
                <th>Ruang</th>
                <th>Nama Kegiatan</th>
                <th>Jenis</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($belum_dikembalikan as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nomor_induk }}</td>
                <td>{{ $p->ruang->nama_ruang }}</td>
                <td>{{ $p->nama_kegiatan }}</td>
                <td>{{ ucfirst($p->jenis) }}</td>
                <td>{{ $p->jenis == 'peminjaman' ? $p->tanggal_mulai : $p->tanggal_gladi }}</td>
                <td>{{ $p->jenis == 'peminjaman' ? $p->tanggal_selesai : $p->tanggal_pengembalian_gladi }}</td>
                <td>{{ $p->status_pengembalian }}</td>
                <td>
                    @if($p->jenis == 'peminjaman')
                        <a href="/staff_pengembalian_ruang/form_pengembalian_ruang/{{ $p->id_peminjaman_ruang }}" class="btn btn-primary btn-sm">Proses</a>
                    @else
                        <a href="/staff_pengembalian_ruang/form_pengembalian_gladi/{{ $p->id_peminjaman_ruang }}" class="btn btn-warning btn-sm">Proses Gladi</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="mt-5 mb-3">Daftar Pengembalian (Sudah Dikembalikan)</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Induk</th>
                <th>Ruang</th>
                <th>Nama Kegiatan</th>
                <th>Jenis</th>
                <th>Tanggal Pengembalian</th>
                <th>Petugas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sudah_dikembalikan as $i => $p)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $p->nomor_induk }}</td>
                <td>{{ $p->ruang->nama_ruang }}</td>
                <td>{{ $p->nama_kegiatan }}</td>
                <td>{{ ucfirst($p->jenis) }}</td>
                <td>
                    {{ $p->jenis == 'peminjaman' ? $p->tanggal_pengembalian : $p->pengembalian_gladi_aktual }}
                </td>
                <td>
                    {{ $p->pjPengembalian->name ?? 'Belum tercatat' }}
                </td>
                <td>{{ $p->status_pengembalian }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
