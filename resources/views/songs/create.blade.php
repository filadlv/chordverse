@extends('layouts.app')

@section('title', 'Tambah chord — ChordVerse')

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="cv-panel">
                <span class="cv-badge"><x-icon name="plus" /> Chord baru</span>
                <h1 class="h3 fw-bold mt-2 mb-1">Tambah Chord</h1>
                <p class="muted small mb-4">Pembuat chord otomatis diambil dari akun yang sedang login.</p>

                <form method="POST" action="{{ route('songs.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('songs._form', ['button' => 'Simpan Chord'])
                </form>
            </div>
        </div>
    </div>
@endsection
