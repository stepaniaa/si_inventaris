<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Peminjam</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center font-weight-bold">
                    Form Registrasi Peminjam
                </div>

                <div class="card-body">
                   <form method="POST" action="/register_peminjam">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Alamat Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                            <small>Civitas Akademika UKDW harap registrasi dengan email Staff / Students </small>
                        </div>

                        {{-- Hanya untuk user UKDW --}}
                        <div id="ukdwOnlyFields">
                            <div class="form-group">
                                <label for="nim">Nomor Induk (NIM / NIP)</label>
                                <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror"
                                       name="nim" value="{{ old('nim') }}">
                                @error('nim')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="asal_unit">Asal Unit</label>
                                <select id="asal_unit" name="asal_unit" class="form-control">
                                    <option value="">-- Pilih Asal Unit --</option>
                                    <option value="Fakultas Teknologi Informasi">Fakultas Teknologi Informasi</option>
                                    <option value="Fakultas Bisnis">Fakultas Bisnis</option>
                                    <option value="Fakultas Kedokteran">Fakultas Kedokteran</option>
                                    <option value="Fakultas Bioteknologi">Fakultas Bioteknologi</option>
                                    <option value="Fakultas Teologi">Fakultas Teologi</option>
                                    <option value="Fakultas Arsitektur & Desain">Fakultas Arsitektur & Desain</option>
                                    <option value="Fakultas Kependidikan & Humaniora">Fakultas Kependidikan & Humaniora</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="peran">Peran</label>
                                <select id="peran" name="peran" class="form-control">
                                    <option value="">-- Pilih Peran --</option>
                                    <option value="Mahasiswa">Mahasiswa UKDW</option>
                                    <option value="Dosen">Dosen UKDW</option>
                                    <option value="Staf">Pegawai UKDW</option>
                                </select>
                            </div>
                        </div>

                        {{-- Hidden field untuk eksternal --}}
                        <input type="hidden" name="asal_unit" id="asal_unit_hidden" value="Eksternal / Umum">
                        <input type="hidden" name="peran" id="peran_hidden" value="Tamu Umum">

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" type="password" class="form-control"
                                   name="password_confirmation" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Daftar Sekarang
                        </button>

                        <div class="mt-3 text-center">
                            <a href="/login_peminjam">Sudah punya akun? Login di sini</a>
                        </div>
                    </form>
                </div> {{-- end card-body --}}
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const emailInput = document.getElementById('email');
    const ukdwFields = document.getElementById('ukdwOnlyFields');
    const asalUnitHidden = document.getElementById('asal_unit_hidden');
    const peranHidden = document.getElementById('peran_hidden');

    function checkEmailDomain() {
        const email = emailInput.value;
        const isUkdw = email.endsWith('ukdw.ac.id');

        if (isUkdw) {
            ukdwFields.style.display = 'block';
            asalUnitHidden.disabled = true;
            peranHidden.disabled = true;
        } else {
            ukdwFields.style.display = 'none';
            asalUnitHidden.disabled = false;
            peranHidden.disabled = false;
        }
    }

    emailInput.addEventListener('input', checkEmailDomain);
    checkEmailDomain();
});
</script>

</body>
</html>
