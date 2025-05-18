@extends('layout.staff_main')
@section('title', 'Daftar Peminjaman Kapel')

@section('content')
<div class="container mt-4">
    <h2>Daftar Peminjaman Kapel</h2>

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
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>ID Peminjaman</th>
                    <th>Ruang</th>
                    <th>Nama Peminjam</th>
                    <th>Nomor Induk</th>
                    <th>Asal Unit</th>
                    <th>Peran</th>
                    <th>Kontak</th>
                    <th>Email</th>
                    <th>Nama Kegiatan</th>
                    <th>Keterangan Kegiatan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Rutin</th>
                    <th>Tipe Rutin</th>
                    <th>Jumlah Perulangan</th>
                    <th>Butuh Livestream</th>
                    <th>Butuh Operator</th>
                    <th>Operator Sound</th>
                    <th>Status Pengajuan</th>
                   <!-- <th>Catatan Staff</th>-->
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjamans as $index => $peminjaman)
                <tr>
                    <td>{{ $index + $peminjamans->firstItem() }}</td>
                    <td>{{ $peminjaman->id_peminjaman_kapel }}</td>
                    <td>{{ $peminjaman->ruang->nama_ruang ?? '-' }}</td>
                    <td>{{ $peminjaman->nama_peminjam }}</td>
                    <td>{{ $peminjaman->nomor_induk }}</td>
                    <td>{{ $peminjaman->asal_unit ?? '-' }}</td>
                    <td>{{ $peminjaman->peran ?? '-' }}</td>
                    <td>{{ $peminjaman->kontak }}</td>
                    <td>{{ $peminjaman->email }}</td>
                    <td>{{ $peminjaman->nama_kegiatan }}</td>
                    <td>{{ $peminjaman->keterangan_kegiatan ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->format('d-m-Y H:i') }}</td>
                    <td>{{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d-m-Y H:i') }}</td>
                    <td>{{ $peminjaman->rutin ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ ucfirst($peminjaman->tipe_rutin) ?? '-' }}</td>
                    <td>{{ $peminjaman->jumlah_perulangan ?? '-' }}</td>
                    <td>{{ $peminjaman->butuh_livestream ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $peminjaman->butuh_operator ? 'Ya' : 'Tidak' }}</td>
                    <td>{{ $peminjaman->operator_sound ?? '-' }}</td>
                    <td>{{ ucfirst($peminjaman->status_pengajuan) }}</td>
                    <!--<td>{{ $peminjaman->catatan_staff ?? '-' }}</td>-->
                    <td>
                        @if ($peminjaman->status_pengajuan === 'proses')
                        <a href="{{ url('/staff_peminjaman_kapel/form_validasi_peminjaman_kapel/'.$peminjaman->id_peminjaman_kapel) }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
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
