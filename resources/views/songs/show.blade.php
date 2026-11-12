@extends('layouts.app')
@section('content')
<div class="mb-3"><a href="{{ url()->previous() }}" class="text-decoration-none">← Kembali</a></div>
<div class="row g-4">
<div class="col-lg-4">
<img class="cover mb-3" src="{{ $song->cover_url }}" alt="{{ $song->title }}">
<div class="card border-0 shadow-sm rounded-4 p-3">
<div class="d-flex justify-content-between">
<div><small class="muted">Genre</small><div><a href="{{ route('genres.show',$song->genre) }}">{{ $song->genre->name }}</a></div></div>
<div class="text-end"><small class="muted">Dilihat</small><div>👁 {{ number_format($song->views) }}</div></div>
</div>
<hr>
<div><small class="muted">Pembuat Chord</small><div class="fw-semibold">{{ $song->user->name }}</div><small class="muted">{{ $song->created_at->format('d M Y') }}</small></div>
</div>
</div>
<div class="col-lg-8">
<div class="d-flex justify-content-between align-items-start gap-3">
<div><span class="badge text-bg-light mb-2">{{ $song->genre->name }}</span><h1 class="display-6 fw-bold mb-1">{{ $song->title }}</h1><p class="lead muted">{{ $song->artist }}</p></div>
@auth
<form method="POST" action="{{ route('bookmarks.toggle',$song) }}">
@csrf
<button class="btn btn-outline-primary">{{ $song->isBookmarkedBy(auth()->user()) ? '★ Tersimpan' : '☆ Bookmark' }}</button>
</form>
@else
<a class="btn btn-outline-primary" href="{{ route('login') }}">☆ Bookmark</a>
@endauth
</div>

<div class="d-flex gap-2 mb-3">
<button class="btn btn-dark" id="copyBtn" onclick="copyChord()">Copy Chord</button>
@can('update', $song)<a class="btn btn-outline-secondary" href="{{ route('songs.edit',$song) }}">Edit</a>@endcan
@can('delete', $song)
<form method="POST" action="{{ route('songs.destroy',$song) }}" onsubmit="return confirm('Hapus chord ini?')">
@csrf @method('DELETE') <button class="btn btn-outline-danger">Hapus</button>
</form>
@endcan
</div>

<div id="chordText" class="chord-box">{{ $song->chord }}</div>
@if($song->notes)
<div class="card border-0 bg-light rounded-4 p-3 mt-3"><strong>Catatan</strong><div class="mt-1">{{ $song->notes }}</div></div>
@endif
</div>
</div>
@endsection