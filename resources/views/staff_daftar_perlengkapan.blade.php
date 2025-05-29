@extends('layout.staff_main')
@section('title', 'siinventaris - Daftar Perlengkapan') 
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
<h4>Daftar Perlengkapan</h4>
<div class="card mt-4">
        <div class="card-header">
          <a href="/staff_daftar_perlengkapan/s_perlengkapan_formadd" class="btn btn-primary" role="button"><i class="bi bi-plus-square-fill"></i> Perlengkapan </a>
          <form action="/staff_daftar_perlengkapan/search" method="GET" class="form-inline my-2 my-lg-0 float-right">
            <input name="p" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
        

        <div class="card-body">
        <div class="table-responsive">
           <table class="table table-bordered">
            <thead>
              <tr>
                <th scope="col">No </th>
                <th scope="col">Kode </th>
                <th scope="col">Nama </th>
                <th scope="col">Kategori </th>
                <th scope="col">Lokasi </th>
                <th scope="col">Stok </th>
                <th scope="col">Harga Satuan </th>
                <th scope="col">Tanggal Beli  </th>
                <th scope="col">Kondisi </th>
                <th scope="col">Status </th>
                <th scope="col">Bisa Dipinjam ? </th>
                <th scope="col">Deskripsi </th>
                <th scope="col">Foto </th>
                <th scope="col">Aksi </th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pkp as $idx => $p)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$p->kode_perlengkapan}}</td>
                  <td>{{$p->nama_perlengkapan}}</td>
                  <td>{{ $p->kategori->nama_kategori }}</td> 
                  <td>{{ $p->ruang->nama_ruang }}</td> 
                  <td>{{$p->stok_perlengkapan}}</td>
                  <td>{{$p->harga_satuan_perlengkapan}}</td>
                  <td>{{$p->tanggal_beli_perlengkapan}}</td>
                  <td>{{$p->kondisi_perlengkapan}}</td>
                  <td>{{$p->status_perlengkapan}}</td>
                  <td>{{$p->bisa_dipinjam_pk}}</td>
                  <td>{{$p->deskripsi_perlengkapan}}</td>
                  <td>
                  @if($p->foto_perlengkapan)
                  <img src="{{ asset('storage/' . $p->foto_perlengkapan) }}" alt="Foto Perlengkapan" width="80">
                  @else
                  <span class="text-muted">Tidak ada foto</span>
                  @endif
</td>


                  <td>
                    <a href="/staff_daftar_perlengkapan/s_perlengkapan_formedit/{{$p->id_perlengkapan}}" class="btn btn-warning"><i class="bi bi-pencil-square"></i></a>

                    
                    <!--<a href="/staff_daftar_perlengkapan/delete_perlengkapan/{{$p->id_perlengkapan}}" class="btn btn-danger" onclick="return confirm('Apakah ada yakin ingin menghapus data ini ?')">
                      <i class="bi bi-trash-fill"></i></i></a>-->
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
          <div class="d-flex justify-content-center">
        {{ $pkp->links() }}
    </div>
    </div>
    </div>
@endsection