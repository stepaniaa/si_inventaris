@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')
@section('content')
<div class="container">

    <h4 class="mb-3">Daftar Pengembalian (Belum Dikembalikan)</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
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
                <td>{{ $p->id_peminjaman_ruang }}</td>
                <td>{{ $p->nomor_induk }}</td>
                <td>{{ $p->ruang->nama_ruang }}</td>
                <td>{{ $p->nama_kegiatan }}</td>
                <td>{{ ucfirst($p->jenis) }}</td>
                <td>{{ $p->tanggal_mulai }}</td>
                <td>{{ $p->tanggal_selesai }}</td>
                <td>{{ $p->status_pengembalian }}</td>
                <td>
                    @if($p->jenis == 'rutin')
                        <form action="/staff_pengembalian_ruang/update_status_rutin/{{ $p->peminjaman_rutin_id }}_{{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('Y-m-d') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <select name="status_rutin" class="form-control form-control-sm" onchange="this.form.submit()">
                                    <option value="aktif" {{ $p->status_sesi_rutin == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="selesai" {{ $p->status_sesi_rutin == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="masalah" {{ $p->status_sesi_rutin == 'masalah' ? 'selected' : '' }}>Masalah</option>
                                </select>
                            </div>
                        </form>
                    @elseif ($p->jenis == 'peminjaman')
                        <a href="/staff_pengembalian_ruang/form_pengembalian_ruang/{{ $p->id_peminjaman_ruang }}" class="btn btn-primary btn-sm">Proses</a>
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
                <th>ID Peminjaman</th>
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
                <td>{{ $p->id_peminjaman_ruang }}</td>
                <td>{{ $p->nomor_induk }}</td>
                <td>{{ $p->ruang->nama_ruang }}</td>
                <td>{{ $p->nama_kegiatan }}</td>
                <td>{{ ucfirst($p->jenis) }}</td>
                <td>
                    @if ($p->jenis == 'rutin')
                        {{ $p->tanggal_selesai }}
                    @else
                        {{ $p->tanggal_pengembalian ?? $p->pengembalian_gladi_aktual }}
                    @endif
                </td>
                <td>
                    {{ $p->pjPengembalian->name ?? 'Belum tercatat' }}
                </td>
                <td>
                    @if ($p->jenis == 'rutin')
                        <span class="badge badge-{{ $p->status_sesi_rutin == 'aktif' ? 'info' : ($p->status_sesi_rutin == 'selesai' ? 'success' : 'warning') }}">
                            {{ ucfirst($p->status_sesi_rutin ?? 'aktif') }}
                        </span>
                    @else
                        {{ $p->status_pengembalian }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection