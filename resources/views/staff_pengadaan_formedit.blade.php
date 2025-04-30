@extends('layout.staff_main')
@section('title', 'Pengadaan - Edit Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT PENGADAAN</strong></div>
    <div class="card-body">
        <form action="/staff_usulan_pengadaan/update_pengadaan/{{$pgd->id_usulan_pengadaan}}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Id Usulan Pengadaan</label>
                <input type="number" name="id_usulan_pengadaan" class="form-control" value="{{$pgd->id_usulan_pengadaan}}"readonly>
            </div>
            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" name="nama_perlengkapan_pengadaan" class="form-control" value="{{$pgd->nama_perlengkapan_pengadaan}}">
            </div>
            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" name="jumlah_usulan_pengadaan" class="form-control" value="{{$pgd->jumlah_usulan_pengadaan}}">
            </div>
            <div class="form-group">
                <label>Alasan pengadaan</label>
                <input type="text" name="alasan_pengadaan" class="form-control" value="{{$pgd->alasan_pengadaan}}">
            </div>
            <div class="form-group">
                <label>Estimasi Harga</label>
                <input type="number" name="estimasi_harga" class="form-control" value="{{$pgd->estimasi_harga}}">
            </div>
            <div class="form-group">
                <label>Tanggal saat ini</label>
                <input type="datetime-local" name="tanggal_usulan_pengadaan" class="form-control" value="{{$pgd->tanggal_usulan_pengadaan}}">
            </div>
    
            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection