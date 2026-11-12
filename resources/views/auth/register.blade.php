@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-7 col-lg-6">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Buat Akun</h1>
<p class="muted mb-4">Daftar untuk membagikan chord buatanmu.</p>
<form method="POST" action="{{ route('register.store') }}">
@csrf
<div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
<div class="mb-3"><label class="form-label">Username</label><input class="form-control" name="username" value="{{ old('username') }}" required></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
<div class="row">
<div class="col-md-6 mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
<div class="col-md-6 mb-3"><label class="form-label">Konfirmasi Password</label><input class="form-control" type="password" name="password_confirmation" required></div>
</div>
<button class="btn btn-primary w-100">Daftar</button>
</form>
<p class="text-center muted mt-4 mb-0">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
</div>
</div>
</div>
@endsection