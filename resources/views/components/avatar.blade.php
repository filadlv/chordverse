@props(['user' => null, 'size' => 'md', 'ring' => false])

@php
    $sizes = ['sm' => 34, 'md' => 48, 'xl' => 92];
    $px = $sizes[$size] ?? $sizes['md'];
    $src = $user?->avatar_url ?? asset('images/default-avatar.svg');
    $name = $user?->name ?? 'Pengguna';
@endphp

<img src="{{ $src }}"
     alt="Avatar {{ $name }}"
     width="{{ $px }}"
     height="{{ $px }}"
     loading="lazy"
     {{ $attributes->merge(['class' => 'cv-avatar cv-avatar--'.$size.($ring ? ' cv-avatar--ring' : '')]) }}>
