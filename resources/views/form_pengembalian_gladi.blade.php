@extends('layout.staff_main')
@section('title', 'Form Pengembalian Kapel')
@section('content')
    <h3>Form Pengembalian Gladi</h3>
    <form action="/staff_pengembalian_ruang/save_pengembalian_gladi/{{ $peminjaman->id_peminjaman_ruang }}" method="POST">
    @csrf
    @method('PUT')
        <label>Tanggal Pengembalian Gladi:</label>
        <input type="datetime-local" name="pengembalian_gladi_aktual" required>
        <button type="submit">Simpan</button>
    </form>
@endsection


