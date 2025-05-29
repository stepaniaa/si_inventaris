<!DOCTYPE html>
<html>
<head>
    <title>Slip Peminjaman Perlengkapan anda Disetujui</title>
</head>
<body>
    <p>Halo,</p>

    <p>Peminjaman Anda telah <strong>disetujui</strong> pada {{ $peminjaman->tanggal_tervalidasi }} . Berikut detailnya:</p>


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

   <p><strong>Harap diperhatikan:</strong></p>
    <ul>
        <li>Silakan membawa <strong>kartu identitas resmi</strong> (KTM/KTP) saat pengambilan perlengkapan.</li>
        <li>Pengambilan dan pengembalian perlengkapan harus dilakukan <strong>tepat waktu</strong> sesuai dengan jadwal yang telah ditetapkan.</li>
        <li>Pastikan seluruh perlengkapan digunakan secara <strong>bertanggung jawab</strong> dan dikembalikan dalam kondisi baik.</li>
    </ul>

    <p>Terima kasih telah menggunakan layanan peminjaman perlengkapan kami.</p>
</body>
</html>
