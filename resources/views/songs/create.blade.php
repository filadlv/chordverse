@extends('layouts.app')

@section('title', 'Tambah Chord | ChordVerse')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4">
            <h1 class="h3 fw-bold">Tambah Chord</h1>
            <p class="muted">Pembuat otomatis diambil dari akun yang sedang login.</p>

            <form method="POST" action="{{ route('songs.store') }}" enctype="multipart/form-data">
                @csrf
                @include('songs._form', ['button' => 'Simpan', 'cancelUrl' => route('home')])
            </form>
        </div>
    </div>
</div>
@endsection
