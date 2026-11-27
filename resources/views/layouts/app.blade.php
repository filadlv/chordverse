<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0f172a">
    <title>@yield('title', 'ChordVerse — Cari Chord Lagu')</title>
    <meta name="description" content="@yield('description', 'ChordVerse: cari chord lagu berdasarkan judul, penyanyi, atau genre. Baca, salin, dan simpan chord favoritmu.')">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/chordverse.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
@php
    $navGenres = \App\Models\Genre::orderByDesc('is_featured')->orderBy('name')->get();
    $featuredGenres = $navGenres->where('is_featured', true);
    $otherGenres = $navGenres->where('is_featured', false);
    $activeGenreId = request()->route('genre')->id ?? null;
@endphp

<a class="visually-hidden-focusable" href="#cvMain">Lewati ke konten utama</a>

<header class="cv-header" id="cvHeader">
    <nav class="navbar navbar-expand-lg cv-navbar" aria-label="Navigasi utama">
        <div class="container">
            <x-brand />

            <button class="navbar-toggler cv-toggler border-0 d-lg-none" type="button"
                    data-bs-toggle="collapse" data-bs-target="#cvNav"
                    aria-controls="cvNav" aria-expanded="false" aria-label="Buka menu">
                <x-icon name="menu" />
            </button>

            <div class="collapse navbar-collapse" id="cvNav">
                <ul class="navbar-nav cv-nav me-lg-auto ms-lg-3">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    @foreach ($featuredGenres as $navGenre)
                        <li class="nav-item">
                            <a class="nav-link {{ $activeGenreId === $navGenre->id ? 'active' : '' }}"
                               href="{{ route('genres.show', $navGenre) }}">{{ $navGenre->name }}</a>
                        </li>
                    @endforeach
                    @if ($otherGenres->isNotEmpty())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ $activeGenreId && $otherGenres->contains('id', $activeGenreId) ? 'active' : '' }}"
                               href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Lainnya</a>
                            <ul class="dropdown-menu">
                                @foreach ($otherGenres as $navGenre)
                                    <li>
                                        <a class="dropdown-item" href="{{ route('genres.show', $navGenre) }}">{{ $navGenre->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>

                <div class="cv-nav-actions">
                    <form class="cv-search" action="{{ route('songs.search') }}" role="search">
                        <x-icon name="search" />
                        <input class="form-control" type="search" name="q"
                               value="{{ request()->routeIs('songs.search') ? request('q') : '' }}"
                               placeholder="Cari lagu atau penyanyi" aria-label="Cari lagu atau penyanyi">
                    </form>

                    @auth
                        <a class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2" href="{{ route('songs.create') }}">
                            <x-icon name="plus" /><span class="d-none d-md-inline">Tambah Chord</span>
                        </a>

                        <div class="dropdown cv-account">
                            <button class="cv-account__btn" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false" aria-label="Menu akun {{ auth()->user()->name }}">
                                <x-avatar :user="auth()->user()" size="sm" />
                                <span class="cv-account__name">{{ auth()->user()->name }}</span>
                                <x-icon name="chevron-down" class="cv-account__caret" />
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end cv-account__menu">
                                <li class="cv-account__head">
                                    <x-avatar :user="auth()->user()" size="md" />
                                    <div class="min-w-0">
                                        <div class="cv-account__head-name">{{ auth()->user()->name }}</div>
                                        <div class="cv-account__head-mail">&#64;{{ auth()->user()->username }}</div>
                                    </div>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile') }}">
                                        <x-icon name="user" /> Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile', ['tab' => 'songs']) }}">
                                        <x-icon name="music" /> Lagu Saya
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile', ['tab' => 'bookmarks']) }}">
                                        <x-icon name="bookmark" /> Bookmark
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile', ['tab' => 'settings']) }}">
                                        <x-icon name="settings" /> Pengaturan
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <x-icon name="logout" /> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="btn btn-light btn-sm" href="{{ route('login') }}">Login</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="container py-4 py-lg-5" id="cvMain">
    @if (session('success'))
        <div class="cv-alert cv-alert--success mb-4" role="status">
            <x-icon name="check" />
            <div>{{ session('success') }}</div>
            <button type="button" class="cv-alert__close" data-dismiss-alert aria-label="Tutup pesan">
                <x-icon name="close" />
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="cv-alert cv-alert--danger mb-4" role="alert">
            <x-icon name="alert" />
            <div>
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="cv-alert__close" data-dismiss-alert aria-label="Tutup pesan">
                <x-icon name="close" />
            </button>
        </div>
    @endif

    @yield('content')
</main>

<footer class="cv-footer">
    <div class="container">
        <div class="cv-footer__grid">
            <div>
                <x-brand />
                <p class="cv-footer__tagline">
                    Ruang berbagi chord lagu untuk semua musisi. Cari, baca, dan simpan chord favoritmu dalam satu tempat.
                </p>
            </div>

            <div>
                <h2 class="cv-footer__title">Jelajahi</h2>
                <ul class="cv-footer__links">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('songs.search') }}">Semua Chord</a></li>
                    @auth
                        <li><a href="{{ route('songs.create') }}">Tambah Chord</a></li>
                    @else
                        <li><a href="{{ route('register') }}">Buat Akun</a></li>
                    @endauth
                </ul>
            </div>

            <div>
                <h2 class="cv-footer__title">Genre</h2>
                <ul class="cv-footer__links">
                    @foreach ($navGenres->take(4) as $navGenre)
                        <li><a href="{{ route('genres.show', $navGenre) }}">{{ $navGenre->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h2 class="cv-footer__title">Akun</h2>
                <ul class="cv-footer__links">
                    @auth
                        <li><a href="{{ route('profile') }}">Profil</a></li>
                        <li><a href="{{ route('profile', ['tab' => 'bookmarks']) }}">Bookmark</a></li>
                        <li><a href="{{ route('profile', ['tab' => 'settings']) }}">Pengaturan</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Daftar</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="cv-footer__bottom">
            <span>&copy; {{ date('Y') }} ChordVerse. Semua chord dibagikan oleh pengguna.</span>
            <span>Dibangun dengan Laravel &amp; Bootstrap 5</span>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/chordverse.js') }}"></script>
@stack('scripts')
</body>
</html>
