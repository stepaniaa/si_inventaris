@extends('layout.peminjam_main')
@section('title', 'Form Peminjaman Perlengkapan')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">Form Peminjaman Perlengkapan</h3>

    <form action="{{ url('/peminjaman_perlengkapan/save_peminjaman_perlengkapan') }}" method="POST" enctype="multipart/form-data" id="formPeminjaman">
        @csrf

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{!! $error !!}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Daftar Perlengkapan Dipilih --}}
        <div class="card mb-3">
            <div class="card-header"><strong>Daftar Perlengkapan</strong></div>
            <div class="card-body">
                @foreach ($perlengkapan as $item)
                    <input type="hidden" name="id_perlengkapan[]" value="{{ $item->id_perlengkapan }}">
                    <p class="mb-1">{{ $item->nama_perlengkapan }}</p>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <label>Nomor Induk</label>
            <input type="text" class="form-control" value="{{ $user->nim ?? 'non-ukdw' }}" readonly>
        </div>

        <div class="form-group">
            <label>Nama Peminjam</label>
            <input type="text" class="form-control" value="{{ $user->name }}" readonly>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" value="{{ $user->email }}" readonly>
        </div>

        <div class="form-group">
            <label>Asal Unit</label>
            <input type="text" class="form-control" value="{{ $user->asal_unit ?? 'bukan UKDW' }}" readonly>
        </div>

        <div class="form-group">
            <label>Peran</label>
            <input type="text" class="form-control" value="{{ $user->peran ?? 'bukan UKDW' }}" readonly>
        </div>

        <div class="form-group">
            <label for="kontak_pk">Kontak <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="kontak_pk" required>
        </div>

        <div class="form-group">
            <label for="nama_kegiatan_pk">Nama Kegiatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="nama_kegiatan_pk" required>
        </div>

        <div class="form-group">
            <label for="lokasi_kegiatan_pk">Lokasi Kegiatan <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="lokasi_kegiatan_pk" required>
        </div>

        <div class="form-group">
            <label for="keterangan_kegiatan_pk">Keterangan Kegiatan (Opsional)</label>
            <textarea class="form-control" name="keterangan_kegiatan_pk"></textarea>
        </div>

        <div class="form-group">
            <label>Tanggal & Waktu Mulai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="tanggal_sesi_awal[mulai]" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Tanggal & Waktu Selesai <span class="text-danger">*</span></label>
            <input type="datetime-local" name="tanggal_sesi_awal[selesai]" class="form-control" required>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="rutin" value="1" id="rutinCheck" class="form-check-input" {{ old('rutin') ? 'checked' : '' }}>
            <label class="form-check-label" for="rutinCheck">Peminjaman Rutin? (Opsional)</label>
        </div>

        <div id="rutinSection" style="display:none;">
            <div class="form-group">
                <label>Tipe Rutin <span class="text-danger">*</span></label>
                <select name="tipe_rutin" class="form-control">
                    <option value="" disabled selected>-- Pilih --</option>
                    <option value="mingguan">Mingguan</option>
                    <option value="bulanan">Bulanan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Jumlah Perulangan <span class="text-danger">*</span></label>
                <input type="number" name="jumlah_perulangan" class="form-control" min="1" value="1">
            </div>
        </div>

        <div class="form-group">
            <label>Upload Surat Peminjaman (PDF, maks 2MB)</label>
            <input type="file" class="form-control" name="surat_peminjaman_pk" accept="application/pdf">
        </div>

        <div class="form-check mt-3">
            <input type="checkbox" class="form-check-input" id="setujuSk" required>
            <label class="form-check-label" for="setujuSk">
                Saya telah membaca dan menyetujui <a href="#">syarat & ketentuan peminjaman</a> <span class="text-danger">*</span>
            </label>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Ajukan Peminjaman</button>
    </form>
</div>

<script>
    document.getElementById('rutinCheck').addEventListener('change', function () {
        document.getElementById('rutinSection').style.display = this.checked ? 'block' : 'none';
    });

    document.getElementById('formPeminjaman').addEventListener('submit', function (e) {
        const checkbox = document.getElementById('setujuSk');
        if (!checkbox.checked) {
            e.preventDefault();
            alert('Anda harus menyetujui syarat dan ketentuan.');
        }
    });
</script>
@endsection
