@extends('layout.staff_main')
@section('title', 'Form Pengembalian Kapel')
@section('content')
<form action="/staff_pengembalian_ruang/save_pengembalian_ruang/{{ $peminjaman->id_peminjaman_ruang }}" method="POST">
    @csrf
    @method('PUT')

    <label for="tanggal_pengembalian">Tanggal Pengembalian:</label>
    <input type="datetime-local" name="tanggal_pengembalian" required>

    <label for="catatan_pengembalian">Catatan (opsional):</label>
    <textarea name="catatan_pengembalian"></textarea>

    <button type="submit">Simpan Pengembalian</button>
</form>
@endsection
