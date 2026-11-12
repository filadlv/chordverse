@extends('layouts.app')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
<div><p class="muted mb-1">Genre</p><h1 class="h2 fw-bold mb-0">{{ $genre->name }} Chords</h1></div>
<form class="d-flex gap-2" method="GET">
<input class="form-control" name="q" value="{{ request('q') }}" placeholder="Cari di {{ $genre->name }}">
<select class="form-select" name="sort" onchange="this.form.submit()">
<option value="terbaru" @selected(request('sort','terbaru')==='terbaru')>Terbaru</option>
<option value="terpopuler" @selected(request('sort')==='terpopuler')>Terpopuler</option>
</select>
<button class="btn btn-primary">Cari</button>
</form>
</div>
<div class="row g-4">
@forelse($songs as $song)
<div class="col-12 col-md-6 col-lg-3">
<div class="card song-card h-100 p-2">
<img class="cover" src="{{ $song->cover_url }}" alt="{{ $song->title }}">
<div class="card-body">
<h2 class="h6 fw-bold">{{ $song->title }}</h2>
<p class="muted small">{{ $song->artist }}</p>
<p class="small muted">👁 {{ number_format($song->views) }}</p>
<a class="btn btn-primary btn-sm w-100" href="{{ route('songs.show', $song) }}">Lihat Chord</a>
</div>
</div>
</div>
@empty
<div class="col-12"><div class="alert alert-light border">Belum ada lagu untuk genre ini.</div></div>
@endforelse
</div>
<div class="mt-4">{{ $songs->links() }}</div>
@endsection