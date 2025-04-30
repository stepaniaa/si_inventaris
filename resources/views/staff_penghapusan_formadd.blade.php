@extends('layout.staff_main')
@section('title', 'Penghapusan - Add Data')
@section('content')
<div class="card mt-4">
    <div class="card-header"><strong>FORM TAMBAH DATA PENGHAPUSAN</strong></div>
    <div class="card-body">
        <form action="/staff_usulan_penghapusan/save_penghapusan" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Perlengkapan</label>
                <select name="id_perlengkapan" class="form-control select2" required>
                    <option value="" disabled selected>Pilih perlengkapan</option>
                    @foreach($perlengkapan as $p)
                    <option value="{{ $p->id_perlengkapan }}">{{ $p->kode_perlengkapan }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Alasan Penghapusan</label>
                <input type="text" name="alasan_penghapusan" class="form-control" placeholder="Masukkan alasan penghapusan" required>
            </div>

            <div class="form-group">
                <label>Foto Perlengkapan</label>
                <input type="file" name="foto_penghapusan" class="form-control" accept="image/*">
            </div>

            <div class="form-group mt-4">
                <button type="submit" role="button" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Pilih perlengkapan",
            allowClear: true
        });
    });
</script>

@endsection