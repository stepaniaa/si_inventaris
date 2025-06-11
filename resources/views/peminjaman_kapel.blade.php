@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Kapel ')
@section('peminjam_navigasi')
@endsection

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
         <div class="card p-4 mb-4">
         <h5 class="mb-3"><strong>Daftar Kapel</strong></h5>
        <p class="text-muted"><em><strong>Penting:</strong> Periksa jadwal peminjaman yang akan datang untuk menghindari bentrok jadwal.</em></p>


            @if (session('success'))
                <div class="alert alert-success mt-2">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-2">{{ session('error') }}</div>
            @endif

            <div class="row mb-4">
        @foreach ($kapel as $k)
        <div class="col-md-6 mb-3">
            <div class="card h-100 shadow-sm p-3" style="border-radius: 10px;">
                <div class="d-flex align-items-center">
                @php
    $gambar = $k->id_ruang == 1 ? 'kapeldw.jpeg' : 'prayerrooms.jpeg';
@endphp
<img src="{{ asset('images/' . $gambar) }}" alt="Kapel" width="120" height="100" class="rounded me-3" style="object-fit: cover;">

                    <div class="flex-grow-1">
                        <h5 class="mb-1"><strong>{{ $k->nama_ruang }}</strong></h5>
                         @if ($k->id_ruang == 1)
                    <p class="text-warning"><strong>*Hanya bisa dipinjam oleh civitas UKDW.</strong></p>
                @else
                    <p class="text-success"><strong>*Bisa dipinjam oleh umum/non-UKDW.</strong></p>
                @endif
                        <p class="mb-0">Deskripsi : {{ $k->deskripsi_ruang ?? '-' }}</p>
                        <p class="mb-0">Kapasitas : {{ $k->kapasitas_ruang ?? '-' }}</p>
                        <p class="mb-0">Lokasi : {{ ucfirst($k->lokasi_ruang?? '-') }}</p>
                        
                    </div>
                    <div>
                        <a href="/peminjaman_kapel/peminjaman_kapel_formadd/{{ $k->id_ruang }}" class="btn btn-primary">
                            Ajukan Peminjaman
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- TABEL PEMINJAMAN YANG AKAN DATANG --}}
    <div class="card shadow-sm p-3 mb-5" style="border-radius: 10px;">
        <h5 class="mb-3 text-black"><strong>Tabel Peminjaman yang Akan Datang</strong></h5>
        {{-- MODIFIED: Tambah form filter frontend --}}
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="bulanFilter">Filter Bulan</label>
                        <select id="bulanFilter" class="form-control">
                            <option value="">-- Semua Bulan --</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="kapelFilter">Filter Kapel</label>
                        <select id="kapelFilter" class="form-control">
                            <option value="">-- Semua Kapel --</option>
                            @foreach ($kapel as $k)
                                <option value="{{ $k->nama_ruang }}">{{ $k->nama_ruang }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- END MODIFIED --}}
        @if (count($jadwal) > 0)
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>No</th>
                        <th>Nama Kegiatan</th>
                        <th>Kapel</th>
                        <th>Tanggal & Waktu Mulai</th>
                        <th>Tanggal & Waktu Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($jadwal as $index => $j)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $j['nama_kegiatan'] }}</td>
                        <td>{{ $j['kapel'] }}</td>
                        <td>{{ $j['tanggal_mulai'] }}</td>
<td>{{ $j['tanggal_selesai'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
            <p class="text-muted">Belum ada peminjaman yang akan datang.</p>
        @endif
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bulanFilter = document.getElementById('bulanFilter');
        const kapelFilter = document.getElementById('kapelFilter');

        const filterTable = () => {
            const selectedBulan = bulanFilter.value;
            const selectedKapel = kapelFilter.value.toLowerCase();

            const rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                const tanggalText = row.children[3].textContent.trim();
                const kapelText = row.children[2].textContent.trim().toLowerCase();

                const tanggalObj = new Date(tanggalText);
                const rowBulan = tanggalObj.getMonth() + 1;

                const matchBulan = !selectedBulan || rowBulan == selectedBulan;
                const matchKapel = !selectedKapel || kapelText.includes(selectedKapel);

                row.style.display = (matchBulan && matchKapel) ? '' : 'none';
            });
        };

        bulanFilter.addEventListener('change', filterTable);
        kapelFilter.addEventListener('change', filterTable);
    });
</script>
@endsection