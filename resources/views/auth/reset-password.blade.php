@extends('layouts.app')

@section('title', 'Reset password — ChordVerse')

@section('content')
    <div class="cv-auth">
        <aside class="cv-auth__aside">
            <div>
                <span class="cv-hero__eyebrow"><x-icon name="lock" /> Password baru</span>
                <h2 class="cv-auth__aside-title">Buat password baru yang mudah kamu ingat.</h2>
                <p class="cv-auth__aside-text">
                    Gunakan minimal 8 karakter dan hindari password yang sama dengan akun lain.
                </p>
            </div>

            <ul class="cv-auth__points">
                <li><x-icon name="check" /> Minimal 8 karakter</li>
                <li><x-icon name="check" /> Kombinasikan huruf dan angka</li>
                <li><x-icon name="check" /> Login kembali setelah password disimpan</li>
            </ul>
        </aside>

        <div class="cv-auth__card">
            <h1 class="cv-auth__title">Reset Password</h1>
            <p class="cv-auth__sub">Buat password baru untuk akun {{ $email ?? 'kamu' }}.</p>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                           name="email" value="{{ old('email', $email) }}" required autocomplete="email">
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="form-label" for="password">Password Baru</label>
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

                <div class="mb-3">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="cv-pw">
                        <input id="password_confirmation" class="form-control" type="password"
                               name="password_confirmation" required autocomplete="new-password">
                        <button type="button" class="cv-pw__btn" data-toggle-password="password_confirmation"
                                aria-label="Tampilkan password" aria-pressed="false">
                            <x-icon name="eye" />
                        </button>
                    </div>
                </div>

                <button class="btn btn-primary w-100" type="submit">Simpan Password Baru</button>
            </form>
        </div>
    </div>
@endsection
