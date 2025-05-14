@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Ruang Formadd ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-3 mb-4 shadow-sm border">
    <h2>Form Peminjaman Ruang: <strong>{{ $ruang->nama_ruang }}</strong></h2>
    <div class="mb-4">
        <p><strong>Deskripsi:</strong> {{ $ruang->deskripsi_ruang ?? '-' }}</p>
        <p><strong>Kapasitas:</strong> {{ $ruang->kapasitas_ruang ?? '-' }}</p>
        <p><strong>Status Saat Ini:</strong> {{ $ruang->status ?? '-' }}</p>
    </div>
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

        <div class="form-group" id="asalUnitSection">
             <label for="asal_unit">Asal Unit</label>
                <select name="asal_unit" id="asal_unit" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="fti">Fakultas Teknologi Informasi</option>
                <option value="fad">Fakultas Arsitektur dan Desain</option>
                <option value="fb">Fakultas Bisnis</option>
            </select>
        </div>

        <div class="form-group" id="peranSection">
             <label for="peran">Status Peminjam</label>
                <select name="peran" id="peran" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="dosen">Dosen</option>
                <option value="pekerja">Staff Unit</option>
                <option value="mahasiswa">Mahasiswa</option>
            </select>
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

       <div class="form-check">
        <input type="checkbox" name="rutin" value="1" id="rutinCheck" class="form-check-input">
        <label class="form-check-label" for="rutinCheck">Peminjaman Rutin?</label>
    </div>

    <div id="rutinSection" style="display: none;">
        <div class="form-group">
            <label for="frekuensi">Frekuensi Peminjaman</label>
            <select name="frekuensi" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="harian">Harian</option>
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
            </select>
        </div>

        <div class="form-group">
            <label for="hari_rutin">Hari Rutin</label>
            <select name="hari_rutin" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="senin">Senin</option>
                <option value="selasa">Selasa</option>
                <option value="rabu">Rabu</option>
                <option value="kamis">Kamis</option>
                <option value="jumat">Jumat</option>
                <option value="sabtu">Sabtu</option>
                <option value="minggu">Minggu</option>
            </select>
        </div>

        <div class="form-group">
            <label for="waktu_mulai_rutin">Waktu Mulai Rutin</label>
            <input type="time" name="waktu_mulai_rutin" class="form-control">
        </div>

        <div class="form-group">
            <label for="waktu_selesai_rutin">Waktu Selesai Rutin</label>
            <input type="time" name="waktu_selesai_rutin" class="form-control">
        </div>
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
    <div class="modal fade" id="konfirmasiPeminjamanModal" tabindex="-1" aria-labelledby="konfirmasiPeminjamanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="konfirmasiPeminjamanModalLabel">Konfirmasi Data Peminjaman</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Mohon periksa kembali data peminjaman Anda sebelum mengirim:</p>
                <ul id="konfirmasiDataList">
                    </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="submitPeminjamanBtn">Yakin, Ajukan Peminjaman</button>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById('rutinCheck').addEventListener('change', function () {
        document.getElementById('rutinSection').style.display = this.checked ? 'block' : 'none';
    });

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
            return;
        }

        e.preventDefault(); // Mencegah submit form secara langsung

        // Ambil data formulir
        const formData = new FormData(this);
        const konfirmasiDataList = document.getElementById('konfirmasiDataList');
        konfirmasiDataList.innerHTML = ''; // Kosongkan list sebelumnya

        // Tampilkan data di modal
        for (const [name, value] of formData.entries()) {
            let label = name.replace(/_/g, ' ').replace(/\[\]/g, '').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
            let displayValue = value;

            if (name === 'id_ruang') {
                label = 'Ruang';
                displayValue = "{{ $ruang->nama_ruang }}";
            } else if (name === 'surat_peminjaman' && value instanceof File) {
                displayValue = value.name;
            } else if (name === 'butuh_gladi') {
                displayValue = value === '1' ? 'Ya' : 'Tidak';
            } else if (name === 'rutin') {
                displayValue = value === '1' ? 'Ya' : 'Tidak';
            } else if (name === 'butuh_livestream') {
                displayValue = value === '1' ? 'Ya' : 'Tidak';
            } else if (name === 'butuh_operator') {
                displayValue = value === '1' ? 'Ya' : 'Tidak';
            }

            konfirmasiDataList.innerHTML += `<li><strong>${label}:</strong> ${displayValue}</li>`;
        }

        // Tampilkan modal
        $('#konfirmasiPeminjamanModal').modal('show');
    });

    // Event listener untuk tombol submit di modal
    document.getElementById('submitPeminjamanBtn').addEventListener('click', function () {
        document.getElementById('formPeminjaman').submit(); // Submit form setelah konfirmasi
    });
</script>
@endsection
