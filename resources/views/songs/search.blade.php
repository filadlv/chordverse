@extends('layouts.app')
@section('content')
<div class="mb-4">
<h1 class="h3 fw-bold">Hasil Pencarian</h1>
<p class="muted">{{ $keyword !== '' ? 'Pencarian untuk: "'.$keyword.'"' : 'Semua chord' }}</p>
</div>
<form action="{{ route('songs.search') }}" class="row g-2 mb-4">
<div class="col-md-10"><input class="form-control" name="q" value="{{ $keyword }}" placeholder="Judul atau penyanyi"></div>
<div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
</form>
<div class="row g-4">
@forelse($songs as $song)
<div class="col-12 col-md-6 col-lg-3">
<div class="card song-card h-100 p-2">
<img class="cover" src="{{ $song->cover_url }}" alt="{{ $song->title }}">
<div class="card-body">
<span class="badge text-bg-light">{{ $song->genre->name }}</span>
<h2 class="h6 fw-bold mt-2">{{ $song->title }}</h2>
<p class="muted small">{{ $song->artist }}</p>
<a class="btn btn-primary btn-sm w-100" href="{{ route('songs.show', $song) }}">Lihat Chord</a>
</div>
</div>
</div>
@empty
<div class="col-12"><div class="alert alert-warning">Tidak ada chord yang cocok.</div></div>
@endforelse
</div>
<div class="mt-4">{{ $songs->links() }}</div>
@endsection