@props(['title', 'subtitle' => null, 'link' => null, 'linkLabel' => 'Lihat semua'])

<div class="cv-section__head">
    <div>
        <h2 class="cv-section__title">{{ $title }}</h2>
        @if ($subtitle)
            <p class="cv-section__sub">{{ $subtitle }}</p>
        @endif
    </div>

    @if (isset($action) && trim((string) $action) !== '')
        {{ $action }}
    @elseif ($link)
        <a href="{{ $link }}" class="cv-link-more">{{ $linkLabel }} <x-icon name="arrow-right" /></a>
    @endif
</div>
