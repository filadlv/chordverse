@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Reset Password</h1>
<p class="muted mb-4">Buat password baru untuk akun {{ $email ?? 'kamu' }}.</p>
<form method="POST" action="{{ route('password.store') }}">
@csrf
<input type="hidden" name="token" value="{{ $token }}">
<div class="mb-3">
<label class="form-label" for="email">Email</label>
<input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email">
@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label" for="password">Password Baru</label>
<input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
<div class="form-text">Minimal 8 karakter.</div>
@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
<input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
</div>
<button class="btn btn-primary w-100">Simpan Password Baru</button>
</form>
</div>
</div>
</div>
@endsection
