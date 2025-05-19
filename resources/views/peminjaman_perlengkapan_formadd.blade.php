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

        {{-- Daftar Perlengkapan Dipilih --}}
        <div class="form-group">
            <label>Perlengkapan:</label><br>
            @foreach ($perlengkapan as $item)
                <input type="hidden" name="id_perlengkapan[]" value="{{ $item->id_perlengkapan }}">
                {{ $item->nama_perlengkapan }}<br>
            @endforeach
        </div>

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

        <div class="form-group">
        <label>Tanggal & Waktu Mulai Peminjaman</label>
        <input type="datetime-local" name="tanggal_sesi_awal[mulai]" class="form-control">
    </div>
    <div class="form-group">
        <label>Tanggal & Waktu Selesai Peminjaman</label>
        <input type="datetime-local" name="tanggal_sesi_awal[selesai]" class="form-control">
    </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="rutin" value="1" id="rutinCheck" class="form-check-input" {{ old('rutin') ? 'checked' : '' }}>
            <label class="form-check-label" for="rutinCheck">Peminjaman Rutin? (Opsional)</label>
        </div>
       <div id="rutinSection" style="display:none; margin-top: 1rem;">
    <div class="form-group">
        <label>Tipe Rutin</label>
        <select name="tipe_rutin" class="form-control">
            <option value="" disabled selected>-- Pilih Tipe Rutin --</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
        </select>
    </div>
    <div class="form-group">
        <label>Jumlah Perulangan</label>
        <input type="number" name="jumlah_perulangan" class="form-control" min="1" value="1">
    </div>
</div>

        <div class="form-group">
            <label>Butuh Livestream ? (Opsional)</label>
            <input type="checkbox" name="butuh_livestream_pk" value="1">
        </div>

        <div class="form-group">
            <label>Butuh Operator ? (Opsional)</label>
            <input type="checkbox" name="butuh_operator_pk" value="1">
        </div>

        <div class="form-group">
            <label>Surat Peminjaman (PDF):</label>
            <input type="file" class="form-control" name="surat_peminjaman_pk" accept="application/pdf">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Peminjaman</button>
    </form>
</div>

<script>
    document.getElementById('rutinCheck').addEventListener('change', function () {
        document.getElementById('rutinSection').style.display = this.checked ? 'block' : 'none';
    });
</script>
@endsection

