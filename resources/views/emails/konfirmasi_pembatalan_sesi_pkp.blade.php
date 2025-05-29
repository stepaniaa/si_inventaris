<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pembatalan Peminjaman Perlengkapan</title>
</head>
<body>
    <h2>Konfirmasi Pembatalan Peminjaman Perlengkapan</h2>

    <p>Halo {{  $sesi->peminjaman->nama_peminjam_pk }},</p>

    <p>Permohonan peminjaman perlengkapan Anda telah dibatalkan. Berikut detail peminjaman yang dibatalkan:</p>

    <ul>
        <li><strong>ID Peminjaman:</strong> {{  $sesi->peminjaman->id_peminjaman_pkp }}</li>
        <li><strong>Nama Kegiatan:</strong> {{  $sesi->peminjaman->nama_kegiatan_pk }}</li>
        <li><strong>Alasan Pembatalan:</strong> {{  $sesi->alasan_dibatalkan }}</li>
        <li><strong>Perlengkapan yang Dipinjam:</strong>
            <ul>
                @foreach( $sesi->peminjaman->perlengkapan as $item)
                    <li>{{ $item->nama_perlengkapan }}</li>
                @endforeach
            </ul>
        </li>
        <li><strong>Tanggal Mulai:</strong> {{ \Carbon\Carbon::parse( $sesi->tanggal_mulai_sesi)->format('d-m-Y H:i:s') }}</li>
        <li><strong>Tanggal Selesai:</strong> {{ \Carbon\Carbon::parse( $sesi->tanggal_selesai_sesi)->format('d-m-Y H:i:s') }}</li>
    </ul>

    <p>Terima kasih atas pengertiannya.</p>

    <p>Salam,<br>Admin Peminjaman Perlengkapan</p>
</body>
</html>
