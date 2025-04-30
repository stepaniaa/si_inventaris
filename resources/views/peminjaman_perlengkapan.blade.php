@extends('layout.peminjam_main')
@section('title', 'Peminjaman Perlengkapan')
@section('content')
    <h1>Daftar Perlengkapan yang Tersedia</h1>

    @if ($perlengkapan->count() > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Perlengkapan</th>
                    <th>Lokasi</th>
                    <th>Keterangan</th>
                    <th>Terbooking Pada (Bulan Ini)</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($perlengkapan as $key => $item)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $item->nama_perlengkapan }}</td>
                        <td>{{ $item->id_ruang }}</td>
                        <td>{{ $item->deskripsi_perlengkapan }}</td>
                        <td>
                            @php
                                $tanggal_terbooking = [];
                                // Jika ruang terkait sudah terbooking, tambahkan tanggal booking ruang ke daftar tanggal terbooking untuk perlengkapan ini.
                                if (isset($bookingRuangan) && isset($bookingRuangan[$item->id_ruang])) {
                                    $tanggal_terbooking = array_merge($tanggal_terbooking, $bookingRuangan[$item->id_ruang]);
                                }
                                // Tambahkan tanggal booking perlengkapan yang spesifik.
                                if (isset($terbooking[$item->id_perlengkapan])) {
                                    $tanggal_terbooking = array_merge($tanggal_terbooking, $terbooking[$item->id_perlengkapan]);
                                }
                                $tanggal_terbooking = array_unique($tanggal_terbooking); //Hapus tanggal duplikat
                            @endphp
                            @if (count($tanggal_terbooking) > 0)
                                <ul>
                                    @foreach ($tanggal_terbooking as $tanggal)
                                        <li>{{ $tanggal }}</li>
                                    @endforeach
                                </ul>
                            @else
                                Tidak ada booking
                            @endif
                        </td>
                        <td>
                            <a href="/peminjaman_perlengkapan/peminjaman_perlengkapan_formadd/{{ $item->id_perlengkapan }}"
                                class="btn btn-primary"
                                @if (count($tanggal_terbooking) > 0) disabled @endif
                            >
                                Pinjam
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Tidak ada perlengkapan yang tersedia saat ini.</p>
    @endif
@endsection
