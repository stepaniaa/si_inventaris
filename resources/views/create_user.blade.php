@extends('layout.kaunit_main')

@section('content')
<div class="container">
    <h3>Buat Akun Pengguna Baru</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ url('/kaunit/create_user') }}">
        @csrf

        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Email UKDW</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Role</label>
            <select name="role" class="form-control">
                <option value="staff">Staff</option>
                <option value="kaunit">Kepala Unit</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <button type="submit" class="btn btn-primary">Buat Akun</button>
        </div>
    </form>
</div>
@endsection
