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
    <a class="nav-link {{ ($key ?? '')=='peminjaman_beranda' ? 'active' : '' }}" href="/peminjaman_beranda">Beranda</a>
    <a class="nav-link {{ ($key ?? '')=='peminjaman_kapel' ? 'active' : '' }}" href="/peminjaman_kapel">Pinjam Kapel</a>
    <a class="nav-link {{ ($key ?? '')=='peminjaman_perlengkapan' ? 'active' : '' }}" href="/peminjaman_perlengkapan">Pinjam Perlengkapan</a>
</div>
