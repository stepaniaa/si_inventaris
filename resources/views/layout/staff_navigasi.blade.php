<style>
.sidebar-dark .nav-header {
    color: #212529;
}

.sidebar-dark .nav-link {
    color: #212529;
}

.sidebar-dark .nav-link:hover,
.sidebar-dark .nav-link.active {
    background-color: #343a40 !important;
    color: #fff !important;
}

/* Tambahkan aturan berikut untuk mengubah warna teks saat aktif */
.sidebar-dark .nav-link.active {
    color: #fff !important;
}
</style>
<div class="nav flex-column nav-pills mt-4 sidebar-dark" id="v-pills-tab" role="tablist" aria-orientation="vertical">
    <h6 class="nav-header">Menu Utama</h6>
    <a class="nav-link {{$key=='staff_beranda'?'active':''}}" href="/staff_beranda">Beranda</a>
    <a class="nav-link {{$key=='staff_daftar_perlengkapan'?'active':''}}" href="/staff_daftar_perlengkapan">Daftar Perlengkapan</a>
    <a class="nav-link {{$key=='staff_daftar_ruang'?'active':''}}" href="/staff_daftar_ruang">Daftar Kapel</a>
    <a class="nav-link {{$key=='staff_daftar_kategori'?'active':''}}" href="/staff_daftar_kategori">Daftar Kategori</a>

    <h6 class="nav-header mt-2">Pengajuan</h6>
    <a class="nav-link {{$key=='staff_usulan_pengadaan'?'active':''}}" href="/staff_usulan_pengadaan">Pengajuan Pengadaan Barang</a>
    <a class="nav-link {{$key=='staff_usulan_perbaikan'?'active':''}}" href="/staff_usulan_perbaikan">Pengajuan Kelola Perbaikan</a>
    <a class="nav-link {{$key=='staff_usulan_penghapusan'?'active':''}}" href="/staff_usulan_penghapusan">Pengajuan Penghapusan Barang</a>

    <h6 class="nav-header mt-2">Peminjaman</h6>
    <a class="nav-link {{$key=='staff_peminjaman_ruang'?'active':''}}" href="/staff_peminjaman_ruang">Validasi Peminjaman Ruang</a>
    <a class="nav-link {{$key=='staff_peminjaman_perlengkapan'?'active':''}}" href="/staff_peminjaman_perlengkapan">Validasi Peminjaman Perlengkapan</a>

    <h6 class="nav-header mt-2">Pengembalian</h6>
    <a class="nav-link {{$key=='staff_pengembalian_ruang'?'active':''}}" href="/staff_pengembalian_ruang">Daftar Pengembalian Ruang</a>
    <a class="nav-link {{$key=='staff_pengembalian_perlengkapan'?'active':''}}" href="/staff_pengembalian_perlengkapan">Daftar Pengembalian Perlengkapan</a>
</div>
