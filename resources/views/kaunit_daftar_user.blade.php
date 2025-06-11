@extends('layout.staff_main')
@section('title', 'siinventaris - Kepala Unit - Daftar User') 
@section('kaunit_navigasi')
@section('content')

<div class="card mt-4">
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
        <div class="card-header"> 
                <h5>Daftar User</h5>
        </div>
        
        <div class="card-body">
          <a href="{{ route('register') }}" class="btn btn-primary">(+) User</a>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Username </th>
                <th scope="col">Nama Lengkap </th>
                <th scope="col">Role </th>
                <th scope="col">Bagian </th>
                <th scope="col">Email </th>
                <th scope="col">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($usr as $idx => $u)
                    <tr>
                        <th scope="row">{{ $idx + 1 }}</th>
                        <td>{{$u->username}}</td>
                        <td>{{$u->name}}</td>
                        <td>{{$u->role }}</td>
                        <td>{{$u->bagian}}</td>
                        <td>{{$u->email}}</td>
                        <td>
                          <a href="/kaunit_daftar_user/delete_user/{{$u->id}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
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