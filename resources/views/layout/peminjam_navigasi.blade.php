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
    <a class="nav-link {{ request()->is('peminjam_beranda') ? 'active' : '' }}" href="/peminjam_beranda">Beranda</a>
<a class="nav-link {{ request()->is('peminjaman_kapel') ? 'active' : '' }}" href="/peminjaman_kapel">Pinjam Kapel</a>
<a class="nav-link {{ request()->is('peminjaman_perlengkapan') ? 'active' : '' }}" href="/peminjaman_perlengkapan">Pinjam Perlengkapan</a>

</div>
