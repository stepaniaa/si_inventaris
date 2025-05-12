<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Slip Peminjaman Perlengkapan Disetujui</title>
</head>
<body>
    <h2>Slip Peminjaman Perlengkapan</h2>
    <p>Halo </p>
    <p>Permohonan peminjaman perlengkapan Anda telah <strong>disetujui</strong>. Berikut detailnya:</p>

    <ul>
        <li><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan_pk }}</li>
        <li><strong>Perlengkapan:</strong> {{ $peminjaman->perlengkapan->nama_perlengkapan }}</li>
        <li><strong>Jumlah:</strong> {{ $peminjaman->jumlah_peminjaman_pk }}</li>
        <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai_pk)->format('d-m-Y') }}</li>
        <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai_pk)->format('d-m-Y') }}</li>
    </ul>

    @if ($peminjaman->butuh_gladi_pk)
        <p><strong>Termasuk Gladi:</strong> Ya</p>
        <ul>
            <li><strong>Tanggal Gladi:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_gladi_pk)->format('d-m-Y') }}</li>
            <li><strong>Selesai Gladi:</strong> {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai_gladi_pk)->format('d-m-Y') }}</li>
        </ul>
    @endif

    <p>Silakan hadir tepat waktu sesuai jadwal. Terima kasih.</p>

    <p>Salam,<br>Admin Peminjaman Perlengkapan</p>
</body>
</html>
