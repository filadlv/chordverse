@extends('layouts.app')
@section('content')
<div class="row justify-content-center">
<div class="col-md-6 col-lg-5">
<div class="card border-0 shadow-sm rounded-4 p-4">
<h1 class="h3 fw-bold mb-1">Lupa Password</h1>
<p class="muted mb-4">Masukkan email akunmu, kami akan mengirim tautan untuk membuat password baru.</p>
<form method="POST" action="{{ route('password.email') }}">
@csrf
<div class="mb-3">
<label class="form-label" for="email">Email</label>
<input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email">
@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button class="btn btn-primary w-100">Kirim Tautan Reset</button>
</form>
<p class="text-center muted mt-4 mb-0">Sudah ingat password? <a href="{{ route('login') }}">Kembali ke login</a></p>
</div>
</div>
</div>
@endsection
