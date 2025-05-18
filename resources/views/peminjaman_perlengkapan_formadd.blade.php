@extends('layout.peminjam_main')
@section('title', 'Form Peminjaman Perlengkapan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Form Peminjaman Perlengkapan</h3>

    <form action="{{ url('/peminjaman_perlengkapan/save_peminjaman_perlengkapan') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-group">
            <label>Nomor Induk:</label>
            <input type="text" class="form-control" name="nomor_induk_pk" required>
        </div>
        <div class="form-group">
            <label>Nama Peminjam:</label>
            <input type="text" class="form-control" name="nama_peminjam_pk" required>
        </div>
        <div class="form-group">
            <label>Kontak:</label>
            <input type="text" class="form-control" name="kontak_pk" required>
        </div>
        <div class="form-group">
            <label>Email:</label>
            <input type="email" class="form-control" name="email_pk" required>
        </div>
        <div class="form-group">
            <label>Nama Kegiatan:</label>
            <input type="text" class="form-control" name="nama_kegiatan_pk" required>
        </div>
        <div class="form-group">
            <label>Keterangan Kegiatan:</label>
            <textarea class="form-control" name="keterangan_kegiatan_pk"></textarea>
        </div>

        {{-- Opsi Peminjaman Rutin --}}
        <div class="form-check mt-3">
            <input class="form-check-input" type="checkbox" value="1" id="rutinCheck" name="rutin" onchange="toggleRutin()">
            <label class="form-check-label" for="rutinCheck">Peminjaman Rutin?</label>
        </div>

        <div id="opsiRutin" style="display: none;">
            <div class="mb-2">
                <label class="form-label">Tipe Rutin</label>
                <select name="tipe_rutin" class="form-select">
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div class="mb-2">
                <label class="form-label">Jumlah Perulangan</label>
                <input type="number" class="form-control" name="jumlah_perulangan" min="1">
            </div>
            <div class="mb-2">
                <label class="form-label">Tanggal Mulai Sesi Pertama</label>
                <input type="date" name="tanggal_sesi_awal[mulai]" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">Tanggal Selesai Sesi Pertama</label>
                <input type="date" name="tanggal_sesi_awal[selesai]" class="form-control">
            </div>
        </div>

        {{-- Daftar Perlengkapan Dipilih --}}
        <div class="form-group">
            <label>Perlengkapan:</label><br>
            @foreach ($perlengkapan as $item)
                <input type="hidden" name="id_perlengkapan[]" value="{{ $item->id_perlengkapan }}">
                {{ $item->nama_perlengkapan }}<br>
            @endforeach
        </div>

        <div class="form-group">
            <label>Tanggal Mulai:</label>
            <input type="datetime-local" class="form-control" name="tanggal_mulai_pk" required>
        </div>
        <div class="form-group">
            <label>Tanggal Selesai:</label>
            <input type="datetime-local" class="form-control" name="tanggal_selesai_pk" required>
        </div>

        <div class="form-group">
            <label>Butuh Gladi:</label>
            <input type="checkbox" name="butuh_gladi_pk" value="1">
        </div>
        <div class="form-group">
            <label>Tanggal Gladi:</label>
            <input type="datetime-local" class="form-control" name="tanggal_gladi_pk">
        </div>
        <div class="form-group">
            <label>Tanggal Selesai Gladi:</label>
            <input type="datetime-local" class="form-control" name="tanggal_selesai_gladi_pk">
        </div>

        <div class="form-group">
            <label>Butuh Livestream:</label>
            <input type="checkbox" name="butuh_livestream_pk" value="1">
        </div>
        <div class="form-group">
            <label>Butuh Operator:</label>
            <input type="checkbox" name="butuh_operator_pk" value="1">
        </div>
        <div class="form-group">
            <label>Operator Sound:</label>
            <input type="text" class="form-control" name="operator_sound_pk">
        </div>
        <div class="form-group">
            <label>Operator Live:</label>
            <input type="text" class="form-control" name="operator_live_pk">
        </div>

        <div class="form-group">
            <label>Surat Peminjaman (PDF):</label>
            <input type="file" class="form-control" name="surat_peminjaman_pk" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
    </form>
</div>

<script>
    function toggleRutin() {
        document.getElementById('opsiRutin').style.display = document.getElementById('rutinCheck').checked ? 'block' : 'none';
    }
</script>
@endsection

