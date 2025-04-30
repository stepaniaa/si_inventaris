@extends('layout.staff_main')
@section('title', 'Validasi Peminjaman Ruang')
@section('staff_navigasi')
@endsection
@section('content')

<div class="container mt-5">
    <h1>Validasi Peminjaman Ruang</h1>

    <div class="card">
        <div class="card-body">
            <form action="/staff_daftar_peminjaman/save_validasi_peminjaman/{{ $peminjaman->id_peminjaman}}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="nomor_induk">Nomor Induk:</label>
                    <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ $peminjaman->nomor_induk }}" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_peminjam">Nama Peminjam:</label>
                    <input type="text" class="form-control" id="nama_peminjam" name="nama_peminjam" value="{{ $peminjaman->nama_peminjam }}" readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $peminjaman->email }}" readonly>
                </div>

                <div class="form-group">
                    <label for="nomor_telpon">Nomor Telepon:</label>
                    <input type="text" class="form-control" id="nomor_telpon" name="nomor_telpon" value="{{ $peminjaman->nomor_telpon }}" readonly>
                </div>

                <div class="form-group">
                    <label for="status_peminjam">Status Peminjam:</label>
                    <input type="text" class="form-control" id="status_peminjam" name="status_peminjam" value="{{ $peminjaman->status_peminjam }}" readonly>
                </div>

                <div class="form-group">
                    <label for="asal_unit">Asal Unit:</label>
                    <input type="text" class="form-control" id="asal_unit" name="asal_unit" value="{{ $peminjaman->asal_unit }}" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_kegiatan">Nama Kegiatan:</label>
                    <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" value="{{ $peminjaman->nama_kegiatan }}" readonly>
                </div>

                <div class="form-group">
                    <label for="kegunaan_peminjaman">Kegunaan Peminjaman:</label>
                    <textarea class="form-control" id="kegunaan_peminjaman" name="kegunaan_peminjaman" rows="3" readonly>{{ $peminjaman->kegunaan_peminjaman }}</textarea>
                </div>

                <div class="form-group">
                    <label for="tanggal_mulai">Tanggal Mulai:</label>
                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ $peminjaman->tanggal_mulai }}" readonly>
                </div>

                <div class="form-group">
                    <label for="tanggal_selesai">Tanggal Selesai:</label>
                    <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="{{ $peminjaman->tanggal_selesai }}" readonly>
                </div>

                <div class="form-group">
                    <label for="pukul_mulai">Pukul Mulai:</label>
                    <input type="time" class="form-control" id="pukul_mulai" name="pukul_mulai" value="{{ $peminjaman->pukul_mulai }}" readonly>
                </div>

                <div class="form-group">
                    <label for="pukul_selesai">Pukul Selesai:</label>
                    <input type="time" class="form-control" id="pukul_selesai" name="pukul_selesai" value="{{ $peminjaman->pukul_selesai }}" readonly>
                </div>

                <div class="form-group">
                    <label for="surat_peminjaman">Surat Peminjaman:</label>
                     @if ($peminjaman->surat_peminjaman)
                        <a href="{{ asset('storage/surat_peminjaman/' . $peminjaman->surat_peminjaman) }}" target="_blank" class="btn btn-primary">Lihat Surat Peminjaman</a>
                     @else
                        <p>Tidak ada surat peminjaman yang diunggah.</p>
                     @endif
                </div>

                <div class="form-group">
                    <label for="id_ruang">Ruang yang Dipinjam:</label>
                    <input type="text" class="form-control"  value="{{ $peminjaman->id_ruang}}" readonly>
                </div>

                <div class="form-group">
                    <label for="status_peminjaman">Status Peminjaman:</label>
                    <select class="form-control" id="status_peminjaman" name="status_peminjaman" required>
                        <option value="diproses" {{ $peminjaman->status_peminjaman == 'diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="diterima" {{ $peminjaman->status_peminjaman == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ $peminjaman->status_peminjaman == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Persetujuan</button>
                <a href="/staff_daftar_peminjaman" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
