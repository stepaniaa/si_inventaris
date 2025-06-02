@php
use Illuminate\Support\Facades\Request;
 $bagian = Auth::user()->bagian ?? null;
@endphp

<style>
.sidebar-dark .nav-header {
    color: #212529;
}

.sidebar-dark .nav-link {
    color: #212529;
}

.sidebar-dark .nav-link:hover {
    background-color: #E0E2F0 !important;
    color: #212529 !important;
}

.sidebar-dark .nav-link.active {
    background-color: #E0E2F0 !important; /* Pearl */
    color: #212529 !important; /* tetap teks gelap */
    font-weight: bold;
}
</style>

<div class="nav flex-column nav-pills mt-4 sidebar-dark" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <h6 class="nav-header">Menu Utama</h6>
    <a class="nav-link {{ Request::is('staff_beranda') ? 'active' : '' }}" href="/staff_beranda">Beranda</a>
@if($bagian === 'staff_keuangan_dan_pengadaan')
    <a class="nav-link {{ Request::is('staff_daftar_perlengkapan') ? 'active' : '' }}" href="/staff_daftar_perlengkapan">Daftar Perlengkapan</a>
    <a class="nav-link {{ Request::is('staff_daftar_ruang') ? 'active' : '' }}" href="/staff_daftar_ruang">Daftar Ruang</a>
    <a class="nav-link {{ Request::is('staff_daftar_kategori') ? 'active' : '' }}" href="/staff_daftar_kategori">Daftar Kategori</a>

    <h6 class="nav-header mt-2">Pengajuan</h6>
    <a class="nav-link {{ Request::is('staff_usulan_pengadaan') ? 'active' : '' }}" href="/staff_usulan_pengadaan">Pengajuan Pengadaan Barang</a>
    <a class="nav-link {{ Request::is('staff_usulan_perbaikan') ? 'active' : '' }}" href="/staff_usulan_perbaikan">Pengajuan Kelola Perbaikan</a>
    <a class="nav-link {{ Request::is('staff_usulan_penghapusan') ? 'active' : '' }}" href="/staff_usulan_penghapusan">Pengajuan Penghapusan Barang</a>
@endif

    <h6 class="nav-header mt-2">Peminjaman</h6>
    <a class="nav-link {{ Request::is('staff_peminjaman_kapel') ? 'active' : '' }}" href="/staff_peminjaman_kapel">Validasi Peminjaman Kapel</a>
    <a class="nav-link {{ Request::is('staff_peminjaman_perlengkapan') ? 'active' : '' }}" href="/staff_peminjaman_perlengkapan">Validasi Peminjaman Perlengkapan</a>

    <h6 class="nav-header mt-2">Riwayat Peminjaman</h6>
    <a class="nav-link {{ Request::is('staff_pengembalian_kapel') ? 'active' : '' }}" href="/staff_pengembalian_kapel">Riwayat Peminjaman Kapel</a>
    <a class="nav-link {{ Request::is('staff_pengembalian_pkp') ? 'active' : '' }}" href="/staff_pengembalian_pkp">Riwayat Peminjaman Perlengkapan</a>
</div>
