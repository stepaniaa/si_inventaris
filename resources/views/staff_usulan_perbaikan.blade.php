@extends('layout.staff_main')
@section('title', 'siinventaris - Perbaikan')
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
        <a href="/staff_usulan_perbaikan/staff_perbaikan_formadd" class="btn btn-primary btn-sm" role="button"><i class="bi bi-plus-square-fill"></i> Usul Perbaikan </a>
    </div>
    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Perlengkapan</th>
                    <th>Alasan Perbaikan</th>
                    <th>Estimasi Harga</th>
                    <th>Tanggal Pengusulan</th>
                    <th>Foto Perbaikan</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal Persetujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($prb as $idx => $pr)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $pr->perlengkapan->kode_perlengkapan }}</td>
                        <td>{{ $pr->alasan_perbaikan }}</td>
                        <td>{{ number_format($pr->estimasi_harga_perbaikan, 0, ',', '.') }}</td>
                        <td>{{ $pr->tanggal_usulan_perbaikan }}</td>
                        <td>
                            @if ($pr->foto_perbaikan)
                                <img src="{{ asset('storage/foto_perbaikan/' . $pr->foto_perbaikan) }}" alt="Foto Perbaikan" width="50">
                            @else
                                Tidak Ada Foto
                            @endif
                        </td>
                        <td>{{ $pr->status_usulan_perbaikan }}</td>
                        <td>{{ $pr->catatan_perbaikan_kaunit}}</td>
                        <td>{{ $pr->tanggal_persetujuan_perbaikan}}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/staff_usulan_perbaikan/staff_perbaikan_formedit/{{$pr->id_usulan_perbaikan}}" class="btn btn-success btn-sm"
                                    @if ($pr->status_usulan_perbaikan == 'diterima' || $pr->status_usulan_perbaikan == 'ditolak')
                                        style="pointer-events: none; opacity: 0.6;"
                                    @endif
                                ><i class="bi bi-pencil-square"></i></a>

                                <form action="/staff_usulan_perbaikan/delete_perbaikan/{{$pr->id_usulan_perbaikan}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')"
                                        @if ($pr->status_usulan_perbaikan == 'diterima' || $pr->status_usulan_perbaikan == 'ditolak')
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