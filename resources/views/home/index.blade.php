@extends('layouts.app')

@section('content')
<section class="hero p-4 p-lg-5 mb-5">
<div class="row align-items-center">
<div class="col-lg-7">
<span class="badge bg-light text-dark mb-3">ChordVerse</span>
<h1 class="display-5 fw-bold">Cari chord lagu favoritmu.</h1>
<p class="lead text-white-50">Temukan chord berdasarkan judul atau nama penyanyi, lalu mainkan dengan tampilan yang mudah dibaca.</p>
<form action="{{ route('songs.search') }}" class="row g-2">
<div class="col-md-9"><input class="form-control form-control-lg" name="q" value="{{ request('q') }}" placeholder="Cari judul lagu atau penyanyi..."></div>
<div class="col-md-3"><button class="btn btn-light btn-lg w-100">Cari Chord</button></div>
</form>
</div>
<div class="col-lg-5 text-center mt-4 mt-lg-0">
<div class="display-1">🎸</div>
<p class="mb-0 text-white-50">Baca • Mainkan • Bagikan</p>
</div>
</div>
</section>

<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 fw-bold">Kategori Genre</h2>
</div>
<div class="row g-3 mb-5">
@foreach($genres as $genre)
<div class="col-6 col-md-3">
<a href="{{ route('genres.show', $genre) }}" class="text-decoration-none text-dark">
<div class="card genre-card p-3 h-100">
<div class="fs-2 mb-2">{{ $genre->is_featured ? '🎵' : '🎶' }}</div>
<h3 class="h6 fw-bold">{{ $genre->name }}</h3>
<p class="small muted mb-0">{{ $genre->songs_count }} chord</p>
</div>
</a>
</div>
@endforeach
</div>

<div class="d-flex justify-content-between align-items-center mb-3">
<h2 class="h4 fw-bold">Lagu Populer</h2>
<a href="{{ route('songs.search') }}" class="text-decoration-none">Lihat Semua →</a>
</div>
<div class="row g-4">
@forelse($popularSongs as $song)
@php $isSaved = in_array($song->id, $bookmarkedIds); @endphp
<div class="col-12 col-md-6 col-lg-3">
<div class="card song-card h-100 p-2">
<img class="cover" src="{{ $song->cover_url }}" alt="{{ $song->title }}">
<div class="card-body">
<span class="badge text-bg-light">{{ $song->genre->name }}</span>
<h3 class="h6 fw-bold mt-2">{{ $song->title }}</h3>
<p class="muted small mb-2">{{ $song->artist }}</p>
<p class="small muted mb-3">👁 {{ number_format($song->views) }} dilihat</p>
<div class="d-flex gap-2">
<a href="{{ route('songs.show', $song) }}" class="btn btn-primary btn-sm flex-grow-1">Lihat Chord</a>
@auth
<form method="POST" action="{{ route('bookmarks.toggle', $song) }}" class="d-flex">
@csrf
<button class="btn btn-sm {{ $isSaved ? 'btn-warning' : 'btn-outline-secondary' }}" title="{{ $isSaved ? 'Hapus bookmark' : 'Bookmark lagu' }}">{{ $isSaved ? '★' : '☆' }}</button>
</form>
@else
<a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}" title="Login untuk bookmark">☆</a>
@endauth
</div>
</div>
</div>
</div>
@empty
<div class="col-12"><div class="alert alert-light border">Belum ada lagu.</div></div>
@endforelse
</div>
@endsection
