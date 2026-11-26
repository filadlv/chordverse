@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Login</h1>
<p class="muted mb-4">Masuk untuk menambah, mengelola, dan menyimpan chord favoritmu.</p>
<form method="POST" action="{{ route('login.store') }}">
@csrf
<div class="mb-3">
<label class="form-label" for="login">Email atau Username</label>
<input id="login" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autofocus autocomplete="username">
@error('login')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<div class="d-flex justify-content-between">
<label class="form-label" for="password">Password</label>
<a class="small" href="{{ route('password.request') }}">Lupa password?</a>
</div>
<input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password">
@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}><label class="form-check-label" for="remember">Ingat saya</label></div>
<button class="btn btn-primary w-100">Login</button>
</form>
<p class="text-center muted mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
</div>
</div>
</div>
@endsection
