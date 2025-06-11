@php
use Carbon\Carbon;
@endphp

@extends('layout.staff_main')
@section('title', 'Riwayat Peminjaman Kapel')

@section('content')
<div class="container">
    <h4 class="mb-3">Daftar Peminjaman (Belum Dikembalikan)</h4>
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
<div class="table-responsive"> 
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Kapel Dipinjam</th>
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
                <td>{{ $sesi->id_peminjaman_kapel }}</td>
                <td>{{ $sesi->peminjaman->ruang->nama_ruang }}</td>
                <td>{{ $sesi->peminjaman->nomor_induk }}</td>
                <!--<td>{{ $sesi->peminjaman->nama_peminjam }}</td>-->
                <td>{{ $sesi->peminjaman->nama_kegiatan }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</td>
                 <td>{{ $sesi->peminjaman->rutin ? 'Rutin' : 'Non-Rutin' }}</td>
                <td>{{ $sesi->status_sesi }}</td>
                 <td>
                      <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalDetailSesi{{ $sesi->id_sesi_kapel }}">Detail</button>
                </td>
                <td>
                     @if($sesi->status_pengembalian_kp === 'bermasalah')
                            <span class="badge badge-warning">Perlu Ditinjau</span>
                        @else
                            <span class="badge badge-primary">Belum Dikembalikan</span>
                        @endif
                </td>
                <td>
                    <a href="/staff_pengembalian_kapel/form_pengembalian_kapel/{{ $sesi->id_sesi_kapel }}" class="btn btn-primary btn-sm">Proses</a>
                </td>
                <td style="min-width: 250px;">
                    <!-- Tombol Batalkan hanya muncul jika status sesi masih aktif -->
                    @if($sesi->status_sesi === 'aktif')
                    <form action="/batalkan_sesi_kapel/{{$sesi->id_sesi_kapel }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan sesi ini?');">
                        @csrf
                        @method('PATCH')

                        <!-- Alasan Pembatalan -->
                       <div class="d-flex align-items-center gap-2"> <!-- UBAHAN -->
                            <!--<label for="alasan_dibatalkan" class="form-label">Alasan Pembatalan</label>-->
                            <input type="text" name="alasan_dibatalkan" class="form-control form-control-sm" placeholder="Alasan Pembatalan" required> <!-- UBAHAN -->
                        </div>

                        <button type="submit" class="btn btn-danger btn-sm">Batalkan</button>
                    </form>
                    @else
                    <span class="badge bg-secondary">Sesi Dibatalkan</span>
                    <p><strong>Alasan Pembatalan:</strong> {{ $sesi->alasan_dibatalkan }}</p>
                    @endif
                </td>
            </tr>

            <!-- Modal Detail -->
            <div class="modal fade" id="modalDetailSesi{{ $sesi->id_sesi_kapel }}" tabindex="-1" role="dialog" aria-labelledby="modalDetailSesiLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalDetailSesiLabel">Detail Peminjaman Kapel</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <p><strong>Nama Peminjam:</strong> {{ $sesi->peminjaman->nama_peminjam }}</p>
                                <p><strong>Nomor Induk:</strong> {{ $sesi->peminjaman->nomor_induk }}</p>
                                <p><strong>Asal Unit:</strong> {{ $sesi->peminjaman->asal_unit ?? '-' }}</p>
                                <p><strong>Peran:</strong> {{ $sesi->peminjaman->peran ?? '-' }}</p>
                                <p><strong>Kontak:</strong> {{ $sesi->peminjaman->kontak }}</p>
                                <p><strong>Email:</strong> {{ $sesi->peminjaman->email }}</p>
                                <p><strong>Nama Kegiatan:</strong> {{ $sesi->peminjaman->nama_kegiatan }}</p>
                                <p><strong>Keterangan Kegiatan:</strong> {{ $sesi->peminjaman->keterangan_kegiatan ?? '-' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $sesi->peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $sesi->peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
                                <p><strong>Rutin:</strong> {{ $sesi->peminjaman->rutin ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Tipe Rutin:</strong> {{ ucfirst($sesi->peminjaman->tipe_rutin) ?? '-' }}</p>
                                <p><strong>Jumlah Perulangan:</strong> {{ $sesi->peminjaman->jumlah_perulangan ?? '-' }}</p>
                                <p><strong>Butuh Livestream:</strong> {{ $sesi->peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Butuh Operator:</strong> {{ $sesi->peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Operator Sound:</strong> {{ $sesi->peminjaman->operator_sound ?? '-' }}</p>
                                <p><strong>Status Sesi:</strong> {{ $sesi->status_sesi }}</p>
                                <p><strong>Status Pengembalian:</strong> {{ $sesi->status_pengembalian }}</p>
                                <p><strong>Alasan Pembatalan:</strong> {{ $sesi->alasan_dibatalkan ?? '-' }}</p>
                                <p><strong>Divalidasi oleh:</strong> {{ $sesi->peminjaman->pjPengembalian->name ?? '-' }}</p>
                            </ul>
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
    @endif

    <h4 class="mt-5 mb-3">Daftar Peminjaman (Sudah Dikembalikan)</h4>
    @if($sudah_dikembalikan->isEmpty())
        <p>Belum ada peminjaman yang sudah dikembalikan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Peminjaman</th>
                <th>Kapel Dipinjam</th>
                <th>Nomor Induk</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jenis Peminjaman</th>
                <th>Catatan Pengembalian</th>
                <th>Tanggal Pengembalian</th>
                <th>Status Pengembalian</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sudah_dikembalikan as $i => $sesi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sesi->id_peminjaman_kapel }}</td>
                <td>{{ $sesi->peminjaman->ruang->nama_ruang }}</td>
                <td>{{ $sesi->peminjaman->nomor_induk }}</td>
                <!--<td>{{ $sesi->peminjaman->nama_peminjam }}</td>-->
                <td>{{ $sesi->peminjaman->nama_kegiatan }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $sesi->peminjaman->rutin ? 'Rutin' : 'Non-Rutin' }}</td>
                <td>{{$sesi->catatan_kp}}</td>
                <td>{{ Carbon::parse($sesi->tanggal_pengembalian_sesi)->format('Y-m-d H:i:s') ?? '-' }}</td>
                <td>
                    <span class="badge badge-success">Sudah Dikembalikan</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    <!-- Daftar Peminjaman yang Dibatalkan -->
    <h4 class="mt-5 mb-3">Daftar Peminjaman (Dibatalkan)</h4>
    @if($dibatalkan->isEmpty())
        <p>Belum ada peminjaman yang dibatalkan.</p>
    @else
    <table class="table table-bordered table-sm">
        <thead>
            <tr>
               <th>No</th>
                <th>ID Peminjaman</th>
                <th>Kapel Dipinjam</th>
                <th>Nomor Induk</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jenis Peminjaman</th>
                <th>Alasan Pembatalan</th>
                <th>Tanggal Pembatalan</th>
                <th>Status Sesi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dibatalkan as $i => $sesi)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $sesi->id_peminjaman_kapel }}</td>
                <td>{{ $sesi->peminjaman->ruang->nama_ruang }}</td>
                <td>{{ $sesi->peminjaman->nomor_induk }}</td>
                <!--<td>{{ $sesi->peminjaman->nama_peminjam }}</td>-->
                <td>{{ $sesi->peminjaman->nama_kegiatan }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i:s') }}</td>
                <td>{{ $sesi->peminjaman->rutin ? 'Rutin' : 'Non-Rutin' }}</td>
                <td>{{ $sesi->alasan_dibatalkan }}</td>
                <td>{{ Carbon::parse($sesi->updated_at)->format('Y-m-d H:i:s') }}</td>
                <td>
                    <span class="badge bg-secondary">Dibatalkan</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>
@endsection
