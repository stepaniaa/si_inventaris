@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Perlengkapan')
@section('peminjam_navigasi')
@endsection
@section('content')
@php use Carbon\Carbon; @endphp
<div class="container mt-4">
    <h4><strong>Daftar Perlengkapan</strong></h4>
    <p class="mb-1 text-muted"><em><strong>Penting:</strong> Periksa jadwal peminjaman yang akan datang untuk menghindari bentrok jadwal.</em></p>
    <p class="text-warning font-weight-bold">*Hanya bisa dipinjam oleh civitas UKDW.</p>
  @if (session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif

    <div class="row">
        
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-header">Daftar Perlengkapan</div>
                <div class="card-body">
                    <input type="text" class="form-control form-control-sm mb-2" placeholder="Cari">
                    <div class="table-responsive">
                         <table class="table table-striped table-bordered">
                            <thead>
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Perlengkapan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perlengkapan as $index => $item)
                                <tr class="align-middle text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->kode_perlengkapan }}</td>
                                    <td class="text-left">{{ $item->nama_perlengkapan }}</td>
                                    <td>
                                        <button class="btn btn-success btn-sm py-0 px-1" onclick="tambahKeKeranjang('{{ $item->id_perlengkapan }}', '{{ $item->nama_perlengkapan }}')">+</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Daftar Perlengkapan Dipinjam</div>
                <div class="card-body">
                    <ul id="list-dipinjam" class="list-group list-group-flush mb-2"></ul>
                    <form action="{{ url('/peminjaman_perlengkapan/kirimKeFormPeminjaman') }}" method="POST">
                        @csrf
                        <div id="input-perlengkapan-container"></div>
                        <button type="submit" class="btn btn-primary btn-sm w-100 py-1" {{ count(session('id_perlengkapan_dipilih', [])) > 0 ? '' : 'disabled' }}>Selanjutnya</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

   <div class="card shadow-sm p-3 mb-5" style="border-radius: 10px;">
    <h5 class="mb-3 text-black"><strong>Tabel Peminjaman yang Akan Datang</strong></h5>

    <div class="mb-3 row g-2 align-items-end">
        <div class="col-md-6">
            <label for="filterBarang" class="form-label"><strong>Filter Nama/Kode Barang</strong></label>
            <input type="text" id="filterBarang" placeholder="Contoh: Kamera / BR06" class="form-control" onkeyup="filterTable()">
        </div>
        <div class="col-md-6">
            <label for="filterBulan" class="form-label"><strong>Filter Bulan</strong></label>
            <input type="month" id="filterBulan" class="form-control" onchange="filterTable()">
        </div>
 

    {{-- lanjut dengan tabel atau konten lainnya --}}
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
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Selesai</th>
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
                                <td>{{ Carbon::parse($sesi->tanggal_mulai_sesi)->format('Y-m-d H:i') }}</td>
                                <td>{{ Carbon::parse($sesi->tanggal_selesai_sesi)->format('Y-m-d H:i') }}</td>
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

{{-- JavaScript untuk filter dan keranjang --}}
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
            li.className = 'list-group-item d-flex justify-content-between align-items-center p-1';
            li.innerHTML = `
                <small>${item.nama}</small>
                <button class="btn btn-danger btn-sm py-0 px-1" onclick="hapusDariKeranjang(${item.id_perlengkapan})">Batal</button>
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
        const filterBulan = document.getElementById('filterBulan').value;

        const table = document.getElementById('peminjamanTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) {
            const tdPerlengkapan = tr[i].getElementsByTagName('td')[2];
            const tdTanggalMulai = tr[i].getElementsByTagName('td')[3];
            const tdTanggalSelesai = tr[i].getElementsByTagName('td')[4];

            if (tdPerlengkapan && tdTanggalMulai && tdTanggalSelesai) {
                const perlengkapanText = tdPerlengkapan.textContent.toLowerCase();
                const tanggalMulai = tdTanggalMulai.textContent;
                const tanggalSelesai = tdTanggalSelesai.textContent;

                const filterBarangMatch = perlengkapanText.includes(filterBarang);
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
