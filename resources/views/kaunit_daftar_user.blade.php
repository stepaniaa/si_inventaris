@extends('layout.kaunit_main')
@section('title', 'siinventaris - Kepala Unit - Daftar User') 
@section('kaunit_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header"> 
                <h3>Daftar User</h3>
                <a href="{{ route('register') }}" class="btn btn-primary">Tambah User</a>
        </div>
        

        <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Username </th>
                <th scope="col">Nama Lengkap </th>
                <th scope="col">Role </th>
                <th scope="col">Email </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($usr as $idx => $u)
                    <tr>
                        <th scope="row">{{ $idx + 1 }}</th>
                        <td>{{$u->username}}</td>
                        <td>{{$u->name}}</td>
                        <td>{{$u->role }}</td>
                        <td>{{$u->email}}</td>
                    </tr>
                    @endforeach
            </tbody>
          </table>
        </div>
    </div>
    </div>
@endsection