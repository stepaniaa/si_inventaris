@extends('layout.kaunit_main')
@section('title', 'siinventaris - Kepala Unit - Daftar Kapel') 
@section('kaunit_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header">
        <h2>Daftar Kapel</h2>

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
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
@endsection