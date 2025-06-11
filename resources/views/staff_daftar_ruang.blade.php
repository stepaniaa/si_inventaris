@extends('layout.staff_main')
@section('title', 'siinventaris - Daftar Ruang') 
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
<h4>Daftar Ruang</h4>
<div class="card mt-4">
        <div class="card-header">
          <a href="/staff_daftar_ruang/s_ruang_formadd" class="btn btn-primary" role="button"><i class="bi bi-plus-square-fill"></i> Ruang </a>

        </div>
        <div class="card-body">
        <div class="table-responsive">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">No </th>
                <th scope="col">Kode Kapel </th>
                <th scope="col">Nama Kapel</th>
                <th scope="col">Kapasitas </th>
                <th scope="col">Fasilitas </th>
                <th scope="col">Deskripsi </th>
                <th scope="col">Lokasi </th>
                <th scope="col">Perlu pengajuan peminjaman ? </th>
                <th scope="col">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rng as $idx => $r)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$r->kode_ruang}}</td>
                  <td>{{$r->nama_ruang}}</td>
                  <td>{{$r->kapasitas_ruang}}</td>
                  <td>{{$r->fasilitas_ruang}}</td>
                  <td>{{$r->deskripsi_ruang}}</td>
                  <td>{{$r->lokasi_ruang}}</td>
                  <td>{{$r->bisa_dipinjam}}</td>

                  <td>
                    <a href="/staff_daftar_ruang/s_ruang_formedit/{{$r->id_ruang}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>

                    
                    <a href="/staff_daftar_ruang/delete_ruang/{{$r->id_ruang}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
                      <i class="bi bi-trash-fill"></i></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
           </div>
        </div>
    </div>
@endsection