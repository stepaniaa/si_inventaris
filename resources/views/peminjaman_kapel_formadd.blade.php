@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Kapel Formadd ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container mt-4">
    <div class="card p-3 mb-4 shadow-sm border">
    <h2>Form Peminjaman : <strong>{{ $kapel->nama_ruang }}</strong></h2>
    <br>
    <div class="mb-4">
        <p><strong>Deskripsi:</strong> {{ $kapel->deskripsi_ruang ?? '-' }}</p>
        <p><strong>Kapasitas:</strong> {{ $kapel->kapasitas_ruang ?? '-' }}</p>
        <p><strong>Lokasi:</strong> {{ $kapel->lokasi_ruang ?? '-' }}</p>
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
    <label>
        Nomor Identitas Mahasiswa / Pekerja UKDW (NIM / NIP)
        @if ($kapel->id_ruang == 1)
            <span class="text-danger">*</span>
            <small class="text-muted">(Wajib untuk Kapel Atas)</small>
        @else
            <small class="text-muted">(Boleh dikosongkan untuk peminjam eksternal)</small>
        @endif
    </label>
    <input type="text" name="nomor_induk" class="form-control"
           placeholder="Contoh: 722020123 (NIM) atau 19780101 (NIP)"
           {{ $kapel->id_ruang == 1 ? 'required' : '' }}>
</div>

        <div class="form-group">
            <label>Nama Lengkap Anda<span class="text-danger">*</span></label>
            <input type="text" name="nama_peminjam" class="form-control" required>
        </div>

        <div class="form-group" id="asalUnitSection">
             <label for="asal_unit">Asal Instansi / Fakultas / Lembaga Anda<span class="text-danger">*</span></label>
                <select name="asal_unit" id="asal_unit" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="eksternal">Peminjam Eksternal (Non-UKDW)</option>
                <option value="fti">Fakultas Teknologi Informasi</option>
                <option value="fad">Fakultas Arsitektur dan Desain</option>
                <option value="fb">Fakultas Bisnis</option>
                <option value="fbio">Fakultas Bioteknologi</option>
                <option value="ft">Fakultas Teologi</option>
                <option value="fkh">Fakultas Kependidikan & Humaniora</option>
                <option value="fk">Fakultas Kedokteran</option>

            </select>
        </div>

        <div class="form-group" id="peranSection">
             <label for="peran">Status Anda sebagai Peminjam <span class="text-danger">*</span></label>
                <select name="peran" id="peran" class="form-control">
                <option value="" selected disabled>-- Pilih Opsi --</option>
                <option value="eksternal">Pihak Eksternal (Non-UKDW)</option>
                <option value="dosen">Dosen UKDW</option>
                <option value="pekerja">Staf / Pegawai UKDW</option>
                <option value="mahasiswa">Mahasiswa UKDW</option>
            </select>
        </div>

        <div class="form-group">
            <label>Kontak<span class="text-danger">*</span></label>
            <input type="text" name="kontak" class="form-control" required>
        </div>

       <div class="form-group">
    <label>Email<span class="text-danger">*</span></label>
    <input type="text" name="email" class="form-control" required
           pattern="[a-zA-Z0-9._%+-]+@ukdw\.ac\.id"
           title="Email harus menggunakan domain @ukdw.ac.id">
</div>

        <div class="form-group">
            <label>Nama Kegiatan<span class="text-danger">*</span></label>
            <input type="text" name="nama_kegiatan" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Keterangan Kegiatan<span class="text-danger">*</span></label>
            <textarea name="keterangan_kegiatan" class="form-control" required></textarea>
        </div>

        <div class="form-group">
    <label for="jumlah_kursi">Jumlah Kursi Dibutuhkan (boleh kosong jika tidak ada)</label>
    <input type="number" name="jumlah_kursi" id="jumlah_kursi" class="form-control" min="0" value="{{ old('jumlah_kursi') }}">
