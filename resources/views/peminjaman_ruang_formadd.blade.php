@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Ruang Formadd ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container mt-4">
    <h2>Form Peminjaman Ruang: <strong>{{ $ruang->nama_ruang }}</strong></h2>

    <div class="mb-4">
        <p><strong>Deskripsi:</strong> {{ $ruang->deskripsi_ruang ?? '-' }}</p>
        <p><strong>Kapasitas:</strong> {{ $ruang->kapasitas_ruang ?? '-' }}</p>
        <p><strong>Status Saat Ini:</strong> {{ $ruang->status ?? '-' }}</p>
    </div>

    <form action="{{ url('/peminjaman_ruang/save_peminjaman_ruang') }}" method="POST" enctype="multipart/form-data" id="formPeminjaman">
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
        <input type="hidden" name="id_ruang" value="{{ $ruang->id_ruang }}">

        <div class="form-group">
            <label>Nomor Induk</label>
            <input type="text" name="nomor_induk" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" name="nama_peminjam" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Kontak</label>
            <input type="text" name="kontak" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Keterangan Kegiatan</label>
            <textarea name="keterangan_kegiatan" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label>Tanggal Mulai Peminjaman</label>
            <input type="datetime-local" name="tanggal_mulai" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal Selesai Peminjaman</label>
            <input type="datetime-local" name="tanggal_selesai" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah Kursi Tambahan (jika ada)</label>
            <input type="number" name="jumlah_kursi_tambahan" class="form-control">
        </div>

        <div class="form-group">
            <label>Surat Peminjaman (PDF)</label>
            <input type="file" name="surat_peminjaman" accept="application/pdf" class="form-control" required>
        </div>

        <div class="form-check mt-3">
            <input type="checkbox" name="butuh_gladi" value="1" class="form-check-input" id="checkGladi">
            <label class="form-check-label" for="checkGladi">Butuh Gladi?</label>
        </div>

        <div class="form-group" id="gladiStartSection" style="display: none;">
            <label>Tanggal Mulai Gladi</label>
            <input type="datetime-local" name="tanggal_gladi" class="form-control">
        </div>

        <div class="form-group" id="gladiEndSection" style="display: none;">
            <label>Tanggal Selesai Gladi</label>
            <input type="datetime-local" name="tanggal_pengembalian_gladi" class="form-control">
        </div>

        <div class="form-check mt-2">
            <input type="checkbox" name="butuh_livestream" value="1" class="form-check-input" id="checkLivestream">
            <label class="form-check-label" for="checkLivestream">Butuh Livestream?</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="butuh_operator" value="1" class="form-check-input" id="checkOperator">
            <label class="form-check-label" for="checkOperator">Butuh Operator?</label>
        </div>

        <div class="form-group" id="operatorSoundSection" style="display: none;">
            <label for="operator_sound">Operator Sound</label>
            <select name="operator_sound" id="operator_sound" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="LPKKSK">Operator sound dari Tim PKK Live</option>
                <option value="Penyelenggara">Operator sound dari penyelenggara kegiatan (Harus briefing terlebih dahulu)</option>
            </select>
        </div>

        <div class="form-check mt-3">
            <input type="checkbox" class="form-check-input" id="setujuSk" required>
            <label class="form-check-label" for="setujuSk">
                Saya setuju dengan <a href="#">Syarat & Ketentuan</a>.
            </label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajukan Peminjaman</button>
    </form>
</div>

<script>
    document.getElementById('checkGladi').addEventListener('change', function () {
        document.getElementById('gladiStartSection').style.display = this.checked ? 'block' : 'none';
        document.getElementById('gladiEndSection').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('checkOperator').addEventListener('change', function () {
        const section = document.getElementById('operatorSoundSection');
        section.style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('formPeminjaman').addEventListener('submit', function (e) {
        if (!document.getElementById('setujuSk').checked) {
            e.preventDefault();
            alert('Anda harus menyetujui Syarat & Ketentuan sebelum mengirim formulir.');
        }
    });
</script>
@endsection
