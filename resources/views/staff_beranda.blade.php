@extends('layout.staff_main')

@section('title', 'siinventaris - Beranda')

@section('staff_navigasi')
@endsection

@section('content')

    @php
    $cards = [];

    // Menambahkan kartu untuk Inventaris
    $cards[] = ['section' => 'Inventaris'];
        $cards[] = ['label' => 'Kategori', 'count' => $jumlah_kategori, 'icon' => 'fa-door-open'];
    $cards[] = ['label' => 'Kapel', 'count' => $jumlah_ruang, 'icon' => 'fa-door-open'];
    $cards[] = ['label' => 'Perlengkapan', 'count' => $jumlah_perlengkapan, 'icon' => 'fa-boxes'];

    // Menambahkan kartu untuk Usulan Barang
    //$cards[] = ['section' => 'Usulan Barang'];
    //$cards[] = ['label' => 'Usulan Pengadaan', 'count' => $jumlah_pengadaan, 'icon' => 'fa-file-signature', 'link' => url('/staff_usulan_pengadaan')];
    //$cards[] = ['label' => 'Usulan Perbaikan', 'count' => $jumlah_perbaikan, 'icon' => 'fa-tools', 'link' => url('/staff_usulan_perbaikan')];
    //$cards[] = ['label' => 'Usulan Penghapusan', 'count' => $jumlah_penghapusan, 'icon' => 'fa-trash', 'link' => url('/staff_usulan_penghapusan')];

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
                        @if(!in_array($card['label'], ['Kategori', 'Kapel', 'Perlengkapan']))
                            <a href="{{ $card['link'] }}" class="text-info font-weight-bold">Lihat detail</a>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach

</div>
@endsection