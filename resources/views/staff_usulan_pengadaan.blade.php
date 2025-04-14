@extends('layout.staff_main')
@section('title', 'siinventaris - Pengadaan') 
@section('staff_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header">
          <a href="/staff_usulan_pengadaan/staff_pengadaan_formadd" class="btn btn-primary" role="button"><i class="bi bi-plus-square-fill"></i> Usul pengadaan </a>

        </div>
        <div class="card-body">
        
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">Nama Perlengkapan </th>
                <th scope="col">Jumlah </th>
                <th scope="col">Alasan Pengadaan </th>
                <th scope="col">Tanggal Usulan </th>
                <th scope="col">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pgd as $idx => $pg)
                <tr>
                  <td>{{$pg->nama_perlengkapan_usulan}}</td>
                  <td>{{$pg->jumlah_usulan_pengadaan}}</td>
                  <td>{{$pg->alasan_pengadaan}}</td>
                  <td>{{$pg->tanggal_usulan_pengadaan}}</td>

                  <td>
                    <a href="/staff_usulan_pengadaan/staff_pengadaan_formedit/{{$pg->id_usulan_pengadaan}}" class="btn btn-success"><i class="bi bi-pencil-square"></i></a>

                    
                    <a href="/staff_usulan_pengadaan/delete_pengadaan/{{$pg->id_usulan_pengadaan}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
                      <i class="bi bi-trash-fill"></i></i></a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
@endsection