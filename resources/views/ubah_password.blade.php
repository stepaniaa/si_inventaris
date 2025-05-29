{{-- ✅ MODIFIKASI: Hapus @extends dan @section --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> {{-- ✅ Tambahkan Bootstrap CDN --}}
</head>
<body> {{-- ✅ Awal body --}}

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6"> {{-- ✅ Gunakan col tengah dan card --}}
            <div class="card shadow-sm">
                <div class="card-header text-center font-weight-bold">
                    Reset Password
                </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('update_password') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="password_lama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password_baru" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Password</button>
    </form>
</div>
