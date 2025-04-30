@extends('layout.peminjam_main')
@section('title', 'siinventaris - Peminjaman Ruang ')
@section('peminjam_navigasi')
@endsection
@section('content')

<div class="card mt-4">
    <div class="card-body">
        <h3 class="mb-4">Daftar Ruang yang Dapat Dipinjam</h3>
        <div class="row">
            @foreach ($ruangs as $ruang)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $ruang->nama_ruang }}</h5>
                            <p class="card-text">
                                <strong>Kode:</strong> {{ $ruang->kode_ruang }}
                            </p>
                            <p class="card-text">
                                <strong>Fasilitas:</strong> {{ $ruang->fasilitas_ruang }}
                            </p>
                            <p class="card-text">
                                <strong>Kapasitas:</strong> {{ $ruang->kapasitas_ruang }}
                            </p>
                            <p class="card-text">
                                <strong>Status Saat Ini:</strong>
                                <span class="{{ $ruang->status_saat_ini == 'Tersedia' ? 'text-success' : 'text-danger' }}">
                                    {{ $ruang->status_saat_ini }}
                                </span>
                            </p>
                            <p class="card-text">
                                <strong>Terbooking Pada (Bulan Ini):</strong>
                                @if ($terbooking[$ruang->id_ruang] ?? null)
                                    <ul>
                                        @foreach ($terbooking[$ruang->id_ruang] as $booking)
                                            <li>{{ $booking }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    Belum ada booking
                                @endif
                            </p>
                            <a
                                href="/peminjaman_ruang/peminjaman_ruang_formadd/{{ $ruang->id_ruang }}"
                                class="btn btn-primary"
                                role="button"
                            >
                                <i class="bi bi-plus-square-fill"></i>
                                Ajukan Peminjaman
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
