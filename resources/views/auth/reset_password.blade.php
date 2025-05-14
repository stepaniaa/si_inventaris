@extends('layouts.app')
@section('content')
<div class="container mt-4">
    <h2>Reset Password</h2>

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

    <form action="{{ url('/reset-password') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Simpan Password</button>
    </form>
</div>
@endsection