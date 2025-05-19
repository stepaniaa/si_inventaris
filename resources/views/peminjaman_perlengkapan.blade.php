@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Perlengkapan')

@section('peminjam_navigasi')
@endsection
@section('content')
<div class="container-fluid p-2"> {{-- Menggunakan container-fluid dan mengurangi padding --}}
    <div class="row">
            <div class="col-md-8">
            <div class="mb-3"> {{-- Berikan margin bawah pada judul dan peringatan --}}
                <h4 class="mb-1">Daftar Perlengkapan</h4> {{-- Kurangi margin bawah pada judul --}}
                <p class="mb-0">
                    <small><i><b>Penting:</b> Periksa jadwal peminjaman yang akan datang untuk menghindari bentrok jadwal.</i></small> {{-- Gunakan small dan kurangi margin bawah --}}
                </p>
            </div>
            <div class="card">
                <div class="card-header py-2"> {{-- Mengurangi padding atas dan bawah header --}}
                    <h6 class="fw-bold">Daftar Perlengkapan</h6> {{-- Menggunakan small dan fw-bold untuk judul --}}
                </div>
                <div class="card-body p-2"> {{-- Mengurangi padding dalam body card --}}
                    <input type="text" class="form-control form-control-sm mb-2" placeholder="Cari"> {{-- Menggunakan form-control-sm dan mengurangi margin bawah --}}
                    <div class="table-responsive"> {{-- Menambahkan responsive table --}}
                        <table class="table table-sm table-bordered"> {{-- Menggunakan table-sm dan table-bordered --}}
                            <thead>
                                <tr class="align-middle"> {{-- Menengahkan teks vertikal --}}
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Perlengkapan</th>
                                    <th>Stok</th>
                                    <th>Status Saat Ini</th>
                                    <th class="text-center">Aksi</th> {{-- Menengahkan teks aksi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perlengkapan as $index => $item)
                                <tr class="align-middle"> {{-- Menengahkan teks vertikal --}}
                                    <td>{{ $index + 1 }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->kode_perlengkapan }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->nama_perlengkapan }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->stok_perlengkapan }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->status_saat_ini }}</td> {{-- Menggunakan small --}}
                                    <td class="text-center"> {{-- Menengahkan tombol --}}
                                        <button class="btn btn-success btn-sm py-0 px-1" {{-- Mengurangi padding tombol --}}
                                            onclick="tambahKeKeranjang('{{ $item->id_perlengkapan }}', '{{ $item->nama_perlengkapan }}')">+</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Perlengkapan Dipinjam --}}
        <div class="col-md-4 mb-2 pl-1"> {{-- Mengurangi margin bawah dan padding kiri --}}
            <div class="card">
                <div class="card-header py-2"> {{-- Mengurangi padding atas dan bawah header --}}
                    <h6 class="fw-bold">Daftar Perlengkapan Dipinjam</h6> {{-- Menggunakan small dan fw-bold untuk judul --}}
                </div>
                <div class="card-body p-2"> {{-- Mengurangi padding dalam body card --}}
                    <ul id="list-dipinjam" class="list-group list-group-flush mb-2"> {{-- Mengurangi margin bawah list dan menggunakan flush --}}
                        {{-- Daftar perlengkapan akan muncul di sini --}}
                    </ul>
                    <form action="{{ url('/peminjaman_perlengkapan/kirimKeFormPeminjaman') }}" method="POST">
                        @csrf
                        <div id="input-perlengkapan-container">
                            {{-- Input hidden untuk ID perlengkapan akan ditambahkan di sini oleh JavaScript --}}
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-1" {{ count(session('id_perlengkapan_dipilih', [])) > 0 ? '' : 'disabled' }}>Selanjutnya</button> {{-- Menggunakan btn-sm dan mengurangi padding tombol --}}
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Script --}}
<script>
    let perlengkapanDipilih = [];

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
        sessionStorage.setItem('perlengkapanDipilih', JSON.stringify(perlengkapanDipilih));
    }

    function hapusDariKeranjang(id_perlengkapan) {
        id_perlengkapan = Number(id_perlengkapan);
        perlengkapanDipilih = perlengkapanDipilih.filter(item => item.id_perlengkapan !== id_perlengkapan);
        renderKeranjang();
        sessionStorage.setItem('perlengkapanDipilih', JSON.stringify(perlengkapanDipilih));
    }

    function renderKeranjang() {
        const list = document.getElementById('list-dipinjam');
        list.innerHTML = '';
        const inputContainer = document.getElementById('input-perlengkapan-container');
        inputContainer.innerHTML = '';

        perlengkapanDipilih.forEach(item => {
            const li = document.createElement('li');
            li.className = 'list-group-item list-group-item-action d-flex justify-content-between align-items-center p-1'; {{-- Mengurangi padding list item --}}
            li.innerHTML = `
                <small>${item.nama}</small> {{-- Menggunakan small --}}
                <button class="btn btn-danger btn-sm py-0 px-1" onclick="hapusDariKeranjang(${item.id_perlengkapan})">Batal</button> {{-- Mengurangi padding tombol --}}
            `;
            list.appendChild(li);

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id_perlengkapan_dipilih[]';
            input.value = item.id_perlengkapan;
            inputContainer.appendChild(input);
        });

        const selanjutnyaButton = document.querySelector('button[type="submit"]');
        if (selanjutnyaButton) {
            selanjutnyaButton.disabled = perlengkapanDipilih.length === 0;
        }
    }
</script>
@endsection