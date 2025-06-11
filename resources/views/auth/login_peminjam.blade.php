<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h4 class="text-center mb-4">Login Peminjam</h4>
        <form method="POST" action="{{ url('login_peminjam') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror"
                    required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>

            <div class="mt-3 text-center">
                <a href="/register_peminjam">Belum punya akun? Registrasi</a>
            </div>
        </form>
    </div>
</body>
</html>
