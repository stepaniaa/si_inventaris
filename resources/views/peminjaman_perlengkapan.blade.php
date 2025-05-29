@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Perlengkapan')

@section('peminjam_navigasi')
@endsection
@section('content')
<div class="container-fluid p-2"> {{-- Menggunakan container-fluid dan mengurangi padding --}}
    <div class="row">
            <div class="col-md-8">
            <div class="mb-3"> {{-- Berikan margin bawah pada judul dan peringatan --}}
                            @if (session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger mt-2">
        {{ session('error') }}
    </div>
@endif
                <h2><strong>Daftar Perlengkapan</strong></h2>
                <p class="mb-0">
                    <small><i><b>Penting:</b> Periksa jadwal peminjaman yang akan datang untuk menghindari bentrok jadwal.</i></small> {{-- Gunakan small dan kurangi margin bawah --}}
                </p>
                <p class="text-warning"><strong>*Hanya bisa dipinjam oleh civitas UKDW.</strong></p>
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
                                    <!--<th>Stok</th>
                                    <th>Status Saat Ini</th>-->
                                    <th class="text-center">Aksi</th> {{-- Menengahkan teks aksi --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perlengkapan as $index => $item)
                                <tr class="align-middle"> {{-- Menengahkan teks vertikal --}}
                                    <td>{{ $index + 1 }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->kode_perlengkapan }}</td> {{-- Menggunakan small --}}
                                    <td>{{ $item->nama_perlengkapan }}</td> {{-- Menggunakan small --}}
                                    <!--<td>{{ $item->stok_perlengkapan }}</td> {{-- Menggunakan small --}
                                    <td>{{ $item->status_saat_ini }}</td> {{-- Menggunakan small --}}-->
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

        {{-- Daftar Peminjaman yang Akan Datang --}}
<div class="mt-5">
    <h4>Peminjaman Yang Akan Datang</h4>

    {{-- Filter --}}
    <div class="mb-3 d-flex gap-2 flex-wrap">
        <input type="text" id="filterBarang" placeholder="Filter kode/nama barang" class="form-control" onkeyup="filterTable()" >

        <input type="month" id="filterBulan" class="form-control" onchange="filterTable()">
    </div>

    @if($peminjamansAkanDatang->isEmpty())
        <p>Tidak ada peminjaman yang akan datang</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="peminjamanTable">
                <thead>
                    <tr>
                         <th>ID Peminjaman</th>
                        <th>Nama Kegiatan</th>
                        <th>Perlengkapan</th>
                        <th>Tanggal Mulai Sesi</th>
                        <th>Tanggal Selesai Sesi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjamansAkanDatang as $p)
                        @foreach($p->sesi as $sesi)
                            <tr>
                                <td>{{ $p->id_peminjaman_pkp }}</td>
                                <td>{{ $p->nama_kegiatan_pk }}</td>
                               
                                <td>
                                    @foreach($p->perlengkapan as $item)
                                        <div data-kode="{{ $item->kode_perlengkapan ?? '' }}">
                                            {{ $item->nama_perlengkapan }} ({{ $item->kode_perlengkapan ?? '-' }})
                                        </div>
                                    @endforeach
                                </td>
                                <td>{{ \Carbon\Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex justify-content-center mt-2">
    {{ $peminjamansAkanDatang->links() }}
</div>
            
        </div>
        
        
    @endif
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

    function filterTable() {
        const filterBarang = document.getElementById('filterBarang').value.toLowerCase();
        const filterBulan = document.getElementById('filterBulan').value; // format yyyy-mm

        const table = document.getElementById('peminjamanTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const tdPerlengkapan = tr[i].getElementsByTagName('td')[2];
            const tdTanggalMulai = tr[i].getElementsByTagName('td')[3];
            const tdTanggalSelesai = tr[i].getElementsByTagName('td')[4];

            if (tdPerlengkapan && tdTanggalMulai && tdTanggalSelesai) {
                const perlengkapanText = tdPerlengkapan.textContent.toLowerCase();
                const tanggalMulai = tdTanggalMulai.textContent; // format yyyy-mm-dd
                const tanggalSelesai = tdTanggalSelesai.textContent;

                // Filter kode/nama barang (cek substring)
                const filterBarangMatch = perlengkapanText.includes(filterBarang);

                // Filter bulan
                // Ambil bulan-tahun dari tanggal mulai dan selesai sesi (yyyy-mm)
                const bulanMulai = tanggalMulai.slice(0, 7);
                const bulanSelesai = tanggalSelesai.slice(0, 7);

                const filterBulanMatch = !filterBulan || bulanMulai === filterBulan || bulanSelesai === filterBulan;

                if (filterBarangMatch && filterBulanMatch) {
                    tr[i].style.display = '';
                } else {
                    tr[i].style.display = 'none';
                }
            }
        }
    }
</script>
@endsection