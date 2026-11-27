@props(['href' => null])

<a href="{{ $href ?? route('home') }}" class="cv-brand" aria-label="ChordVerse — beranda">
    <span class="cv-brand__mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9"
             stroke-linecap="round" stroke-linejoin="round" focusable="false">
            <path d="M9 18V5l11-2v13"/>
            <circle cx="6" cy="18" r="3"/>
            <circle cx="17" cy="16" r="3"/>
        </svg>
    </span>
    <span class="cv-brand__text">Chord<span>Verse</span></span>
</a>
