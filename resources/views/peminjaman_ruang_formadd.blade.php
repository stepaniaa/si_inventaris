@extends('layout.peminjam_main')
@section('title', 'siinventaris - Tambah Peminjaman Ruang')
@section('content')

<h1>Form Tambah Peminjaman Ruang</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/peminjaman_ruang/save_peminjaman_ruang" method="POST" enctype="multipart/form-data">
    @csrf

    <h2 class="mt-4">Data Peminjam</h2>

    <div class="form-group">
        <label for="id_ruang">Ruang yang Dipinjam:</label>
        @if ($selectedRuang)
            <input type="text" class="form-control"  value="{{ $selectedRuang->nama_ruang }}" readonly>
            <input type="hidden" name="id_ruang" value="{{ $selectedRuang->id_ruang }}">
        @else
            <select class="form-control"  name="id_ruang">
                <option value="">-- Pilih Ruang (Opsional) --</option>
                @foreach ($ruangs as $ruang)
                    <option value="{{ $ruang->id_ruang }}">{{ $ruang->nama_ruang }}</option>
                @endforeach
            </select>
        @endif
    </div>
    
    <div class="form-group">
        <label for="nomor_induk">Nomor Induk:</label>
        <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ old('nomor_induk') }}" required>
    </div>

    <div class="form-group">
        <label for="nama_peminjam">Nama Peminjam:</label>
        <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ old('nama_peminjam') }}" required>
    </div>

    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
    </div>

    <div class="form-group">
        <label for="nomor_telpon">Nomor Telepon:</label>
        <input type="text" class="form-control" id="nomor_telpon" name="nomor_telpon" value="{{ old('nomor_telpon') }}" required>
    </div>

    <div class="form-group">
        <label for="status_peminjam">Status Peminjam:</label>
        <select class="form-control" id="status_peminjam" name="status_peminjam" required>
            <option value="mahasiswa" {{ old('status_peminjam') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
            <option value="dosen" {{ old('status_peminjam') == 'dosen' ? 'selected' : '' }}>Dosen</option>
            <option value="staff" {{ old('status_peminjam') == 'staff' ? 'selected' : '' }}>Staff</option>
        </select>
    </div>

    <div class="form-group">
        <label for="asal_unit">Asal Unit:</label>
        <select class="form-control" id="asal_unit" name="asal_unit" required>
            <option value="">-- Pilih Asal Unit --</option>
            <option value="Fakultas Teknologi Informasi" {{ old('asal_unit') == 'Fakultas Teknologi Informasi' ? 'selected' : '' }}>Fakultas Teknologi Informasi</option>
            <option value="Fakultas Kedokteran" {{ old('asal_unit') == 'Fakultas Kedokteran' ? 'selected' : '' }}>Fakultas Kedokteran</option>
            <option value="Fakultas Bisnis" {{ old('asal_unit') == 'Fakultas Bisnis' ? 'selected' : '' }}>Fakultas Bisnis</option>
            <option value="Fakultas Arsitektur dan Desain" {{ old('asal_unit') == 'Fakultas Arsitektur dan Desain' ? 'selected' : '' }}>Fakultas Arsitektur dan Desain</option>
        </select>
    </div>

    <h2 class="mt-4">Detail Kegiatan</h2>
    <div class="form-group">
        <label for="nama_kegiatan">Nama Kegiatan:</label>
        <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" required>
    </div>

    <div class="form-group">
        <label for="kegunaan_peminjaman">Kegunaan Peminjaman:</label>
        <textarea class="form-control" id="kegunaan_peminjaman" name="kegunaan_peminjaman" rows="3" required>{{ old('kegunaan_peminjaman') }}</textarea>
    </div>

    <div class="form-group">
        <label for="tanggal_mulai">Tanggal Mulai:</label>
        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required>
    </div>

    <div class="form-group">
        <label for="tanggal_selesai">Tanggal Selesai:</label>
        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required>
    </div>

    <div class="form-group">
        <label for="pukul_mulai">Pukul Mulai:</label>
        <input type="time" class="form-control" id="pukul_mulai" name="pukul_mulai" value="{{ old('pukul_mulai') }}" required>
    </div>

    <div class="form-group">
        <label for="pukul_selesai">Pukul Selesai:</label>
        <input type="time" class="form-control" id="pukul_selesai" name="pukul_selesai" value="{{ old('pukul_selesai') }}" required>
    </div>

    <div class="form-group">
        <label for="surat_peminjaman">Surat Peminjaman (PDF):</label>
        <input type="file" class="form-control" id="surat_peminjaman" name="surat_peminjaman" accept="application/pdf" required>
        <small class="form-text text-muted">Format file harus PDF, maksimal 2MB.</small>
    </div>

    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="setuju_sk" name="setuju_sk">
        <label class="form-check-label" for="setuju_sk">Saya menyetujui S&K peminjaman</label>
    </div>

    <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Simpan Peminjaman</button>
    <a href="/peminjaman_ruang" class="btn btn-secondary">Batal</a>

    <script>
        const setujuSkCheckbox = document.getElementById('setuju_sk');
        const submitBtn = document.getElementById('submitBtn');


        function updateSubmitButtonState() {
            submitBtn.disabled = !setujuSkCheckbox.checked;
        }

        setujuSkCheckbox.addEventListener('change', updateSubmitButtonState);


        // Pastikan tombol disabled saat halaman pertama kali dimuat jika checkbox tidak dicentang
        updateSubmitButtonState();
    </script>
</form>

@endsection
