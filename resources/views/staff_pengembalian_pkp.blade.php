@php
use Carbon\Carbon;
@endphp

@extends('layout.staff_main')
@section('title', 'Daftar Pengembalian Peminjaman Perlengkapan')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Pengembalian (Belum Dikembalikan)</h4>
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
    @if($belum_dikembalikan->isEmpty())
        <p>Semua peminjaman sudah dikembalikan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Perlengkapan Dipinjam</th>
                <th>Nomor Induk</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jenis Peminjaman</th>
                <th>Status Sesi</th>
                <th>Detail Peminjaman</th>
                <th>Status Pengembalian</th>
                <th>Proses Pengembalian</th>
                <th>Batalkan Peminjaman</th>
            </tr>
        </thead>
        <tbody>
            @foreach($belum_dikembalikan as $i => $sesi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sesi->id_peminjaman_pkp }}</td>
                <td>
     @if($sesi->peminjaman->perlengkapan && $sesi->peminjaman->perlengkapan->count())
        <ul class="mb-0 ps-3">
            @foreach($sesi->peminjaman->perlengkapan as $item)
                <li>{{ $item->nama_perlengkapan }}</li>
            @endforeach
        </ul>
    @else
        <span class="text-muted">Tidak ada</span>
    @endif
</td>
                <td>{{ $sesi->peminjaman->nomor_induk_pk }}</td>
                <td>{{ $sesi->peminjaman->nama_kegiatan_pk }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $sesi->peminjaman->rutin ? 'Rutin' : 'Non-Rutin' }}</td>
                <td>{{ $sesi->status_sesi }}</td>
                <td><p>-</p></td>
                <td>
                    <span class="badge badge-warning">Belum Dikembalikan</span>
                </td>
                <!--<td>
                    {{ $sesi->tanggal_pengembalian_sesi ? Carbon::parse($sesi->tanggal_pengembalian_sesi)->format('d-M-Y H:i') : '-' }}
                </td>-->
                <td>
                    <a href="/staff_pengembalian_pkp/form_pengembalian_pkp/{{ $sesi->id_sesi_pkp }}" class="btn btn-primary btn-sm">Proses</a>
                </td>
                <td>
                    <!-- Tombol Batalkan hanya muncul jika status sesi masih aktif -->
                    @if($sesi->status_sesi === 'aktif')
                        <form action="/batalkan_sesi_pkp/{{ $sesi->id_sesi_pkp }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan sesi ini?');">
                            @csrf
                            @method('PATCH')

                            <!-- Alasan Pembatalan -->
                            <div class="mb-2">
                                <label for="alasan_dibatalkan" class="form-label">Alasan Pembatalan</label>
                                <input type="text" name="alasan_dibatalkan" class="form-control form-control-sm" required>
                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                        </form>
                    @else
                        <span class="badge bg-secondary">Sesi Dibatalkan</span>
                        <p><strong>Alasan Pembatalan:</strong> {{ $sesi->alasan_dibatalkan }}</p>
                    @endif
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
                 <th>Catatan</th>
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
                <td>{{ $sesi->catatan }}</td>
                <td>
                    <span class="badge badge-success">Sudah Dikembalikan</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <h4 class="mt-5 mb-3">Daftar Pengembalian (Dibatalkan)</h4>
    @if($dibatalkan->isEmpty())
        <p>Belum ada peminjaman yang dibatalkan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Nomor Induk</th>
                <th>Nama Peminjam</th>
                <th>Nama Kegiatan</th>
                <th>Alasan Pembatalan</th>
                <th>Status Sesi</th>
                <th>Tanggal Pembatalan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dibatalkan as $i => $sesi)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $sesi->id_peminjaman_pkp }}</td>
                <td>{{ $sesi->peminjaman->nomor_induk_pk }}</td>
                <td>{{ $sesi->peminjaman->nama_peminjam_pk }}</td>
                <td>{{ $sesi->peminjaman->nama_kegiatan_pk }}</td>
                <td>{{ $sesi->alasan_dibatalkan }}</td>
                <td>
                    <span class="badge bg-secondary">Dibatalkan</span>
                </td>
                <td>{{ Carbon::parse($sesi->updated_at)->format('Y-m-d H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
