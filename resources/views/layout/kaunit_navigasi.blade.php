<style>
.sidebar-dark .nav-header {
    color: #212529;
}

.sidebar-dark .nav-link {
    color: #212529;
    cursor: pointer;
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
    <h6 class="nav-header">Beranda</h6>
    <a class="nav-link {{ Request::is('kaunit_beranda*') ? 'active' : '' }}" href="/kaunit_beranda">Beranda</a>
    <h6 class="nav-header">Pengelolaan Akun Pengguna</h6>
    <a class="nav-link {{ Request::is('kaunit_daftar_user*') ? 'active' : '' }}" href="/kaunit_daftar_user">Daftar User</a>
    <h6 class="nav-header">Pengelolaan Inventaris</h6>
    <a class="nav-link {{ Request::is('kaunit_daftar_kapel*') ? 'active' : '' }}" href="/kaunit_daftar_kapel">Daftar Kapel</a>
    <a class="nav-link {{ Request::is('kaunit_daftar_perlengkapan*') ? 'active' : '' }}" href="/kaunit_daftar_perlengkapan">Daftar Perlengkapan</a>
    <a class="nav-link {{ Request::is('kaunit_usulan_pengadaan*') ? 'active' : '' }}" href="/kaunit_usulan_pengadaan">Approve Pengadaan</a>
    <a class="nav-link {{ Request::is('kaunit_usulan_perbaikan*') ? 'active' : '' }}" href="/kaunit_usulan_perbaikan">Approve Perbaikan</a>
    <a class="nav-link {{ Request::is('kaunit_usulan_penghapusan*') ? 'active' : '' }}" href="/kaunit_usulan_penghapusan">Approve Penghapusan</a>
    <h6 class="nav-header mt-2">Peminjaman</h6>
<a class="nav-link {{ Request::is('staff_peminjaman_kapel*') ? 'active' : '' }}" href="/staff_peminjaman_kapel">Validasi Peminjaman Kapel</a>
<a class="nav-link {{ Request::is('staff_peminjaman_perlengkapan*') ? 'active' : '' }}" href="/staff_peminjaman_perlengkapan">Validasi Peminjaman Perlengkapan</a>

<h6 class="nav-header mt-2">Riwayat Peminjaman</h6>
<a class="nav-link {{ Request::is('staff_pengembalian_kapel*') ? 'active' : '' }}" href="/staff_pengembalian_kapel">Riwayat Peminjaman Kapel</a>
<a class="nav-link {{ Request::is('staff_pengembalian_pkp*') ? 'active' : '' }}" href="/staff_pengembalian_pkp">Riwayat Peminjaman Perlengkapan</a>
</div>
