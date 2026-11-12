@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Login</h1>
<p class="muted mb-4">Masuk untuk menambah dan mengelola chord.</p>
<form method="POST" action="{{ route('login.store') }}">
@csrf
<div class="mb-3"><label class="form-label">Email atau Username</label><input class="form-control" name="login" value="{{ old('login') }}" required autofocus></div>
<div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
<div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
<button class="btn btn-primary w-100">Login</button>
</form>
<p class="text-center muted mt-4 mb-0">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
</div>
</div>
</div>
@endsection