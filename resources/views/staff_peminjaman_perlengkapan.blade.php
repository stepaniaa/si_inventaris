@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Perlengkapan')
@section('content')
<div class="container mt-4">
    <h3>Daftar Peminjaman Perlengkapan</h3>
    <br>

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

    <!-- Belum Divalidasi -->
    <h5>Daftar Pengajuan Peminjaman (Belum Divalidasi)</h5>
     @php use Carbon\Carbon; @endphp
@php
$conflictMap = [];
foreach ($belumDivalidasi as $p) {
    $tanggal = optional($p->sesi->first())->tanggal_mulai_sesi
        ? Carbon::parse($p->sesi->first()->tanggal_mulai_sesi)->format('Y-m-d')
        : null;
    $perlengkapanIds = $p->perlengkapan->pluck('id_perlengkapan')->sort()->implode(',');
    if ($tanggal && $perlengkapanIds) {
        $key = $perlengkapanIds . '|' . $tanggal;
        $conflictMap[$key] = ($conflictMap[$key] ?? 0) + 1;
    }
}
@endphp
@if(collect($conflictMap)->filter(fn($v) => $v > 1)->isNotEmpty())
<div class="alert alert-warning">
    ⚠️ <strong>Perhatian:</strong> Ada lebih dari satu pengajuan dengan perlengkapan dan tanggal yang sama. Mohon pertimbangkan urgensi sebelum validasi.
</div>
@endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Perlengkapan</th>
                    <th>Nomor Induk</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($belumDivalidasi as $index => $p)
                @php
    $tanggal = optional($p->sesi->first())->tanggal_mulai_sesi
        ? Carbon::parse($p->sesi->first()->tanggal_mulai_sesi)->format('Y-m-d')
        : null;
    $perlengkapanIds = $p->perlengkapan->pluck('id_perlengkapan')->sort()->implode(',');
    $key = $perlengkapanIds . '|' . $tanggal;
    $isConflict = isset($conflictMap[$key]) && $conflictMap[$key] > 1;
@endphp
<tr {!! isset($isConflict) && $isConflict ? 'class="table-warning" title="⚠️ Ada pengajuan lain dengan perlengkapan & tanggal yang sama!"' : '' !!}>

                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->id_peminjaman_pkp }}</td>
                                       <td>
                        <ul>
                            @foreach($p->perlengkapan as $item)
                                <li>{{ $item->nama_perlengkapan }}</li>
                            @endforeach
                        </ul>
