<!DOCTYPE html>
<html>
<head>
<title>Daftar Ruang</title>
<style>
body {
  font-family: sans-serif;
}
table {
  width: 100%;
  border-collapse: collapse;
}
th, td {
  padding: 8px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
th {
  background-color: #f2f2f2;
}
.btn {
  padding: 4px 8px;
  border: none;
  cursor: pointer;
}
.btn-primary {
  background-color: #4CAF50;
  color: white;
}
.btn-danger {
  background-color: #f44336;
  color: white;
}
</style>
</head>
<body>

<h1>Daftar Ruang</h1>

<button>(+) Ruang</button>

<input type="text" placeholder="Cari">

<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Kode Ruang</th>
      <th>Nama Ruang</th>
      <th>Kapasitas</th>
      <th>Fasilitas</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1</td>
      <td>Kapel Atas L2</td>
      <td>Kapel Atas</td>
      <td>50</td>
      <td>Gitar, Proyektor, Sound System</td>
      <td>Tersedia</td>
      <td>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger">Hapus</button>
      </td>
    </tr>
    <tr>
      <td>2</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger">Hapus</button>
      </td>
    </tr>
    <tr>
      <td>3</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger">Hapus</button>
      </td>
    </tr>
    <tr>
      <td>4</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger">Hapus</button>
      </td>
    </tr>
    <tr>
      <td>5</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>Lorem Ipsum</td>
      <td>
        <button class="btn btn-primary">Edit</button>
        <button class="btn btn-danger">Hapus</button>
      </td>
    </tr>
  </tbody>
</table>

</body>
</html>