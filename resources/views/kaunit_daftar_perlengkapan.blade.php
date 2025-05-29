@extends('layout.staff_main')
@section('title', 'siinventaris - Kepala Unit - Daftar Perlengkapan') 
@section('kaunit_navigasi')
@section('content')

<div class="card mt-4">
        <div class="card-header"> 
                <h5>Daftar Perlengkapan</h5>
        </div>
        

        <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
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
                <th scope="col">Deskripsi </th>
                <th scope="col">Foto </th>
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
                  <td>{{$p->deskripsi_perlengkapan}}</td>
                  <td>
                  @if($p->foto_perlengkapan)
                  <img src="{{ asset('storage/' . $p->foto_perlengkapan) }}" alt="Foto Perlengkapan" width="80">
                  @else
                  <span class="text-muted">Tidak ada foto</span>
                  @endif
</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
    </div>
    </div>
@endsection