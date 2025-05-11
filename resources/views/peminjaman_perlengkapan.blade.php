@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Perlengkapan')

@section('peminjam_navigasi')
@endsection
@section('content')
<div class="container">
    <div class="row">

        {{-- Daftar Perlengkapan --}}
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Daftar Perlengkapan</div>
                <div class="card-body">

                    <input type="text" class="form-control mb-3" placeholder="Cari">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Nama Perlengkapan</th>
                                <th>Stok</th>
                                <th>Status Saat Ini</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perlengkapan as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama_perlengkapan }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>{{ $item->status_saat_ini }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm"
                                            onclick="tambahKeKeranjang('{{ $item->id_perlengkapan }}', '{{ $item->nama_perlengkapan }}')">+</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

        {{-- Daftar Perlengkapan Dipinjam --}}
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Daftar Perlengkapan Dipinjam</div>
                <div class="card-body">

                    <ul id="list-dipinjam" class="list-group mb-3">
                        {{-- Daftar perlengkapan akan muncul di sini --}}
                    </ul>

                    <form action="{{ url('/peminjaman_perlengkapan/kirimKeFormPeminjaman') }}" method="POST">
                        @csrf
                        <div id="input-perlengkapan-container">
                            {{-- Input hidden untuk ID perlengkapan akan ditambahkan di sini oleh JavaScript --}}
                        </div>
                        <button type="submit" class="btn btn-primary w-100" {{ count(session('id_perlengkapan_dipilih', [])) > 0 ? '' : 'disabled' }}>Selanjutnya</button>
                    </form>

                </div>
            </div>
        </div>


<div class="col-md-4 border rounded p-3 mb-3">
    <h4>Peminjaman Yang Akan Datang</h4>
    @forelse ($peminjamanPerKelompok as $peminjaman)
        <div class="card p-2 mb-2">
            <strong>Peminjaman ID: {{ $peminjaman['id_peminjaman_pkp'] ?? 'N/A' }}</strong><br>
            <strong>Nama Peminjam: {{ $peminjaman['nama_peminjam_pk'] ?? '' }}</strong><br>
            Tanggal Peminjaman:
            {{ isset($peminjaman['tanggal_mulai_pk']) ? \Carbon\Carbon::parse($peminjaman['tanggal_mulai_pk'])->format('d - M - Y') : '' }}
            ({{ isset($peminjaman['tanggal_mulai_pk']) ? \Carbon\Carbon::parse($peminjaman['tanggal_mulai_pk'])->format('H:i') : '' }} -
            {{ isset($peminjaman['tanggal_selesai_pk']) ? \Carbon\Carbon::parse($peminjaman['tanggal_selesai_pk'])->format('H:i') : '' }})<br>
            Kegiatan: {{ $peminjaman['nama_kegiatan_pk'] ?? '' }}<br>
            Perlengkapan:
            <ul>
                @foreach ($peminjaman['perlengkapan'] as $perlengkapan)
                    <li>{{ $perlengkapan }}</li>
                @endforeach
            </ul>
        </div>
    @empty
        <p>Belum ada peminjaman yang disetujui.</p>
    @endforelse
</div>


{{-- Script --}}
<script>
    let perlengkapanDipilih = [];

    // Load keranjang dari session saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const storedItems = sessionStorage.getItem('perlengkapanDipilih');
        if (storedItems) {
            perlengkapanDipilih = JSON.parse(storedItems);
            renderKeranjang();
        }
    });

    function tambahKeKeranjang(id_perlengkapan, nama) {
        id_perlengkapan = Number(id_perlengkapan);
        const sudahAda = perlengkapanDipilih.some(item => item.id_perlengkapan === id_perlengkapan);
        if (sudahAda) {
            alert('Perlengkapan sudah ditambahkan.');
            return;
        }

        perlengkapanDipilih.push({ id_perlengkapan, nama });
        renderKeranjang();
        sessionStorage.setItem('perlengkapanDipilih', JSON.stringify(perlengkapanDipilih)); // Simpan ke sessionStorage
    }

    function hapusDariKeranjang(id_perlengkapan) {
        id_perlengkapan = Number(id_perlengkapan);
        perlengkapanDipilih = perlengkapanDipilih.filter(item => item.id_perlengkapan !== id_perlengkapan);
        renderKeranjang();
        sessionStorage.setItem('perlengkapanDipilih', JSON.stringify(perlengkapanDipilih)); // Update sessionStorage
    }

    function renderKeranjang() {
        const list = document.getElementById('list-dipinjam');
        list.innerHTML = '';
        const inputContainer = document.getElementById('input-perlengkapan-container');
        inputContainer.innerHTML = ''; // Bersihkan input hidden sebelumnya

        perlengkapanDipilih.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${item.nama}
                <button class="btn btn-danger btn-sm" onclick="hapusDariKeranjang(${item.id_perlengkapan})">Batal</button>
            `;
            list.appendChild(li);

            // Tambahkan input hidden untuk setiap ID
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_perlengkapan_dipilih[]';
            input.value = item.id_perlengkapan;
            inputContainer.appendChild(input);
        });

        // Aktifkan atau nonaktifkan tombol "Selanjutnya" berdasarkan apakah ada item di keranjang
        const selanjutnyaButton = document.querySelector('button[type="submit"]');
        if (selanjutnyaButton) {
            selanjutnyaButton.disabled = perlengkapanDipilih.length === 0;
        }
    }
</script>
@endsection
