@extends('layout.staff_main')
@section('title', 'siinventaris - Daftar Kategori') 
@section('staff_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header">
          <a href="/staff_daftar_kategori/s_kategori_formadd" class="btn btn-primary" role="button"><i class="bi bi-plus-square-fill"></i> Daftar Kategori </a>

        </div>
        <div class="card-body">
        
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Nama Kategori</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($ktg as $idx => $k)
                <tr>
                  <td>{{$k->id_kategori}}</td>
                  <td>{{$k->nama_kategori}}</td>
                  <td>
                    <a href="/staff_daftar_kategori/s_kategori_formedit/{{$k->id_kategori}}" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>

                    
                    <a href="/staff_daftar_kategori/delete_kategori/{{$k->id_kategori}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
                      <i class="bi bi-trash-fill"></i></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
@endsection