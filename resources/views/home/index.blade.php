@extends('layouts.app')

@section('title', 'ChordVerse — Cari chord lagu favoritmu')

@section('content')
    <section class="cv-hero">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="cv-hero__eyebrow"><x-icon name="sparkle" /> Web chord untuk semua musisi</span>
                <h1 class="cv-hero__title">Cari chord lagu favoritmu,<br><span>mainkan tanpa hambatan.</span></h1>
                <p class="cv-hero__lead">
                    Temukan chord berdasarkan judul lagu atau nama penyanyi, lalu buka halaman chord yang
                    mudah dibaca di laptop maupun smartphone.
                </p>

                <form action="{{ route('songs.search') }}" class="cv-hero__search" role="search">
                    <div class="cv-hero__search-field">
                        <x-icon name="search" />
                        <input class="form-control" type="search" name="q" value="{{ request('q') }}"
                               placeholder="Cari judul lagu atau penyanyi..." aria-label="Cari judul lagu atau penyanyi">
                    </div>
                    <button class="btn btn-lg" type="submit">Cari Chord</button>
                </form>

                <div class="cv-hero__meta">
                    <span><x-icon name="grid" />{{ $genres->count() }} genre</span>
                    <span><x-icon name="bookmark" />Simpan chord favorit</span>
                    <span><x-icon name="copy" />Salin chord sekali klik</span>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block">
                <div class="cv-hero__art" aria-hidden="true">
                    <div class="cv-hero__art-card">
                        <div class="cv-hero__art-top">
                            <span class="cv-hero__art-dots"><i></i><i></i><i></i></span>
                            <span class="cv-hero__art-tag">Chord Sheet</span>
                        </div>
                        <div class="cv-hero__art-chords">
                            <span>Am</span><span>F</span><span>C</span><span>G</span>
                        </div>
                        <div class="cv-hero__art-lines">
                            <i></i><i></i><i></i><i></i><i></i><i></i>
                        </div>
                        <div class="cv-hero__art-chords">
                            <span>Dm</span><span>G</span><span>C</span><span>E7</span>
                        </div>
                        <div class="cv-hero__art-lines">
                            <i></i><i></i><i></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cv-section">
        <x-section-header title="Kategori Genre"
                          subtitle="Mulai dari genre yang paling kamu sukai."
                          :link="route('songs.search')"
                          link-label="Semua chord" />

        <div class="row g-3">
            @foreach ($genres as $genre)
                <div class="col-6 col-md-4 col-lg-3">
                    <x-genre-card :genre="$genre" />
                </div>
            @endforeach
        </div>
    </section>

    <section class="cv-section">
        <x-section-header title="Lagu Populer"
                          subtitle="Chord yang paling banyak dibuka pengunjung."
                          :link="route('songs.search')" />

        @if ($popularSongs->isEmpty())
            <x-empty-state icon="music"
                           title="Belum ada lagu"
                           message="Chord yang dibagikan pengguna akan muncul di sini.">
                <a class="btn btn-primary" href="{{ route('songs.create') }}">Tambah chord pertama</a>
            </x-empty-state>
        @else
            <div class="row g-3 g-lg-4">
                @foreach ($popularSongs as $song)
                    <div class="col-6 col-md-4 col-lg-3">
                        <x-song-card :song="$song" :bookmarked="in_array($song->id, $bookmarkedIds)" />
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection
