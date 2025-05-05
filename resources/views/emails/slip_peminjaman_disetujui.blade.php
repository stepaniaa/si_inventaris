<!DOCTYPE html>
<html>
<head>
    <title>Slip Peminjaman Ruang Disetujui</title>
</head>
<body>
    <h2>Slip Peminjaman Disetujui</h2>
    <p>Halo,</p>

    <p>Peminjaman ruang Anda telah <strong>disetujui</strong>. Berikut detailnya:</p>

    <ul>
        <li><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan }}</li>
        <li><strong>Ruang:</strong> {{ $peminjaman->ruang->nama_ruang }}</li>
        <li><strong>Tanggal Mulai Peminjaman:</strong> {{ $peminjaman->tanggal_mulai }}</li>
        <li><strong>Tanggal Selesai Peminjaman:</strong> {{ $peminjaman->tanggal_selesai }}</li>
        <li><strong>Catatan dari staff :</strong> {{ $peminjaman->catatan_staff }}</li>
        @if ($peminjaman->butuh_gladi)
            <li><strong>Gladi:</strong> {{ $peminjaman->tanggal_gladi }} - {{ $peminjaman->tanggal_pengembalian_gladi }}</li>
        @endif
</ul>
    <p>Terima kasih telah menggunakan layanan kami.</p>
</body>
</html>
