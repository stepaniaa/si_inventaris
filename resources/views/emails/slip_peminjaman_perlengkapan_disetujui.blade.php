<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Slip Peminjaman Perlengkapan - Status {{ ucfirst($peminjaman->status_pk) }}</title>
</head>
<body>
    <h2>Slip Peminjaman Perlengkapan</h2>

    @if($peminjaman->status_pk === 'disetujui')
        <p>Halo,</p>
        <p>Permohonan peminjaman perlengkapan Anda telah <strong>disetujui</strong>. Berikut detailnya:</p>
    @elseif($peminjaman->status_pk === 'ditolak')
        <p>Halo,</p>
        <p>Mohon maaf, permohonan peminjaman perlengkapan Anda <strong>ditolak</strong>. Berikut detail pengajuan Anda:</p>
    @else
        <p>Halo,</p>
        <p>Status permohonan peminjaman perlengkapan Anda: <strong>{{ ucfirst($peminjaman->status_pk) }}</strong>.</p>
    @endif

    <ul>
        <li><strong>Perlengkapan yang Dipinjam:</strong>
            <ul>
                @foreach($peminjaman->perlengkapan as $item)
                    <li>{{ $item->nama_perlengkapan }}</li>
                @endforeach
            </ul>
        </li>
        <li><strong>Nama Kegiatan:</strong> {{ $peminjaman->nama_kegiatan_pk }}</li>
        <li><strong>Tanggal Mulai:</strong> {{ $peminjaman->sesi->first()->tanggal_mulai_sesi ?? '-' }}</li>
        <li><strong>Tanggal Selesai:</strong>{{$peminjaman->sesi->first()->tanggal_selesai_sesi ?? '-' }}</li>

         <li><strong>Jangan Lupa Membawa Kartu Indentitas Anda sebagai jaminan peminjaman.</li>
    </ul>

    @if($peminjaman->status_pk === 'disetujui')
        <p>Silakan hadir tepat waktu sesuai jadwal. Terima kasih.</p>
    @elseif($peminjaman->status_pk === 'ditolak')
        <p>Jika ada pertanyaan lebih lanjut, silakan hubungi admin.</p>
    @endif

    <p>Salam,<br>Admin Peminjaman Perlengkapan</p>
</body>
</html>
