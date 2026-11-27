@extends('layouts.app')

@section('title', $genre->name.' Chords — ChordVerse')

@section('content')
    <div class="cv-panel mb-4">
        <div class="row align-items-lg-end g-3">
            <div class="col-lg-5">
                <span class="cv-badge"><x-icon name="music" /> Genre</span>
                <h1 class="h2 fw-bold mt-2 mb-1">{{ $genre->name }} Chords</h1>
                <p class="muted small mb-0">
                    {{ $songs->total() }} chord ditemukan@if ($keyword !== '') untuk &ldquo;{{ $keyword }}&rdquo;@endif.
                </p>
            </div>

            <div class="col-lg-7">
                <form method="GET" class="row g-2 justify-content-lg-end">
                    <div class="col-sm-6 col-lg-5">
                        <label class="visually-hidden" for="genreSearch">Cari di {{ $genre->name }}</label>
                        <input id="genreSearch" class="form-control" name="q" value="{{ $keyword }}"
                               placeholder="Cari di {{ $genre->name }}">
                    </div>
                    <div class="col-6 col-sm-3 col-lg-3">
                        <label class="visually-hidden" for="genreSort">Urutkan</label>
                        <select id="genreSort" class="form-select" name="sort" onchange="this.form.submit()">
                            <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                            <option value="terpopuler" @selected(request('sort') === 'terpopuler')>Terpopuler</option>
                        </select>
                    </div>
                    <div class="col-6 col-sm-3 col-lg-2">
                        <button class="btn btn-primary w-100" type="submit">Cari</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if ($songs->isEmpty())
        <x-empty-state icon="search"
                       title="{{ $keyword !== '' ? 'Chord tidak ditemukan' : 'Belum ada lagu' }}"
                       message="{{ $keyword !== '' ? 'Tidak ada chord yang cocok dengan pencarianmu di genre '.$genre->name.'.' : 'Belum ada chord yang dibagikan untuk genre ini.' }}">
            @if ($keyword !== '')
                <a class="btn btn-primary" href="{{ route('genres.show', $genre) }}">
                    Tampilkan semua lagu {{ $genre->name }}
                </a>
            @else
                <a class="btn btn-primary" href="{{ route('songs.create') }}">Tambah chord</a>
            @endif
        </x-empty-state>
    @else
        <div class="row g-3 g-lg-4">
            @foreach ($songs as $song)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-song-card :song="$song" :bookmarked="in_array($song->id, $bookmarkedIds)" />
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $songs->links() }}</div>
    @endif
@endsection
