@props(['icon' => 'music', 'title', 'message' => null])

<div class="cv-empty">
    <div class="cv-empty__icon"><x-icon :name="$icon" /></div>
    <h3 class="cv-empty__title">{{ $title }}</h3>
    @if ($message)
        <p class="cv-empty__text">{{ $message }}</p>
    @endif
    {{ $slot }}
</div>
