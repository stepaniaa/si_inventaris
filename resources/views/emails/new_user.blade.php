<h2>Halo, {{ $user->name ?? $user->username }}</h2>
<p>Akun Anda telah berhasil dibuat dengan detail berikut:</p>
<ul>
    <li>Username: {{ $user->username }}</li>
    <li>Password Sementara: {{ $password }}</li>
</ul>
<p>Silakan login ke sistem dan segera ganti password Anda untuk keamanan.</p>