</div>

         <div class="form-group">
        <label>Tanggal & Waktu Mulai Peminjaman<span class="text-danger">*</span></label>
        <input type="datetime-local" name="tanggal_sesi_awal[mulai]" class="form-control">
        <small class="form-text text-muted">Waktu pertama kegiatan dimulai (bukan waktu persiapan atau reservasi ruang).</small>
    </div>
    <div class="form-group">
        <label>Tanggal & Waktu Selesai Peminjaman<span class="text-danger">*</span></label>
        <input type="datetime-local" name="tanggal_sesi_awal[selesai]" class="form-control">
        <small class="form-text text-muted">Waktu akhir kegiatan atau saat ruang dikembalikan.</small>
    </div>

        <div class="form-group">
            <label>Surat Peminjaman (PDF) <span class="text-danger">*</span></label>
            <input type="file" name="surat_peminjaman" accept="application/pdf" class="form-control" required>
            <small class="form-text text-muted">Surat resmi dari lembaga/organisasi peminjam (Maks 2MB)</small>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="rutin" value="1" id="rutinCheck" class="form-check-input" {{ old('rutin') ? 'checked' : '' }}>
            <label class="form-check-label" for="rutinCheck">Jadikan Peminjaman Ini Rutin?  (Opsional)</label>
        </div>
       <div id="rutinSection" style="display:none; margin-top: 1rem;">
    <div class="form-group">
        <label>Frekuensi Pengulangan <span class="text-danger">*</span></label>
        <small class="form-text text-muted">Pilih apakah kegiatan ini akan diulang setiap minggu atau bulan.</small>
        <select name="tipe_rutin" class="form-control">
            <option value="" disabled selected>-- Pilih Tipe Rutin --</option>
            <option value="mingguan">Mingguan</option>
            <option value="bulanan">Bulanan</option>
        </select>
    </div>
    <div class="form-group">
       <label>Jumlah Pengulangan <span class="text-danger">*</span></label>
       <small class="form-text text-muted">Contoh: 4 = kegiatan berlangsung selama 4 minggu/bulan.</small>
        <input type="number" name="jumlah_perulangan" class="form-control" min="1" value="1">
    </div>
</div>

        @if ($kapel->id_ruang == 1)
    <div class="form-check mt-2">
        <input type="checkbox" name="butuh_livestream" value="1" class="form-check-input" id="checkLivestream">
        <label class="form-check-label" for="checkLivestream">Butuh Fasilitas Live Streaming? (Opsional)</label>
    </div>
<br>
    <div class="form-check">
        <input type="checkbox" name="butuh_operator" value="1" class="form-check-input" id="checkOperator">
        <label class="form-check-label" for="checkOperator"> Butuh Operator Audio / Sound? (Opsional)</label>
    </div>
    <div class="form-group" id="operatorSoundSection" style="display: none;">
        <label for="operator_sound">Pilih Tipe Operator Sound</label>
        <select name="operator_sound" id="operator_sound" class="form-control">
            <option value="" selected disabled>-- Pilih Opsi --</option>
            <option value="LPKKSK">Operator sound dari Tim PKK Live</option>
            <option value="Penyelenggara">Operator sound dari penyelenggara kegiatan (Harus briefing terlebih dahulu)</option>
        </select>
    </div>
@endif
<br>
                <div class="form-group" id="buktiUKDWSection" style="display: none;">
        <label for="bukti_ukdw">Upload Bukti Sebagai Mahasiswa/Dosen/Staff UKDW (KTM/NIP)<span class="text-danger">*</span></label>
        <input type="file" name="bukti_ukdw" id="bukti_ukdw" class="form-control" accept="image/*,application/pdf">
        </div>

        <div class="form-check mt-3">
            <input type="checkbox" class="form-check-input" id="setujuSk" required>
            <label class="form-check-label" for="setujuSk">
                Saya setuju dengan <a href="#">Syarat & Ketentuan <span class="text-danger">*</span></a>.
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
    if (name === '_token') continue; // ⛔ Skip CSRF token

    let label = name.replace(/_/g, ' ').replace(/\[\]/g, '')
                    .split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');

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

    //menampilkan atribut bukti_ukdw jika peminjaman kapel atas
    document.addEventListener('DOMContentLoaded', function () {
    const idRuang = {{ $kapel->id_ruang }};
    const buktiSection = document.getElementById('buktiUKDWSection');
    const buktiInput = document.getElementById('bukti_ukdw');

    if (idRuang === 1) { // ID Kapel Atas
        buktiSection.style.display = 'block';
        buktiInput.required = true;
    } else {
        buktiSection.style.display = 'none';
        buktiInput.required = false;
    }
});
</script>
@endsection
