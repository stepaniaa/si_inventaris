<!DOCTYPE html>
<html>
<head>
    <title>Slip Peminjaman Kapel Disetujui</title>
</head>
<body>
    <p>Halo,</p>

    <p>Peminjaman ruang Anda telah <strong>disetujui</strong> pada {{ $peminjaman->tanggal_tervalidasi }} . Berikut detailnya:</p>

    <ul>
        <li><strong>ID Peminjaman:</strong> {{ $peminjaman->id_peminjaman_kapel }}</li>
        <li><strong>Ruang dipinjam:</strong> {{ $peminjaman->ruang->nama_ruang }}</li>
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
        <li>Mohon membawa <strong>kartu identitas</strong> saat pengambilan akses ruang. Kartu identitas akan digunakan sebagai bentuk pertanggungjawaban atas penggunaan ruang.</li>
        <li>Pastikan datang <strong>tepat waktu</strong> sesuai dengan jadwal yang telah disetujui.</li>
        <li>Gunakan ruang secara <strong>bertanggung jawab</strong> dan sesuai dengan peraturan yang berlaku.</li>
    </ul>

    <p>Terima kasih telah menggunakan layanan peminjaman ruang kami.</p>
</body>
</html>
