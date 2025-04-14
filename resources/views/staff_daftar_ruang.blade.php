@extends('layout.staff_main')
@section('title', 'siinventaris - Daftar Ruang') 
@section('staff_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header">
          <a href="/staff_daftar_ruang/s_ruang_formadd" class="btn btn-primary" role="button"><i class="bi bi-plus-square-fill"></i> Ruang </a>

        </div>
        <div class="card-body">
        
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Kode Kapel </th>
                <th scope="col">Nama Kapel</th>
                <th scope="col">Kapasitas </th>
                <th scope="col">Fasilitas </th>
                <th scope="col">Deskripsi </th>
                <th scope="col">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($rng as $idx => $r)
                <tr>
                  <td>{{$r->kode_ruang}}</td>
                  <td>{{$r->nama_ruang}}</td>
                  <td>{{$r->kapasitas_ruang}}</td>
                  <td>{{$r->fasilitas_ruang}}</td>
                  <td>{{$r->deskripsi_ruang}}</td>

                  <td>
                    <a href="/staff_daftar_ruang/s_ruang_formedit/{{$r->id_ruang}}" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>

                    
                    <a href="/staff_daftar_ruang/delete_ruang/{{$r->id_ruang}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
                      <i class="bi bi-trash-fill"></i></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
@endsection