@if(isset($isConflict) && $isConflict)
            <span class="text-danger" title="Konflik dengan peminjaman lain">⚠️</span>
        @endif
                    </td>
                    <td>{{ $p->nomor_induk_pk }}</td>
                     <!--td>{{ $p->nama_peminjam_pk }}</td>-->
                    <!--<td>{{ $p->kontak_pk }}</td>
                    <td>{{ $p->email_pk }}</td>-->
                    <td>{{ $p->nama_kegiatan_pk }}</td>
                    <!--<td>{{ $p->keterangan_kegiatan_pk ?? '-' }}</td>-->
                    <td>{{ $p->sesi->first()->tanggal_mulai_sesi ?? '-' }}</td>
                    <td>{{ $p->sesi->first()->tanggal_selesai_sesi ?? '-' }}</td>
                    <td>{{ ucfirst($p->status_pk) }}</td>
                   <!-- <td>{{ $p->butuh_livestream_pk ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $p->butuh_operator_pk ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $p->catatan_peminjaman_pk ?? '-' }}</td>-->
                   <td style="min-width: 280px;">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetail-{{ $p->id_peminjaman_pkp }}">
                            Lihat Detail
                        </button>
                        <a href="/staff_peminjaman_perlengkapan/form_validasi_peminjaman_perlengkapan/{{ $p->id_peminjaman_pkp }}" class="btn btn-warning btn-sm mt-1">Beri Persetujuan</a>
                    </td>
                </tr>
                <!-- Modal Detail -->
                <div class="modal fade" id="modalDetail-{{ $p->id_peminjaman_pkp }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $p->id_peminjaman_pkp }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Peminjaman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nomor Induk:</strong> {{ $p->nomor_induk_pk }}</p>
                                <p><strong>Nama:</strong> {{ $p->nama_peminjam_pk }}</p>
                                <p><strong>Kontak:</strong> {{ $p->kontak_pk }}</p>
                                <p><strong>Email:</strong> {{ $p->email_pk }}</p>
                                <p><strong>Perlengkapan:</strong>
                                    <ul>
                                        @foreach($p->perlengkapan as $item)
                                            <li>{{ $item->nama_perlengkapan }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                                <p><strong>Nama Kegiatan:</strong> {{ $p->nama_kegiatan_pk }}</p>
                                <p><strong>Lokasi Kegiatan:</strong> {{ $p->lokasi_kegiatan_pk }}</p>
                                <p><strong>Keterangan:</strong> {{ $p->keterangan_kegiatan_pk ?? '-' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $p->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $p->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($p->status_pk) }}</p>
                                <!--<p><strong>Butuh Livestream:</strong> {{ $p->butuh_livestream_pk ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Butuh Operator:</strong> {{ $p->butuh_operator_pk ? 'Ya' : 'Tidak' }}</p>-->
                                <p><strong>Catatan Persetujuan:</strong> {{ $peminjaman->catatan_persetujuan_pkp ?? '-' }}</p>
                                <p><strong>Divalidasi oleh:</strong> {{ $peminjaman->pjPeminjaman->name ?? '-' }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $belumDivalidasi->links() }}

    <!-- Sudah Divalidasi -->
    <h5 class="mt-5">Daftar Pengajuan Peminjaman (Sudah Divalidasi)</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                     <th>ID Peminjaman</th>
                    <th>Nomor Induk</th>
                    <th>Perlengkapan</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sudahDivalidasi as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->id_peminjaman_pkp }}</td>
                    <td>{{ $p->nomor_induk_pk }}</td>
                    <td>
                        <ul>
                            @foreach($p->perlengkapan as $item)
                                <li>{{ $item->nama_perlengkapan }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $p->nama_kegiatan_pk }}</td>
                    <td>{{ $p->sesi->first()->tanggal_mulai_sesi ?? '-' }}</td>
                    <td>{{ $p->sesi->first()->tanggal_selesai_sesi ?? '-' }}</td>
                    <td>{{ ucfirst($p->status_pk) }}</td>
                    <td>{{ $p->catatan_persetujuan_pkp  ?? '-' }}</td>
                    <td style="min-width: 280px;">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetail-{{ $p->id_peminjaman_pkp }}">
                            Lihat Detail
                        </button>
                        <button class="btn btn-secondary btn-sm mt-1" disabled>Sudah Divalidasi</button>
                    </td>
                </tr>
                <!-- Modal Detail -->
                <div class="modal fade" id="modalDetail-{{ $p->id_peminjaman_pkp }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel-{{ $p->id_peminjaman_pkp }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Peminjaman</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nomor Induk:</strong> {{ $p->nomor_induk_pk }}</p>
                                <p><strong>Nama:</strong> {{ $p->nama_peminjam_pk }}</p>
                                <p><strong>Kontak:</strong> {{ $p->kontak_pk }}</p>
                                <p><strong>Email:</strong> {{ $p->email_pk }}</p>
                                <p><strong>Perlengkapan:</strong>
                                    <ul>
                                        @foreach($p->perlengkapan as $item)
                                            <li>{{ $item->nama_perlengkapan }}</li>
                                        @endforeach
                                    </ul>
                                </p>
                                <p><strong>Nama Kegiatan:</strong> {{ $p->nama_kegiatan_pk }}</p>
                                 <p><strong>Lokasi Kegiatan:</strong> {{ $p->lokasi_kegiatan_pk }}</p>
                                <p><strong>Keterangan:</strong> {{ $p->keterangan_kegiatan_pk ?? '-' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $p->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $p->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($p->status_pk) }}</p>
                                <p><strong>Butuh Livestream:</strong> {{ $p->butuh_livestream_pk ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Butuh Operator:</strong> {{ $p->butuh_operator_pk ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Catatan Persetujuan:</strong> {{ $peminjaman->catatan_persetujuan_pkp ?? '-' }}</p>
                                <p><strong>Divalidasi oleh:</strong> {{ $peminjaman->pjPeminjaman->name ?? '-' }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $sudahDivalidasi->links() }}
</div>
@endsection
