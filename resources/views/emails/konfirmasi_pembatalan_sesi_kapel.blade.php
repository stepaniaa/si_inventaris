<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembatalan Sesi Kapel</title>
</head>
<body>
    <h2>Konfirmasi Pembatalan Sesi Kapel</h2>

    <p>Halo {{ $sesi->peminjaman->nama_peminjam }},</p>

    <p>Permohonan peminjaman kapel Anda telah dibatalkan. Berikut detail peminjaman yang dibatalkan:</p>

    <ul>
        <li><strong>ID Peminjaman:</strong> {{ $sesi->peminjaman->id_peminjaman_kapel }}</li>
        <li><strong>Nama Kegiatan:</strong> {{ $sesi->peminjaman->nama_kegiatan }}</li>
        <li><strong>Alasan Pembatalan:</strong> {{ $sesi->alasan_dibatalkan }}</li>
        <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($sesi->tanggal_mulai_sesi)->format('d-m-Y H:i:s') }}</li>
        <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($sesi->tanggal_selesai_sesi)->format('d-m-Y H:i:s') }}</li>
    </ul>

    <p>Terima kasih atas pengertiannya.</p>

    <p>Salam,<br>Admin Peminjaman Kapel</p>
</body>
</html>
