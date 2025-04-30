@extends('layout.staff_main')
@section('title', 'siinventaris - Pengadaan')
@section('staff_navigasi')
@section('content')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('danger'))
    <div class="alert alert-danger">
        {{ session('danger') }}
    </div>
@endif 


<div class="card mt-4">
    <div class="card-header">
        <a href="/staff_usulan_pengadaan/staff_pengadaan_formadd" class="btn btn-primary btn-sm" role="button"><i class="bi bi-plus-square-fill"></i> Usul pengadaan </a>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Perlengkapan</th>
                    <th>Jumlah</th>
                    <th>Alasan</th>
                    <th>Estimasi Harga</th>
                    <th>Tanggal Pengusulan</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal Persetujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pgd as $idx => $pg)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $pg->nama_perlengkapan_pengadaan }}</td>
                        <td>{{ $pg->jumlah_usulan_pengadaan }}</td>
                        <td>{{ $pg->alasan_pengadaan }}</td>
                        <td>{{ number_format($pg->estimasi_harga, 0, ',', '.') }}</td>
                        <td>{{ $pg->tanggal_usulan_pengadaan }}</td>
                        <td>{{ $pg->status_usulan_pengadaan }}</td>
                        <td>{{ $pg->catatan_pengadaan_kaunit}}</td>
                        <td>{{ $pg->tanggal_persetujuan_kaunit}}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/staff_usulan_pengadaan/staff_pengadaan_formedit/{{$pg->id_usulan_pengadaan}}" class="btn btn-success btn-sm"
                                    @if ($pg->status_usulan_pengadaan == 'diterima' || $pg->status_usulan_pengadaan == 'ditolak')
                                        style="pointer-events: none; opacity: 0.6;"
                                    @endif
                                ><i class="bi bi-pencil-square"></i></a>

                                <form action="/staff_usulan_pengadaan/delete_pengadaan/{{$pg->id_usulan_pengadaan}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')"
                                        @if ($pg->status_usulan_pengadaan == 'diterima' || $pg->status_usulan_pengadaan == 'ditolak')
                                            disabled
                                        @endif
                                    >
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection