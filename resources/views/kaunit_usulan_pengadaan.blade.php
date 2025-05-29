@extends('layout.staff_main')
@section('title', 'Daftar Usulan Pengadaan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>DAFTAR USULAN PENGADAAN</strong></div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Perlengkapan</th>
                    <th>Jumlah</th>
                    <th>Tanggal Pengusulan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usulans as $idx => $usulan)
                    <tr>
                        <td>{{ $idx + 1}}</td>
                        <td>{{ $usulan->nama_perlengkapan_pengadaan }}</td>
                        <td>{{ $usulan->jumlah_usulan_pengadaan }}</td>
                        <td>{{ $usulan->tanggal_usulan_pengadaan }}</td>
                        <td>{{ $usulan->status_usulan_pengadaan }}</td>
                        <td>
                            @if ($usulan->status_usulan_pengadaan == 'diproses')
                                <a href="/kaunit_usulan_pengadaan/form_validasi_pengadaan/{{ $usulan->id_usulan_pengadaan }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                            @else
                                <span class="badge bg-{{ $usulan->status_usulan_pengadaan == 'diterima' ? 'success' : 'danger' }}">{{ strtoupper($usulan->status_usulan_pengadaan) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada usulan pengadaan yang perlu di-approve.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $usulans->links() }}
    </div>
</div>
@endsection