@extends('layout.staff_main')
@section('title', 'siinventaris - Penghapusan')
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
        <a href="/staff_usulan_penghapusan/staff_penghapusan_formadd" class="btn btn-primary btn-sm" role="button"><i class="bi bi-plus-square-fill"></i> Usul penghapusan </a>
    </div>
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Perlengkapan</th>
                    <th>Alasan penghapusan</th>
                    <th>Tanggal Pengusulan</th>
                    <th>Foto </th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Tanggal Persetujuan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($phs as $idx => $ph)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $ph->perlengkapan->kode_perlengkapan }}</td>
                        <td>{{ $ph->alasan_penghapusan }}</td>
                        <td>{{ $ph->tanggal_usulan_penghapusan }}</td>
                        <td>
                            @if ($ph->foto_penghapusan)
                                <img src="{{ asset('storage/foto_penghapusan/' . $ph->foto_penghapusan) }}" alt="Foto Penghapusan" width="50">
                            @else
                                Tidak Ada Foto
                            @endif
                        </td>
                        <td>{{ $ph->status_usulan_penghapusan }}</td>
                        <td>{{ $ph->catatan_penghapusan_kaunit}}</td>
                        <td>{{ $ph->tanggal_persetujuan_penghapusan}}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="/staff_usulan_penghapusan/staff_penghapusan_formedit/{{$ph->id_usulan_penghapusan}}" class="btn btn-success btn-sm"
                                    @if ($ph->status_usulan_penghapusan == 'diterima' || $ph->status_usulan_penghapusan == 'ditolak')
                                        style="pointer-events: none; opacity: 0.6;"
                                    @endif
                                ><i class="bi bi-pencil-square"></i></a>

                                <form action="/staff_usulan_penghapusan/delete_penghapusan/{{$ph->id_usulan_penghapusan}}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')"
                                        @if ($ph->status_usulan_penghapusan == 'diterima' || $ph->status_usulan_penghapusan == 'ditolak')
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
@endsection