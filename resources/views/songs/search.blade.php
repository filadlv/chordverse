@extends('layouts.app')

@section('title', 'Pencarian chord — ChordVerse')

@section('content')
    <div class="cv-panel mb-4">
        <span class="cv-badge"><x-icon name="search" /> Pencarian</span>
        <h1 class="h2 fw-bold mt-2 mb-1">Hasil Pencarian</h1>
        <p class="muted small mb-3">
            {{ $keyword !== '' ? 'Pencarian untuk “'.$keyword.'”' : 'Semua chord yang dibagikan pengguna' }}
            &middot; {{ $songs->total() }} hasil
        </p>

        <form action="{{ route('songs.search') }}" class="row g-2">
            <div class="col-md-9">
                <label class="visually-hidden" for="searchQuery">Judul atau penyanyi</label>
                <input id="searchQuery" class="form-control" name="q" value="{{ $keyword }}"
                       placeholder="Cari judul lagu atau penyanyi">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
        </form>
    </div>

    @if ($songs->isEmpty())
        <x-empty-state icon="search"
                       title="Chord tidak ditemukan"
                       message="Coba kata kunci lain, periksa ejaan judul, atau jelajahi chord lewat genre.">
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a class="btn btn-primary" href="{{ route('home') }}">Kembali ke Home</a>
                <a class="btn btn-light" href="{{ route('songs.search') }}">Lihat semua chord</a>
            </div>
        </x-empty-state>
    @else
        <div class="row g-3 g-lg-4">
            @foreach ($songs as $song)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-song-card :song="$song" />
                </div>
            @endforeach
        </div>

        <div class="mt-4">{{ $songs->links() }}</div>
    @endif
@endsection
