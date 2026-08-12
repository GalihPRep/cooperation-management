<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Kerjasama</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom box-shadow mb-3 position-relative" style="z-index: 1030;">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">Manajemen Kerjasama</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/">
                                Rumah
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="/summary">
                                Ringkasan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="{{ route('documents.index') }}">
                                Dokumen
                            </a>
                        </li>
                        <!-- Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Data pendukung
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="{{ route('institutions.index') }}">
                                        Institusi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('sectors.index') }}">
                                        Jenis institusi
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('formats.index') }}">
                                        Bentuk dokumen
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('categories.index') }}">
                                        Jenis dokumen
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('pics.index') }}">
                                        Penanggung jawab
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('statuses.index') }}">
                                        Status
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('countries.index') }}">
                                        Negara
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <main role="main" class="pb-3">@yield("content")</main>
    </div>

    <footer class="border-top footer text-muted">
        <div class="container">
            &copy; 2024 — LaravelProject — <a href="">Privacy</a>
        </div>
    </footer>

    @if(PHP_OS === "Linux")
    <!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @endif
    @stack("scripts")
</body>

</html>