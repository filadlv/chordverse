@props(['genre'])

<a href="{{ route('genres.show', $genre) }}" class="cv-genre-card">
    <span class="cv-genre-card__icon"><x-icon name="music" /></span>
    <span class="cv-genre-card__name">{{ $genre->name }}</span>
    <span class="cv-genre-card__count">{{ $genre->songs_count ?? 0 }} chord</span>
    <span class="cv-genre-card__arrow"><x-icon name="arrow-right" /></span>
</a>
