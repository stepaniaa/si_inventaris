@extends('layout.staff_main')
@section('title', 'Perlengkapan - Edit Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM EDIT DATA PERLENGKAPAN</strong></div>
    <div class="card-body">
        <form action="/staff_daftar_perlengkapan/update_perlengkapan/{{ $pkp->id_perlengkapan }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Kode Perlengkapan</label>
                <input type="text" name="kode_perlengkapan" class="form-control" value="{{ $pkp->kode_perlengkapan }}" required>
            </div>

            <div class="form-group">
                <label>Nama Perlengkapan</label>
                <input type="text" name="nama_perlengkapan" class="form-control" value="{{ $pkp->nama_perlengkapan }}" required>
            </div>

            <div class="form-group">
                <label>Kategori Perlengkapan</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="" disabled>Pilih kategori perlengkapan</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id_kategori }}" {{ $pkp->id_kategori == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Lokasi Perlengkapan (Ruang)</label>
                <select name="id_ruang" class="form-control" required>
                    <option value="" disabled>Pilih lokasi ruang</option>
                    @foreach($ruang as $r)
                        <option value="{{ $r->id_ruang }}" {{ $pkp->id_ruang == $r->id_ruang ? 'selected' : '' }}>
                            {{ $r->nama_ruang }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Stok Perlengkapan</label>
                <input type="number" name="stok_perlengkapan" class="form-control" value="{{ $pkp->stok_perlengkapan }}" required>
            </div>

            <div class="form-group">
                <label>Harga Satuan Perlengkapan</label>
                <input type="number" step="0.01" name="harga_satuan_perlengkapan" class="form-control" value="{{ $pkp->harga_satuan_perlengkapan }}" required>
            </div>

            <div class="form-group">
                <label>Tanggal Beli Perlengkapan</label>
                <input type="date" name="tanggal_beli_perlengkapan" class="form-control" value="{{ $pkp->tanggal_beli_perlengkapan ? $pkp->tanggal_beli_perlengkapan->format('Y-m-d') : '' }}" required>
            </div>

            <div class="form-group">
                <label>Kondisi Perlengkapan</label>
                <select class="form-control" name="kondisi_perlengkapan" required>
                    <option value="">Pilih Kondisi</option>
                    <option value="Baik" {{ $pkp->kondisi_perlengkapan == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak" {{ $pkp->kondisi_perlengkapan == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                </select>
            </div>

            <div class="form-group">
                <label>Deskripsi Perlengkapan</label>
                <input type="text" name="deskripsi_perlengkapan" class="form-control" value="{{ $pkp->deskripsi_perlengkapan }}">
            </div>

            <div class="form-group">
                <label>Foto Perlengkapan</label>
                <input type="file" name="foto_perlengkapan" class="form-control" accept="image/*">
                @if($pkp->foto_perlengkapan)
                    <small class="form-text text-muted">Foto saat ini: {{ $pkp->foto_perlengkapan }}</small>
                    <img src="{{ asset('storage/' . $pkp->foto_perlengkapan) }}" alt="Foto Perlengkapan Saat Ini" width="100" class="mt-2">
                @endif
            </div>

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection