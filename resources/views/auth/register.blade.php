<!DOCTYPE html>
<html lang="en">
<head> {{-- ✅ MODIFIKASI: Tambahkan head baru --}}
    <meta charset="UTF-8">
    <title>Register User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"> {{-- ✅ Tambahkan Bootstrap CDN --}}
</head>
<body> {{-- ✅ Mulai body --}}

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6"> {{-- ✅ Ukuran card disesuaikan --}}
            <div class="card shadow-sm">
                <div class="card-header text-center font-weight-bold">
                    Register User
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username (Nomor Induk Staff)') }}</label>

                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="role" class="col-md-4 col-form-label text-md-right">{{ __('Role') }}</label>

                            <div class="col-md-6">
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                                    <option value="kaunit" {{ old('role') == 'kaunit' ? 'selected' : '' }}>Kepala Unit</option>
                                    <option value="kaunit" {{ old('role') == 'volunteer' ? 'selected' : '' }}>Volunteer</option>
                                </select>

                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
    <label for="bagian" class="col-md-4 col-form-label text-md-right">{{ __('Bagian') }}</label>

    <div class="col-md-6">
        <select id="bagian" class="form-control @error('bagian') is-invalid @enderror" name="bagian" required>
            <option value="">-- Pilih Bagian --</option>
            <option value="staff_administrasi_umum" {{ old('bagian') == 'staff_administrasi_umum' ? 'selected' : '' }}>Staff Administrasi Umum</option>
            <option value="staff_keuangan_dan_pengadaan" {{ old('bagian') == 'staff_keuangan_dan_pengadaan' ? 'selected' : '' }}>Staff Keuangan dan Pengadaan</option>
            <option value="staff_psikolog" {{ old('bagian') == 'staff_psikolog' ? 'selected' : '' }}>Staff Psikolog (Tes Psikolog)</option>
            <option value="staff_konselor" {{ old('bagian') == 'staff_konselor' ? 'selected' : '' }}>Staff Konselor (Konseling)</option>
            <option value="staff_spiritualitas" {{ old('bagian') == 'staff_spiritualitas' ? 'selected' : '' }}>Staff Spiritualitas (Ibadah, dll)</option>
            <option value="staff_kreatif_ministry" {{ old('bagian') == 'staff_kreatif_ministry' ? 'selected' : '' }}>Staff Kreatif Ministry (Buat Konten)</option>
        </select>

        @error('bagian')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                    </form>
                </div> {{-- end card-body --}}
            </div> {{-- end card --}}
        </div>
    </div>
</div>

</body> {{-- ✅ Tambahkan tag penutup body --}}
</html> {{-- ✅ Tambahkan penutup HTML --}}