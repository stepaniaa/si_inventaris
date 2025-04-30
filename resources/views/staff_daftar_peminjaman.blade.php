@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Ruang')
@section('staff_navigasi')
@section('content')
    <div class="card mt-4">
        <div class="card-header"><strong>DAFTAR PEMINJAMAN RUANG</strong></div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Induk</th>
                            <th>Nama Peminjam</th>
                            <th>Email</th>
                            <th>Nomor Telepon</th>
                            <th>Status Peminjam</th>
                            <th>Asal Unit</th>
                            <th>Nama Kegiatan</th>
                            <th>Kegunaan Peminjaman</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
                            <th>Pukul Mulai</th>
                            <th>Pukul Selesai</th>
                            <th>Surat Peminjaman</th>
                            <th>Ruang yang Dipinjam</th>
                            <th>Status Peminjaman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $idx => $peminjaman)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $peminjaman->nomor_induk }}</td>
                                <td>{{ $peminjaman->nama_peminjam }}</td>
                                <td>{{ $peminjaman->email }}</td>
                                <td>{{ $peminjaman->nomor_telpon }}</td>
                                <td>{{ $peminjaman->status_peminjam }}</td>
                                <td>{{ $peminjaman->asal_unit }}</td>
                                <td>{{ $peminjaman->nama_kegiatan }}</td>
                                <td>{{ $peminjaman->kegunaan_peminjaman }}</td>
                                <td>{{ $peminjaman->tanggal_mulai }}</td>
                                <td>{{ $peminjaman->tanggal_selesai }}</td>
                                <td>{{ $peminjaman->pukul_mulai }}</td>
                                <td>{{ $peminjaman->pukul_selesai }}</td>
                                 <td>
                                    @if ($peminjaman->surat_peminjaman)
                                        <a href="{{ asset('storage/surat_peminjaman/' . $peminjaman->surat_peminjaman) }}"
                                            target="_blank">Lihat Surat</a>
                                    @else
                                        Tidak ada surat
                                    @endif
                                </td>
                                <td>{{ $peminjaman->ruang->nama_ruang }}</td>
                                <td>{{ $peminjaman->status_peminjaman }}</td>
                                <td>
                                    @if ($peminjaman->status_peminjaman == 'diproses')
                                    <a href="/staff_daftar_peminjaman/form_validasi_peminjaman/{{ $peminjaman->id_peminjaman }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                                    @else
                                        <span
                                            class="badge bg-{{ $peminjaman->status_peminjaman == 'diterima' ? 'success' : 'danger' }}">{{ strtoupper($peminjaman->status_peminjaman) }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="18" class="text-center">Tidak ada data peminjaman ruang.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection
