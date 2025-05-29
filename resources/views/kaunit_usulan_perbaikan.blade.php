@extends('layout.staff_main')
@section('title', 'Daftar Usulan Perbaikan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>DAFTAR USULAN PERBAIKAN</strong></div>
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
                    <th>Kode Perlengkapan</th>
                    <th>Tanggal Pengusulan</th>
                    <th>Alasan Perbaikan</th>
                    <th>Gambar Perlengkapan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($usulans as $idx => $usulan)
                    <tr>
                        <td>{{ $idx + 1}}</td>
                        <td>{{ $usulan->perlengkapan->kode_perlengkapan }}</td>
                        <td>{{ $usulan->tanggal_usulan_perbaikan }}</td>
                        <td>{{ $usulan->alasan_perbaikan }}</td>
                        <td>
                @if($usulan->foto_perbaikan)
                <img src="{{ asset('storage/foto_perbaikan/' . $usulan->foto_perbaikan) }}" alt="Foto Perbaikan" width="80">
                 @else
                    <span class="text-muted">Tidak ada foto</span>
                @endif
                </td>
                        <td>{{ $usulan->status_usulan_perbaikan }}</td>
                        <td>
                            @if ($usulan->status_usulan_perbaikan == 'diproses')
                                <a href="/kaunit_usulan_perbaikan/form_validasi_perbaikan/{{ $usulan->id_usulan_perbaikan }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                            @else
                                <span class="badge bg-{{ $usulan->status_usulan_perbaikan == 'diterima' ? 'success' : 'danger' }}">{{ strtoupper($usulan->status_usulan_perbaikan) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada usulan perbaikan yang perlu di-approve.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $usulans->links() }}
    </div>
</div>
@endsection