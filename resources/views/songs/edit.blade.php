@extends('layouts.app')

@section('title', 'Edit chord — ChordVerse')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="cv-panel">
                <span class="cv-badge"><x-icon name="pencil" /> Edit</span>
                <h1 class="h3 fw-bold mt-2 mb-1">Edit Chord</h1>
                <p class="muted small mb-4">{{ $song->title }} — {{ $song->artist }}</p>

                <form method="POST" action="{{ route('songs.update', $song) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('songs._form', ['button' => 'Perbarui Chord', 'song' => $song])
                </form>
            </div>
        </div>
    </div>
@endsection
