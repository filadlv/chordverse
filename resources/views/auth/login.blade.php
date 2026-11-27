@extends('layouts.app')

@section('title', 'Login — ChordVerse')

@section('content')
    <div class="cv-auth">
        <aside class="cv-auth__aside">
            <div>
                <span class="cv-hero__eyebrow"><x-icon name="music" /> Selamat datang kembali</span>
                <h2 class="cv-auth__aside-title">Lanjutkan bermain dari chord terakhirmu.</h2>
                <p class="cv-auth__aside-text">
                    Masuk untuk menambah chord, mengelola lagu milikmu, dan menyimpan lagu favorit ke bookmark.
                </p>
            </div>

            <ul class="cv-auth__points">
                <li><x-icon name="check" /> Kelola chord yang kamu buat sendiri</li>
                <li><x-icon name="check" /> Simpan lagu favorit ke bookmark</li>
                <li><x-icon name="check" /> Atur profil dan keamanan akun</li>
            </ul>
        </aside>

        <div class="cv-auth__card">
            <h1 class="cv-auth__title">Login</h1>
            <p class="cv-auth__sub">Masuk dengan email atau username.</p>

            <form method="POST" action="{{ route('login.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="login">Email atau Username</label>
                    <input id="login" class="form-control @error('login') is-invalid @enderror" name="login"
                           value="{{ old('login') }}" required autofocus autocomplete="username">
                    @error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label" for="password">Password</label>
                        <a class="small fw-semibold" href="{{ route('password.request') }}">Lupa password?</a>
                    </div>
                    <div class="cv-pw">
                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                               type="password" name="password" required autocomplete="current-password">
                        <button type="button" class="cv-pw__btn" data-toggle-password="password"
                                aria-label="Tampilkan password" aria-pressed="false">
                            <x-icon name="eye" />
                        </button>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>

                <button class="btn btn-primary w-100" type="submit">Login</button>
            </form>

            <p class="cv-auth__foot">
                Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
            </p>
        </div>
    </div>
@endsection
