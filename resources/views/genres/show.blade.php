@extends('layouts.app')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
<div><p class="muted mb-1">Genre</p><h1 class="h2 fw-bold mb-0">{{ $genre->name }} Chords</h1></div>
<form class="d-flex gap-2" method="GET">
<input class="form-control" name="q" value="{{ $keyword }}" placeholder="Cari di {{ $genre->name }}">
<select class="form-select" name="sort" onchange="this.form.submit()">
<option value="terbaru" @selected(request('sort','terbaru')==='terbaru')>Terbaru</option>
<option value="terpopuler" @selected(request('sort')==='terpopuler')>Terpopuler</option>
</select>
<button class="btn btn-primary">Cari</button>
</form>
</div>
<div class="row g-4">
@forelse($songs as $song)
@php $isSaved = in_array($song->id, $bookmarkedIds); @endphp
<div class="col-12 col-md-6 col-lg-3">
<div class="card song-card h-100 p-2">
<img class="cover" src="{{ $song->cover_url }}" alt="{{ $song->title }}">
<div class="card-body">
<h2 class="h6 fw-bold">{{ $song->title }}</h2>
<p class="muted small">{{ $song->artist }}</p>
<p class="small muted">👁 {{ number_format($song->views) }}</p>
<div class="d-flex gap-2">
<a class="btn btn-primary btn-sm flex-grow-1" href="{{ route('songs.show', $song) }}">Lihat Chord</a>
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
<div class="col-12">
<div class="alert alert-light border mb-0">
@if($keyword !== '')
Tidak ada chord yang cocok dengan "<strong>{{ $keyword }}</strong>" di genre {{ $genre->name }}. <a href="{{ route('genres.show', $genre) }}">Tampilkan semua lagu {{ $genre->name }}</a>.
@else
Belum ada lagu untuk genre ini.
@endif
</div>
</div>
@endforelse
</div>
<div class="mt-4">{{ $songs->links() }}</div>
@endsection
