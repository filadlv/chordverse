@props(['song', 'bookmarked' => null])

@php
    $isSaved = (bool) $bookmarked;
    $detailUrl = route('songs.show', $song);
@endphp

<article class="cv-song-card">
    <a class="cv-song-card__cover" href="{{ $detailUrl }}" tabindex="-1" aria-hidden="true">
        <img src="{{ $song->cover_url }}" alt="" width="400" height="400" loading="lazy">
        @if ($song->genre)
            <span class="cv-song-card__badge">{{ $song->genre->name }}</span>
        @endif
    </a>

    @if ($bookmarked !== null)
        @auth
            <form class="cv-song-card__fav" method="POST" action="{{ route('bookmarks.toggle', $song) }}">
                @csrf
                <button type="submit"
                        class="cv-fav-btn {{ $isSaved ? 'is-active' : '' }}"
                        title="{{ $isSaved ? 'Hapus dari bookmark' : 'Simpan ke bookmark' }}"
                        aria-label="{{ $isSaved ? 'Hapus '.$song->title.' dari bookmark' : 'Simpan '.$song->title.' ke bookmark' }}">
                    <x-icon name="bookmark" />
                </button>
            </form>
        @else
            <a class="cv-song-card__fav cv-fav-btn"
               href="{{ route('login') }}"
               title="Login untuk menyimpan bookmark"
               aria-label="Login untuk menyimpan bookmark">
                <x-icon name="bookmark" />
            </a>
        @endauth
    @endif

    <div class="cv-song-card__body">
        <h3 class="cv-song-card__title"><a href="{{ $detailUrl }}">{{ $song->title }}</a></h3>
        <p class="cv-song-card__artist">{{ $song->artist }}</p>

        <div class="cv-song-card__meta">
            <span><x-icon name="eye" />{{ number_format($song->views) }}</span>
            <span><x-icon name="clock" />{{ $song->created_at?->format('d M Y') }}</span>
        </div>

        <a class="btn btn-primary btn-sm w-100" href="{{ $detailUrl }}">Lihat Chord</a>
    </div>
</article>
