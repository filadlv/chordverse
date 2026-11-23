@extends('layouts.app')

@section('title', 'Edit ' . $song->title . ' | ChordVerse')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h1 class="h3 fw-bold">Edit Chord</h1>

            <form method="POST" action="{{ route('songs.update', $song) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('songs._form', [
                    'button' => 'Perbarui',
                    'song' => $song,
                    'cancelUrl' => route('songs.show', $song),
                ])
            </form>
        </div>
    </div>
</div>
@endsection
