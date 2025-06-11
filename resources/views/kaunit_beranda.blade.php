@extends('layout.staff_main')
@section('title', 'siinventaris - Kepala Unit - Dashboard') 
@section('kaunit_navigasi')

@section('content')

@php
    $cards = [];

    // Menambahkan kartu untuk Inventaris
    $cards[] = ['section' => 'Inventaris'];
    $cards[] = ['label' => 'Jumlah Ruang Aktif', 'count' => $jumlah_ruang, 'icon' => 'fa-door-open'];
    $cards[] = ['label' => 'Jumlah Perlengkapan Aktif', 'count' => $jumlah_perlengkapan, 'icon' => 'fa-boxes'];
    $cards[] = ['label' => 'Jumlah Staf Aktif', 'count' => $jumlah_user, 'icon' => 'fa-users'];

    // Menambahkan kartu untuk Usulan Barang
    $cards[] = ['section' => 'Usulan Pengadaan, Perbaikan atau Penghapusan Perlengkapan'];
    $cards[] = ['label' => 'Usulan Pengadaan (Menunggu)', 'count' => $jumlah_pengadaan, 'icon' => 'fa-file-signature', 'link' => url('/kaunit_usulan_pengadaan')];
    $cards[] = ['label' => 'Usulan Perbaikan (Menunggu)', 'count' => $jumlah_perbaikan, 'icon' => 'fa-tools', 'link' => url('/kaunit_usulan_perbaikan')];
    $cards[] = ['label' => 'Usulan Penghapusan(Menunggu)', 'count' => $jumlah_penghapusan, 'icon' => 'fa-trash', 'link' => url('/kaunit_usulan_penghapusan')];

    // Menambahkan kartu untuk Peminjaman Akan Datang
    $cards[] = ['section' => 'Status Peminjaman Fasilitas'];
    $cards[] = ['label' => 'Peminjaman Kapel (Menunggu)', 'count' => $jumlah_peminjaman_kpl_wait, 'icon' => 'fa-hourglass-half', 'link' => url('/staff_peminjaman_kapel')];
    $cards[] = ['label' => 'Peminjaman Perlengkapan (Menunggu)', 'count' => $jumlah_peminjaman_pkp_wait, 'icon' => 'fa-clipboard-list', 'link' => url('/staff_peminjaman_perlengkapan')];
    $cards[] = ['label' => 'Peminjaman Perlengkapan (Aktif)', 'count' => $jumlah_peminjaman_pkp, 'icon' => 'fa-calendar-check', 'link' => url('/staff_pengembalian_pkp')];
    $cards[] = ['label' => 'Peminjaman Kapel (Aktif)', 'count' => $jumlah_peminjaman_kapel, 'icon' => 'fa-church', 'link' => url('/staff_pengembalian_kapel')];
   

@endphp

<div class="row">
    @foreach ($cards as $card)
        @if(isset($card['section']))
            <div class="col-12 mt-4 mb-2">
                <h5 class="text-uppercase text-muted">{{ $card['section'] }}</h5>
            </div>
        @else
            <div class="col-md-3 col-sm-6 mb-4">
                <div class="card text-white bg-info h-100 shadow-sm">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title">{{ $card['label'] }}</h6>
                            <h3>{{ $card['count'] }}</h3>
                        </div>
                        <i class="fas {{ $card['icon'] }} fa-2x"></i>
                    </div>

                    <div class="card-footer bg-light text-center">
                        @isset($card['link'])
                            <a href="{{ $card['link'] }}" class="text-info font-weight-bold">Lihat detail</a>
                        @endisset
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

@endsection
