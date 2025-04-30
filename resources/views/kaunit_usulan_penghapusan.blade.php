@extends('layout.kaunit_main')
@section('title', 'Daftar Usulan Penghapusan')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>DAFTAR USULAN PENGHAPUSAN</strong></div>
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
                    <th>Alasan Penghapusan</th>
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
                        <td>{{ $usulan->tanggal_usulan_penghapusan }}</td>
                        <td>{{ $usulan->alasan_penghapusan }}</td>
                        <td>
                @if($usulan->foto_penghapusan)
                <img src="{{ asset('storage/foto_penghapusan/' . $usulan->foto_penghapusan) }}" alt="Foto Penghapusan" width="80">
                 @else
                    <span class="text-muted">Tidak ada foto</span>
                @endif
                </td>
                        <td>{{ $usulan->status_usulan_penghapusan }}</td>
                        <td>
                            @if ($usulan->status_usulan_penghapusan == 'diproses')
                                <a href="/kaunit_usulan_penghapusan/form_validasi_penghapusan/{{ $usulan->id_usulan_penghapusan }}" class="btn btn-warning btn-sm">Beri Persetujuan</a>
                            @else
                                <span class="badge bg-{{ $usulan->status_usulan_penghapusan == 'diterima' ? 'success' : 'danger' }}">{{ strtoupper($usulan->status_usulan_penghapusan) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada usulan penghapusan yang perlu di-approve.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $usulans->links() }}
    </div>
</div>
@endsection