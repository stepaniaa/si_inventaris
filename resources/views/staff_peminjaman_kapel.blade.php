@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Kapel')

@section('content')
<div class="container mt-4">
    <h3>Daftar Peminjaman Kapel</h3>
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

    <!-- Tabel untuk Peminjaman yang Belum Divalidasi (status pengajuan 'proses') -->
    <h5>Daftar Pengajuan Peminjaman (Belum Divalidasi)</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Nama Ruang</th>
                    <th>Nomor Induk</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jenis Peminjaman</th>
                    <th>Status Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($belumDivalidasi as $index => $peminjaman)
                <tr>
                    <!-- Menggunakan firstItem() untuk penomoran yang benar -->
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->id_peminjaman_kapel }}</td>
                    <td>{{ $peminjaman->ruang->nama_ruang }}</td>
                    <td>{{ $peminjaman->nomor_induk }}</td>
                    <td>{{ $peminjaman->nama_kegiatan }}</td>
                    <td>{{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</td>
                    <td>{{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</td>
                    <td> {{ $peminjaman->rutin ? 'Rutin' : 'Tidak Rutin' }}</td>
                    <td>{{ ucfirst($peminjaman->status_pengajuan) }}</td>
                    <td style="min-width: 280px;">
                        <div class="d-flex gap-2">
                        <!-- Lihat Detail Button -->
                        <button type="button"  style="margin-right: 10px;" class="btn btn-info btn-sm me-2" data-toggle="modal" data-target="#detailModal-{{ $peminjaman->id_peminjaman_kapel }}">
                           Detail
                        </button>

                        @if ($peminjaman->status_pengajuan === 'proses')
                        <a href="{{ url('/staff_peminjaman_kapel/form_validasi_peminjaman_kapel/'.$peminjaman->id_peminjaman_kapel) }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                        @else
                        <button class="btn btn-secondary btn-sm" disabled>Sudah Divalidasi</button>
                        @endif
    </div>
                    </td>
                   
                </tr>

                <!-- Modal Detail Peminjaman -->
                <div class="modal fade" id="detailModal-{{ $peminjaman->id_peminjaman_kapel }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $peminjaman->id_peminjaman_kapel }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel-{{ $peminjaman->id_peminjaman_kapel }}">Detail Peminjaman ID : {{ $peminjaman->id_peminjaman_kapel }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                                <p><strong>Nomor Induk:</strong> {{ $peminjaman->nomor_induk }}</p>
                                <p><strong>Asal Unit:</strong> {{ $peminjaman->asal_unit ?? '-' }}</p>
                                <p><strong>Peran:</strong> {{ $peminjaman->peran ?? '-' }}</p>
                                <p><strong>Kontak:</strong> {{ $peminjaman->kontak }}</p>
                                <p><strong>Email:</strong> {{ $peminjaman->email }}</p><br>
                                <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</p>
                                <p><strong>Keterangan Kegiatan:</strong> {{ $peminjaman->keterangan_kegiatan ?? '-' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
                                <p><strong>Rutin:</strong> {{ $peminjaman->rutin ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Tipe Rutin:</strong> {{ ucfirst($peminjaman->tipe_rutin) ?? '-' }}</p>
                                <p><strong>Jumlah Perulangan:</strong> {{ $peminjaman->jumlah_perulangan ?? '-' }}</p>
                                <p><strong>Butuh Livestream:</strong> {{ $peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Butuh Operator:</strong> {{ $peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Operator Sound:</strong> {{ $peminjaman->operator_sound ?? '-' }}</p>
                                <p><strong>Status Pengajuan:</strong> {{ ucfirst($peminjaman->status_pengajuan) }}</p>
                                <p><strong>Status Pengajuan:</strong> {{ ucfirst($peminjaman->status_pengajuan) }}</p>
                                    {{-- Tambahan untuk file-file --}}
                                    @if ($peminjaman->surat_peminjaman)
                                        <p><strong>Surat Peminjaman:</strong>
                                            <a href="{{ asset('storage/surat_peminjaman/' . $peminjaman->surat_peminjaman) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat File
                                            </a>
                                        </p>
                                    @endif

                                    @if ($peminjaman->bukti_ukdw)
                                        <p><strong>Bukti UKDW:</strong>
                                            <a href="{{ asset('storage/bukti_ukdw/' . $peminjaman->bukti_ukdw) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat Bukti
                                            </a>
                                        </p>
                                    @endif
                                <!--<p><strong>Catatan Persetujuan:</strong> {{ $peminjaman->catatan_persetujuan_kapel ?? '-' }}</p>-->
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
    <br>

    <!-- Tabel untuk Peminjaman yang Sudah Divalidasi (status pengajuan 'diterima' dan 'ditolak') -->
    <h5>Daftar Pengajuan Peminjaman (Sudah Divalidasi)</h5>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Nama Ruang</th>
                    <th>Nomor Induk</th>
                    <th>Nama Kegiatan</th>
                    <th>Tanggal Mulai</th>
                     <th>Tanggal Selesai</th>
                    <th>Status Pengajuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sudahDivalidasi as $index => $peminjaman)
                <tr>
                    <!-- Menggunakan firstItem() untuk penomoran yang benar -->
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $peminjaman->id_peminjaman_kapel }}</td>
                    <td>{{ $peminjaman->ruang->nama_ruang }}</td>
                    <td>{{ $peminjaman->nomor_induk }}</td>
                    <td>{{ $peminjaman->nama_kegiatan }}</td>
                    <td>{{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</td>
                    <td>{{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</td>
                    <td>{{ ucfirst($peminjaman->status_pengajuan) }}</td>
                    <td style="min-width: 280px;">
                        <!-- Lihat Detail Button -->
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal-{{ $peminjaman->id_peminjaman_kapel }}">
                            Detail
                        </button>
                        <button class="btn btn-secondary btn-sm" disabled>Sudah Divalidasi</button>
                    </td>
                </tr>

                <!-- Modal Detail Peminjaman -->
                <div class="modal fade" id="detailModal-{{ $peminjaman->id_peminjaman_kapel }}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel-{{ $peminjaman->id_peminjaman_kapel }}" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="detailModalLabel-{{ $peminjaman->id_peminjaman_kapel }}">Detail Peminjaman ID : {{ $peminjaman->id_peminjaman_kapel }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</p>
                                <p><strong>Nomor Induk:</strong> {{ $peminjaman->nomor_induk }}</p>
                                <p><strong>Asal Unit:</strong> {{ $peminjaman->asal_unit ?? '-' }}</p>
                                <p><strong>Peran:</strong> {{ $peminjaman->peran ?? '-' }}</p>
                                <p><strong>Kontak:</strong> {{ $peminjaman->kontak }}</p>
                                <p><strong>Email:</strong> {{ $peminjaman->email }}</p>
                                <p><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</p>
                                <p><strong>Keterangan Kegiatan:</strong> {{ $peminjaman->keterangan_kegiatan ?? '-' }}</p>
                                <p><strong>Tanggal Mulai:</strong> {{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</p>
                                <p><strong>Tanggal Selesai:</strong> {{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</p>
                                <p><strong>Rutin:</strong> {{ $peminjaman->rutin ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Tipe Rutin:</strong> {{ ucfirst($peminjaman->tipe_rutin) ?? '-' }}</p>
                                <p><strong>Jumlah Perulangan:</strong> {{ $peminjaman->jumlah_perulangan ?? '-' }}</p>
                                <p><strong>Butuh Livestream:</strong> {{ $peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Butuh Operator:</strong> {{ $peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</p>
                                <p><strong>Operator Sound:</strong> {{ $peminjaman->operator_sound ?? '-' }}</p>
                                <p><strong>Status Pengajuan:</strong> {{ ucfirst($peminjaman->status_pengajuan) }}</p>
                                <p><strong>Catatan Persetujuan:</strong> {{ $peminjaman->catatan_persetujuan_kapel ?? '-' }}</p>
                                <p><strong>Divalidasi oleh:</strong> {{ $peminjaman->pjPeminjaman->name ?? '-' }}</p>
                                  {{-- Tambahan untuk file-file --}}
                                    @if ($peminjaman->surat_peminjaman)
                                        <p><strong>Surat Peminjaman:</strong>
                                            <a href="{{ asset('storage/surat_peminjaman/' . $peminjaman->surat_peminjaman) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat File
                                            </a>
                                        </p>
                                    @endif

                                    @if ($peminjaman->bukti_ukdw)
                                        <p><strong>Bukti UKDW:</strong>
                                            <a href="{{ asset('storage/bukti_ukdw/' . $peminjaman->bukti_ukdw) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                Lihat Bukti
                                            </a>
                                        </p>
                                    @endif
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

    {{ $peminjamans->links() }}
</div>
@endsection
<style>
    .table td .btn {
        min-width: 110px; /* agar lebar tombol seragam */
    }
</style>
