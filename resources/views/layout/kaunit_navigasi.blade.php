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
            <a class="nav-link {{$key=='kaunit_daftar_user'?'active':''}}" href="/kaunit_daftar_user">Daftar User</a>
              <a class="nav-link {{$key=='kaunit_daftar_kapel'?'active':''}}" href="/kaunit_daftar_kapel">Daftar Kapel</a>
              <a class="nav-link {{$key=='kaunit_daftar_perlengkapan'?'active':''}}" href="/kaunit_daftar_perlengkapan">Daftar Perlengkapan</a>
              <a class="nav-link {{$key=='kaunit_usulan_pengadaan'?'active':''}}" href="/kaunit_usulan_pengadaan">Approve Pengadaan</a>
              <a class="nav-link {{$key=='kaunit_usulan_perbaikan'?'active':''}}" href="/kaunit_usulan_perbaikan">Approve Perbaikan</a>
              <a class="nav-link {{$key=='kaunit_usulan_penghapusan'?'active':''}}" href="/kaunit_usulan_penghapusan">Approve Penghapusan</a>
              
</div>