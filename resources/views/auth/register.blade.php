@extends('layouts.app')

@section('title', 'Buat akun — ChordVerse')

@section('content')
    <div class="cv-auth">
        <aside class="cv-auth__aside">
            <div>
                <span class="cv-hero__eyebrow"><x-icon name="sparkle" /> Bergabung gratis</span>
                <h2 class="cv-auth__aside-title">Bagikan chord, temukan lagu baru.</h2>
                <p class="cv-auth__aside-text">
                    Buat akun untuk membagikan chord buatanmu dan menyimpan lagu favorit agar mudah dibuka lagi.
                </p>
            </div>

            <ul class="cv-auth__points">
                <li><x-icon name="check" /> Tambah dan kelola chord milikmu</li>
                <li><x-icon name="check" /> Simpan chord ke bookmark</li>
                <li><x-icon name="check" /> Kelola profil dan keamanan akun</li>
            </ul>
        </aside>

        <div class="cv-auth__card">
            <h1 class="cv-auth__title">Buat Akun</h1>
            <p class="cv-auth__sub">Lengkapi data di bawah untuk mulai bergabung.</p>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" for="name">Nama</label>
                    <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}" required autofocus autocomplete="name">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="username">Username</label>
                    <input id="username" class="form-control @error('username') is-invalid @enderror" name="username"
                           value="{{ old('username') }}" required autocomplete="username">
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">Dipakai untuk login. Huruf, angka, strip, dan garis bawah.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                           name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password">Password</label>
                        <div class="cv-pw">
                            <input id="password" class="form-control @error('password') is-invalid @enderror"
                                   type="password" name="password" required autocomplete="new-password">
                            <button type="button" class="cv-pw__btn" data-toggle-password="password"
                                    aria-label="Tampilkan password" aria-pressed="false">
                                <x-icon name="eye" />
                            </button>
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-text">Minimal 8 karakter.</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                        <div class="cv-pw">
                            <input id="password_confirmation" class="form-control" type="password"
                                   name="password_confirmation" required autocomplete="new-password">
                            <button type="button" class="cv-pw__btn" data-toggle-password="password_confirmation"
                                    aria-label="Tampilkan password" aria-pressed="false">
                                <x-icon name="eye" />
                            </button>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary w-100" type="submit">Daftar</button>
            </form>

            <p class="cv-auth__foot">
                Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a>
            </p>
        </div>
    </div>
@endsection
