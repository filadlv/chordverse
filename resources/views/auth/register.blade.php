@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-7 col-lg-6">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Buat Akun</h1>
<p class="muted mb-4">Daftar untuk membagikan chord buatanmu dan menyimpan lagu favorit.</p>
<form method="POST" action="{{ route('register.store') }}">
@csrf
<div class="mb-3">
<label class="form-label" for="name">Nama</label>
<input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label" for="username">Username</label>
<input id="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username">
<div class="form-text">Dipakai untuk login. Huruf, angka, strip, dan garis bawah.</div>
@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label" for="email">Email</label>
<input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label class="form-label" for="password">Password</label>
<input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
<div class="form-text">Minimal 8 karakter.</div>
@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6 mb-3">
<label class="form-label" for="password_confirmation">Konfirmasi Password</label>
<input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
</div>
</div>
<button class="btn btn-primary w-100">Daftar</button>
</form>
<p class="text-center muted mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</div>
</div>
</div>
@endsection
