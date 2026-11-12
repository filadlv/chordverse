<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'ChordVerse' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --cv-dark:#111827; --cv-primary:#7c3aed; --cv-soft:#f6f5ff; }
        body { background:#f8fafc; color:#1f2937; }
        .navbar-brand { font-weight:800; letter-spacing:-.5px; }
        .navbar-brand span { color:var(--cv-primary); }
        .hero { background:linear-gradient(135deg,#111827,#312e81); color:white; border-radius:24px; }
        .hero input { min-height:52px; }
        .genre-card,.song-card { border:0; border-radius:18px; box-shadow:0 8px 28px rgba(15,23,42,.06); }
        .genre-card:hover,.song-card:hover { transform:translateY(-2px); transition:.2s; }
        .cover { width:100%; aspect-ratio:1/1; object-fit:cover; border-radius:14px; background:#e5e7eb; }
        .chord-box { white-space:pre-wrap; font-family:ui-monospace,SFMono-Regular,Menlo,monospace; line-height:1.8; background:#111827; color:#f9fafb; border-radius:16px; padding:24px; overflow:auto; }
        .muted { color:#6b7280; }
        .avatar { width:36px;height:36px;border-radius:50%;object-fit:cover;background:#ede9fe; }
        .nav-pills .nav-link.active { background:var(--cv-primary); }
        footer { margin-top:80px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
<div class="container py-2">
<a class="navbar-brand" href="{{ route('home') }}">Chord<span>Verse</span></a>
<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#nav">☰</button>
<div class="collapse navbar-collapse" id="nav">
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
<li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
@foreach(\App\Models\Genre::where('is_featured', true)->orderBy('name')->get() as $navGenre)
<li class="nav-item"><a class="nav-link" href="{{ route('genres.show', $navGenre) }}">{{ $navGenre->name }}</a></li>
@endforeach
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Lainnya</a>
<ul class="dropdown-menu">
@foreach(\App\Models\Genre::where('is_featured', false)->orderBy('name')->get() as $navGenre)
<li><a class="dropdown-item" href="{{ route('genres.show', $navGenre) }}">{{ $navGenre->name }}</a></li>
@endforeach
</ul>
</li>
</ul>
<form class="d-flex me-3" action="{{ route('songs.search') }}">
<input class="form-control" name="q" placeholder="Cari lagu..." value="{{ request('q') }}">
</form>
@auth
<a class="btn btn-primary me-2" href="{{ route('songs.create') }}">+ Tambah Chord</a>
<div class="dropdown">
<button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown">
{{ auth()->user()->name }}
</button>
<ul class="dropdown-menu dropdown-menu-end">
<li><a class="dropdown-item" href="{{ route('profile') }}">Profil</a></li>
<li><hr class="dropdown-divider"></li>
<li>
<form method="POST" action="{{ route('logout') }}">
@csrf
<button class="dropdown-item">Logout</button>
</form>
</li>
</ul>
</div>
@else
<a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Login</a>
<a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
@endauth
</div>
</div>
</nav>

<main class="container py-4">
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
{{ session('success') }} <button class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
<ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
</div>
@endif

@yield('content')
</main>

<footer class="bg-dark text-white-50 py-4">
<div class="container d-flex justify-content-between">
<span>© {{ date('Y') }} ChordVerse</span>
<span>Web Chord berbasis Laravel</span>
</div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copyChord() {
    const text = document.getElementById('chordText').innerText;
    navigator.clipboard.writeText(text).then(() => {
        const btn = document.getElementById('copyBtn');
        btn.innerText = 'Tersalin ✓';
        setTimeout(() => btn.innerText = 'Copy Chord', 1500);
    });
}
</script>
</body>
</html>