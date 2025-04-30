<!DOCTYPE html>
<html>
<head>
    <title>Akun Sistem Inventaris Anda Telah Dibuat</title>
</head>
<body>
    <p>Halo {{ $user->name }},</p>
    <p>Akun Anda untuk sistem inventaris telah berhasil dibuat oleh Kepala Unit.</p>
    <p>Berikut adalah detail login Anda:</p>
    <ul>
        <li><strong>Username (Nomor Induk Staff):</strong> {{ $user->username }}</li>
        <li><strong>Password Awal:</strong> {{ $password }}</li>
    </ul>
    <p>Anda disarankan untuk segera mengganti password Anda setelah berhasil login. Anda dapat menggunakan fitur "Lupa Password" jika diperlukan.</p>
    <p>Terima kasih!</p>
</body>
</html>