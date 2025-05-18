@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Kapel Formadd ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-3 mb-4 shadow-sm border">
    <h2>Form Peminjaman Kapel: <strong>{{ $kapel->nama_ruang }}</strong></h2>
    <div class="mb-4">
        <p><strong>Deskripsi:</strong> {{ $kapel->deskripsi_ruang ?? '-' }}</p>
        <p><strong>Kapasitas:</strong> {{ $kapel->kapasitas_ruang ?? '-' }}</p>
        <p><strong>Status Saat Ini:</strong> {{ $kapel->status ?? '-' }}</p>
    </div>
    </div>

    <form action="{{ url('/peminjaman_kapel/save_peminjaman_kapel') }}" method="POST" enctype="multipart/form-data" id="formPeminjaman">
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

        <input type="hidden" name="id_ruang" value="{{ $kapel->id_ruang }}">

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
        <label>Tanggal & Waktu Mulai Peminjaman</label>
        <input type="datetime-local" name="tanggal_sesi_awal[mulai]" class="form-control">
    </div>
    <div class="form-group">
        <label>Tanggal & Waktu Selesai Peminjaman</label>
        <input type="datetime-local" name="tanggal_sesi_awal[selesai]" class="form-control">
    </div>

        <div class="form-group">
            <label>Surat Peminjaman (PDF)</label>
            <input type="file" name="surat_peminjaman" accept="application/pdf" class="form-control" required>
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

        <div class="form-check mt-2">
            <input type="checkbox" name="butuh_livestream" value="1" class="form-check-input" id="checkLivestream">
            <label class="form-check-label" for="checkLivestream">Butuh Live Streaming ? (Opsional)</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="butuh_operator" value="1" class="form-check-input" id="checkOperator">
            <label class="form-check-label" for="checkOperator">Butuh Operator ? (Opsional)</label>
        </div>

        <div class="form-group" id="operatorSoundSection" style="display: none;">
            <label for="operator_sound">Operator Sound (Opsional)</label>
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
                label = 'Kapel';
                displayValue = "{{ $kapel->nama_ruang }}";
            } else if (name === 'surat_peminjaman' && value instanceof File) {
                displayValue = value.name;
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
