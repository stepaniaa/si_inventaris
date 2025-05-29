<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .header-left {
            display: flex;
            align-items: center;
        }
        .header-left img {
            margin-right: 15px; /* Tambah margin kanan logo */
            height: 60px; /* Besarkan tinggi logo */
        }
        .header-left span {
            line-height: 60px; /* Sesuaikan line-height teks dengan tinggi logo */
            font-size: 1.2rem; /* Besarkan ukuran font teks */
        }
        .dropdown-toggle {
            height: 60px; /* Besarkan tinggi dropdown toggle */
            display: flex;
            align-items: center;
            font-size: 1.1rem; /* Besarkan ukuran font dropdown toggle */
            padding: 0.75rem 1.5rem; /* Tambah padding agar terlihat lebih besar */
        }
        .header-title {
            margin: 0;
            line-height: 60px; /* Sesuaikan line-height judul dengan tinggi header */
            font-size: 1.5rem; /* Besarkan ukuran font judul */
        }
        .bg-dark {
            padding-top: 10px; /* Tambah padding atas header */
            padding-bottom: 10px; /* Tambah padding bawah header */
        }
        .dropdown-menu .dropdown-item {
            font-size: 1rem; /* Sedikit besarkan font dropdown item */
            padding: 0.6rem 1rem; /* Tambah padding dropdown item */
        }
        .dropdown-menu .dropdown-item h5 {
            font-size: 1.2rem; /* Besarkan font nama user */
            margin-bottom: 0.2rem;
        }
        .dropdown-menu .dropdown-item small {
            font-size: 0.9rem; /* Sedikit besarkan font info selamat datang */
        }
        .bg-dusty {
    background-color: #52677D !important;
}

.btn-dusty {
    background-color: #52677D;
    border-color: #52677D;
    color: white;
}

.btn-dusty:hover {
    background-color: #415668;
    border-color: #415668;
}
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 bg-dusty py-2">
                <div class="row align-items-center justify-content-between">
                    <div class="col-md-4 header-left">
                        <img src="https://lpkksk.ukdw.ac.id/wp-content/uploads/2023/04/cropped-Artboard-2.png"  alt="Logo" class="rounded-circle">
                        <span class="text-white ml-2">SI Inventaris LPKKSK UKDW</span>
                    </div>
                    <div class="col-md-4">
                        <div class="dropdown float-right">
                            <button class="btn btn-dusty dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="bi bi-person-fill"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#">
                                    <div class="media">
                                        <div class="media-body">
                                            <h5 class="mt-2">{{ Auth::user()->name ?? ''}}</h5>
                                            <small>
                                                <i class="bi bi-emoji-smile-fill"></i> Selamat Datang
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                <a class="dropdown-item" href="{{ url('ubah_password') }}">
                                    <i class="bi bi-gear"></i> Ubah Password
                                </a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-left"></i> Log Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row vh-100">
            <div class="col-md-3 border sidebar">
                @if(auth()->user()->role === 'staff')
                    @include('layout.staff_navigasi')
                @elseif(auth()->user()->role === 'kaunit')
                    @include('layout.kaunit_navigasi')
                @else
                    {{-- Sidebar default atau kosong --}}
                    <p class="text-center mt-3">Menu tidak tersedia</p>
                @endif
            </div>
            <div class="col-md-9">
                {{-- KONTEN DINAMIS --}}
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>