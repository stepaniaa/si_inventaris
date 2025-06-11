@extends('layout.peminjam_main')

@section('title', 'siinventaris - Peminjam Beranda') 

@section('peminjam_navigasi')
@endsection

@section('content')
<h2 class="text-center text-3xl font-semibold mt-10 mb-8">Halo, Selamat datang di website peminjaman Kapel dan Perlengkapan</h2>

<div class="card mt-4 shadow-lg rounded-lg overflow-hidden">
    <div class="card-header text-center bg-white-500 text-white py-3">
        <strong class="text-lg text-black">Tata Cara Peminjaman</strong>
    </div>
    <div class="card-body bg-gray-50 p-4">
        <div class="space-y-6">
            <!-- Step 1 -->
            <div class="flex items-start space-x-4">
                <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <h5 class="font-semibold text-base">Check Ketersediaan Kapel atau Perlengkapan</h5>
                    <p class="text-gray-600 text-xs">Sebelum melakukan peminjaman, Anda dapat melihat peminjaman yang akan datang di halaman peminjaman Kapel / Perlengkapan.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="flex items-start space-x-4">
                <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <h5 class="font-semibold text-base">Pilih salah satu jenis Form Peminjaman</h5>
                    <p class="text-gray-600 text-xs">Terdapat dua jenis form peminjaman, yaitu Peminjaman Kapel dan Peminjaman Perlengkapan. Jika Anda ingin meminjam keduanya, harap mengisi kedua form tersebut.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="flex items-start space-x-4">
                <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <h5 class="font-semibold text-base">Isi semua data keperluan</h5>
                    <p class="text-gray-600 text-xs">Pengguna harus mengisi informasi keperluan dan tujuan peminjaman sesuai dengan form yang sudah disediakan.</p>
                </div>
            </div>

            <!-- Step 4 -->
            <div class="flex items-start space-x-4">
                <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <h5 class="font-semibold text-base">Menyetujui syarat & ketentuan</h5>
                    <p class="text-gray-600 text-xs">Peminjam diharuskan untuk menyetujui syarat dan ketentuan yang berlaku sebelum melanjutkan.</p>
                </div>
            </div>

            <!-- Step 5 -->
            <div class="flex items-start space-x-4">
                <div class="bg-blue-500 text-white w-10 h-10 rounded-full flex items-center justify-center">
                    <i class="fas fa-check text-xs"></i>
                </div>
                <div>
                    <h5 class="font-semibold text-base">Terima notifikasi melalui Email</h5>
                    <p class="text-gray-600 text-xs">Kami akan mengirimkan notifikasi melalui email terkait status peminjaman Anda.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Syarat dan Ketentuan Umum Peminjaman Fasilitas -->
<div class="card mt-5 shadow-lg rounded-lg overflow-hidden">
    <div class="card-header text-center bg-white-500 text-white py-3">
        <strong class="text-lg text-black">Syarat dan Ketentuan Umum Peminjaman</strong>
    </div>
    <div class="card-body bg-gray-50 p-4">
        <ol class="list-decimal text-sm text-gray-700 pl-5 space-y-2">
            <li><strong>Dilarang makan dan minum di dalam ruangan.</strong>
                <br>Untuk menjaga kebersihan dan kenyamanan bersama, konsumsi makanan dan minuman di fasilitas ruang tidak diperbolehkan.</li>

            <li><strong>Pengguna wajib menjaga kebersihan selama dan setelah pemakaian.</strong>
                <br>Semua peminjam bertanggung jawab atas kebersihan fasilitas yang digunakan, baik itu ruang maupun perlengkapan.</li>

            <li><strong>Fasilitas harus dikembalikan dalam kondisi dan posisi semula.</strong>
                <br>Segala perlengkapan atau tata letak ruang yang diubah saat pemakaian harus dikembalikan seperti sedia kala.</li>

            <li><strong>Dilarang memindahkan kabel dan instalasi tanpa izin.</strong>
                <br>Khusus fasilitas yang melibatkan perangkat elektronik, kabel atau alat tidak boleh dipindahkan sembarangan.</li>

            <li><strong>Peminjam bertanggung jawab penuh atas kerusakan dan kehilangan.</strong>
                <br>Kerusakan atau kehilangan pada ruang maupun perlengkapan selama masa peminjaman menjadi tanggung jawab peminjam sepenuhnya.</li>

            <li><strong>Wajib menyerahkan kartu identitas sebagai jaminan.</strong>
                <br>Seluruh peminjam diwajibkan menyerahkan identitas resmi (KTP/KTM) pada saat pengambilan akses fasilitas ke pihak LPKKSK sebagai bentuk jaminan hingga peminjaman selesai.</li>

            <li><strong>Penggunaan fasilitas harus tepat waktu sesuai jadwal.</strong>
                <br>Peminjam wajib mematuhi waktu peminjaman yang telah disetujui, baik saat mulai maupun pengembalian.</li>

            <li><strong>Peminjaman hanya dilakukan melalui sistem atau prosedur resmi.</strong>
                <br>Semua permohonan dilakukan melalui sistem yang disediakan oleh LPKKSK, tidak melalui jalur informal.</li>

            <li><strong>Peminjaman wajib melalui verifikasi dan persetujuan LPKKSK.</strong>
                <br>Fasilitas hanya dapat digunakan setelah mendapatkan izin resmi dari pihak LPKKSK.</li>

            <li><strong>Fasilitas hanya boleh digunakan untuk kegiatan yang sesuai pengajuan.</strong>
                <br>Penyalahgunaan fasilitas untuk tujuan lain di luar yang disetujui tidak diperbolehkan.</li>

            <li><strong>Dilarang menggunakan fasilitas untuk kegiatan yang melanggar norma atau hukum.</strong>
                <br>Segala bentuk tindakan destruktif, merusak moral, atau melanggar hukum dilarang keras.</li>
        </ol>
        <p class="text-xs text-gray-500 mt-3 italic">*Syarat dan ketentuan ini berlaku untuk seluruh bentuk peminjaman fasilitas, baik berupa ruang maupun perlengkapan.</p>
    </div>
</div>

<!-- Kontak Kami -->
<div class="card mt-5 shadow-lg rounded-lg overflow-hidden">
    <div class="card-body bg-gray-50 p-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
            <!-- Alamat -->
            <div>
                <p class="font-semibold text-base mb-1">Kontak Kami</p>
                <p><strong>Universitas Kristen Duta Wacana</strong></p>
                <p>Jl. dr. Wahidin Sudirohusodo no. 5–25</p>
                <p>Yogyakarta, Indonesia – 55224</p>
                <p>Gedung Chara lantai 2</p>
            </div>
            <!-- Email & Telepon -->
            <div>
                <p class="font-semibold text-base mb-1">Email</p>
                <p>pusatkerohanian@ukdw.ac.id</p>

                <p class="font-semibold text-base mt-4 mb-1">Telepon</p>
                <p>0274-563929 ext 104</p>
            </div>
        </div>
    </div>
</div>



@endsection
