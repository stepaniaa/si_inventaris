<!DOCTYPE html>
<html>
<head>
   <title>Slip Peminjaman Perlengkapan Ditolak</title>>
</head>
<body>
    <p>Halo,</p>

    <p>Dengan hormat, kami sampaikan bahwa permohonan peminjaman perlengkapan yang Anda ajukan telah <strong>ditolak</strong> pada {{ $peminjaman->tanggal_tervalidasi }}. Berikut adalah detail permohonan Anda:</p>


    <ul>
        <li><strong>ID Peminjaman:</strong> {{ $peminjaman->id_peminjaman_pkp }}</li>
        <li><strong>Perlengkapan yang Dipinjam:</strong>
            <ul>
                @foreach($peminjaman->perlengkapan as $item)
                    <li>{{ $item->nama_perlengkapan }}</li>
                @endforeach
            </ul>
        </li>
        <li><strong>Nomor Induk:</strong> {{ $peminjaman->nomor_induk }}</li>
        <li><strong>Nama Peminjam:</strong> {{ $peminjaman->nama_peminjam }}</li>
        <li><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</li>
        <li><strong>Tanggal Mulai Peminjaman:</strong> {{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</li>
        <li><strong>Tanggal Selesai Peminjaman:</strong> {{ $peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</li>
        <li><strong>Rutin:</strong> {{ $peminjaman->rutin ? 'Ya' : 'Tidak' }}</li>
        <li><strong>Tipe Rutin:</strong> {{ ucfirst($peminjaman->tipe_rutin) ?? '-' }}</li>
        <li><strong>Jumlah Perulangan:</strong> {{ $peminjaman->jumlah_perulangan ?? '-' }}</li>
        <li><strong>Catatan dari staff :</strong> {{ $peminjaman->catatan_persetujuan_kapel }}</li>

    </ul>

   <p><strong>Catatan Penting:</strong></p>
    <ul>
        <li>Mohon cek kembali catatan dari petugas untuk mengetahui alasan penolakan.</li>
        <li>Jika diperlukan, Anda dapat mengajukan ulang peminjaman dengan menyesuaikan syarat atau jadwal sesuai kebijakan yang berlaku.</li>
        <li>Pastikan dokumen dan informasi kegiatan yang diajukan sudah lengkap dan jelas.</li>
    </ul>

    <p>Kami menghargai inisiatif Anda dan terbuka untuk permohonan di kesempatan berikutnya. Terima kasih telah menggunakan layanan peminjaman ruang kami.</p>
</body>
</html>
