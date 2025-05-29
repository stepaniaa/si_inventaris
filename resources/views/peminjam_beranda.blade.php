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

@endsection
