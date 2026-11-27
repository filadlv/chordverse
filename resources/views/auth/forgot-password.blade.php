@extends('layouts.app')

@section('title', 'Lupa password — ChordVerse')

@section('content')
    <div class="cv-auth">
        <aside class="cv-auth__aside">
            <div>
                <span class="cv-hero__eyebrow"><x-icon name="lock" /> Keamanan akun</span>
                <h2 class="cv-auth__aside-title">Kami bantu kamu masuk kembali.</h2>
                <p class="cv-auth__aside-text">
                    Masukkan email akunmu, lalu ikuti tautan yang kami kirim untuk membuat password baru.
                </p>
            </div>

            <ul class="cv-auth__points">
                <li><x-icon name="check" /> Tautan reset berlaku terbatas</li>
                <li><x-icon name="check" /> Password lama tidak lagi dipakai</li>
                <li><x-icon name="check" /> Data chord dan bookmark tetap aman</li>
            </ul>
        </aside>

        <div class="cv-auth__card">
            <h1 class="cv-auth__title">Lupa Password</h1>
            <p class="cv-auth__sub">Masukkan email akunmu untuk menerima tautan reset.</p>

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                           name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button class="btn btn-primary w-100" type="submit">Kirim Tautan Reset</button>
            </form>

            <p class="cv-auth__foot">
                Sudah ingat password? <a href="{{ route('login') }}">Kembali ke login</a>
            </p>
        </div>
    </div>
@endsection
