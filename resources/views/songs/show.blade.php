@extends('layouts.app')

@section('title', $song->title.' — '.$song->artist.' | ChordVerse')
@section('description', 'Chord dan lirik lagu '.$song->title.' oleh '.$song->artist.' di ChordVerse.')

@section('content')
    <div class="mb-2">
        <a class="cv-back" href="{{ url()->previous() }}">
            <x-icon name="arrow-left" /> Kembali
        </a>
    </div>

    <div class="row g-4 g-lg-5">
        <div class="col-lg-8 order-lg-1">
            <div class="cv-song-head">
                <img class="cv-song-head__thumb d-lg-none" src="{{ $song->cover_url }}" alt="Cover {{ $song->title }}">
                <div class="min-w-0">
                    <span class="cv-badge"><x-icon name="music" />{{ $song->genre->name }}</span>
                    <h1 class="cv-song-title">{{ $song->title }}</h1>
                    <p class="cv-song-artist">{{ $song->artist }}</p>
                </div>
            </div>

            <div class="cv-song-actions">
                <button type="button" class="btn btn-primary d-inline-flex align-items-center gap-2"
                        id="copyBtn" onclick="copyChord()">
                    <x-icon name="copy" /><span data-copy-label>Copy Chord</span>
                </button>

                @auth
                    @php $isSaved = $song->isBookmarkedBy(auth()->user()); @endphp
                    <form method="POST" action="{{ route('bookmarks.toggle', $song) }}">
                        @csrf
                        <button type="submit" class="btn {{ $isSaved ? 'btn-primary' : 'btn-light' }} d-inline-flex align-items-center gap-2">
                            <x-icon name="bookmark" />{{ $isSaved ? 'Tersimpan' : 'Bookmark' }}
                        </button>
                    </form>
                @else
                    <a class="btn btn-light d-inline-flex align-items-center gap-2" href="{{ route('login') }}">
                        <x-icon name="bookmark" /> Bookmark
                    </a>
                @endauth

                @can('update', $song)
                    <a class="btn btn-light d-inline-flex align-items-center gap-2" href="{{ route('songs.edit', $song) }}">
                        <x-icon name="pencil" /> Edit
                    </a>
                @endcan

                @can('delete', $song)
                    <form method="POST" action="{{ route('songs.destroy', $song) }}" onsubmit="return confirm('Hapus chord ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger d-inline-flex align-items-center gap-2">
                            <x-icon name="trash" /> Hapus
                        </button>
                    </form>
                @endcan
            </div>

            <div class="cv-chord-toolbar">
                <span class="cv-chord-toolbar__hint">
                    <x-icon name="info" /> Geser ke samping bila baris chord terlalu panjang.
                </span>
                <span class="cv-chord-toolbar__hint">
                    <x-icon name="eye" /> {{ number_format($song->views) }} kali dilihat
                </span>
            </div>

            <div id="chordText" class="cv-chord">{{ $song->chord }}</div>

            @if ($song->notes)
                <div class="cv-notes">
                    <div class="cv-notes__title"><x-icon name="info" /> Catatan</div>
                    <p>{{ $song->notes }}</p>
                </div>
            @endif
        </div>

        <div class="col-lg-4 order-lg-2 cv-sidebar">
            <div class="cv-sticky-sidebar">
                <div class="cv-cover-frame d-none d-lg-block">
                    <img src="{{ $song->cover_url }}" alt="Cover {{ $song->title }}">
                </div>

                <div class="cv-panel cv-panel--tight cv-info-card">
                    <div class="cv-info-row">
                        <span class="cv-info-row__label"><x-icon name="music" /> Genre</span>
                        <span class="cv-info-row__value">
                            <a href="{{ route('genres.show', $song->genre) }}">{{ $song->genre->name }}</a>
                        </span>
                    </div>
                    <div class="cv-info-row">
                        <span class="cv-info-row__label"><x-icon name="eye" /> Dilihat</span>
                        <span class="cv-info-row__value">{{ number_format($song->views) }}</span>
                    </div>
                    <div class="cv-info-row">
                        <span class="cv-info-row__label"><x-icon name="clock" /> Ditambahkan</span>
                        <span class="cv-info-row__value">{{ $song->created_at->format('d M Y') }}</span>
                    </div>

                    <div class="cv-author">
                        <x-avatar :user="$song->user" size="sm" />
                        <div>
                            <div class="cv-author__name">{{ $song->user->name ?? 'Pengguna' }}</div>
                            <div class="cv-author__meta">Pembuat chord</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
