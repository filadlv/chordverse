@extends('layouts.app')
@section('content')
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
<div class="d-flex align-items-center gap-3 flex-wrap">
<img class="avatar-lg" src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}">
<div class="flex-grow-1">
<h1 class="h3 fw-bold mb-1">{{ $user->name }}</h1>
<p class="muted mb-0">{{ $user->email }} · @{{ $user->username }}</p>
</div>
<div><a class="btn btn-primary" href="{{ route('songs.create') }}">+ Tambah Chord</a></div>
</div>
<div class="d-flex gap-4 mt-3 small muted">
<span><strong class="text-dark">{{ $songs->total() }}</strong> chord dibuat</span>
<span><strong class="text-dark">{{ $bookmarks->total() }}</strong> lagu di-bookmark</span>
<span>Bergabung {{ $user->created_at->format('d M Y') }}</span>
</div>
</div>

<ul class="nav nav-pills mb-4" id="profileTabs">
<li class="nav-item"><button class="nav-link {{ $tab === 'songs' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#songs">Lagu Saya</button></li>
<li class="nav-item"><button class="nav-link {{ $tab === 'bookmarks' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#bookmarks">Bookmark</button></li>
<li class="nav-item"><button class="nav-link {{ $tab === 'settings' ? 'active' : '' }}" data-bs-toggle="pill" data-bs-target="#settings">Pengaturan</button></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade {{ $tab === 'songs' ? 'show active' : '' }}" id="songs">
<div class="row g-3">
@forelse($songs as $song)
<div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 p-3">
<div class="d-flex justify-content-between gap-3"><div><span class="badge text-bg-light">{{ $song->genre->name }}</span><h2 class="h6 fw-bold mt-2">{{ $song->title }}</h2><p class="muted small mb-0">{{ $song->artist }}</p><small class="muted">{{ $song->created_at->format('d M Y') }} · 👁 {{ number_format($song->views) }}</small></div>
<div class="d-flex gap-1 align-items-start"><a class="btn btn-sm btn-outline-secondary" href="{{ route('songs.show', $song) }}">Lihat</a>
<a class="btn btn-sm btn-outline-secondary" href="{{ route('songs.edit', $song) }}">Edit</a>
<form method="POST" action="{{ route('songs.destroy', $song) }}" onsubmit="return confirm('Hapus chord ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></div>
</div></div>
@empty <div class="col-12"><div class="alert alert-light border">Kamu belum punya chord. <a href="{{ route('songs.create') }}">Tambah chord pertamamu</a>.</div></div>@endforelse
</div>
<div class="mt-3">{{ $songs->links() }}</div>
</div>

<div class="tab-pane fade {{ $tab === 'bookmarks' ? 'show active' : '' }}" id="bookmarks">
<div class="row g-3">
@forelse($bookmarks as $song)
<div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 p-3">
<span class="badge text-bg-light">{{ $song->genre->name }}</span>
<h2 class="h6 fw-bold mt-2 mb-1">{{ $song->title }}</h2>
<p class="muted small mb-2">{{ $song->artist }} · oleh {{ $song->user->name }}</p>
<div class="d-flex gap-1">
<a class="btn btn-sm btn-primary" href="{{ route('songs.show', $song) }}">Buka Chord</a>
<form method="POST" action="{{ route('bookmarks.toggle', $song) }}" onsubmit="return confirm('Hapus lagu ini dari bookmark?')">@csrf<button class="btn btn-sm btn-outline-danger">Hapus Bookmark</button></form>
</div>
</div></div>
@empty <div class="col-12"><div class="alert alert-light border">Belum ada bookmark. Tekan tombol ☆ Bookmark pada halaman lagu untuk menyimpannya di sini.</div></div>@endforelse
</div>
<div class="mt-3">{{ $bookmarks->links() }}</div>
</div>

<div class="tab-pane fade {{ $tab === 'settings' ? 'show active' : '' }}" id="settings">
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
<h2 class="h5 fw-bold">Data Akun</h2>
<form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
@csrf @method('PUT')
<div class="d-flex align-items-center gap-3 mb-3">
<img class="avatar-lg" src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}">
<div class="flex-grow-1">
<label class="form-label" for="avatar">Avatar</label>
<input id="avatar" class="form-control @error('avatar') is-invalid @enderror" type="file" name="avatar" accept="image/png,image/jpeg,image/webp">
<div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
@error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
</div>
<div class="mb-3">
<label class="form-label" for="name">Nama</label>
<input id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" required>
@error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="mb-3">
<label class="form-label" for="username">Username</label>
<input id="username" class="form-control" value="{{ $user->username }}" disabled>
<div class="form-text">Username tidak dapat diubah setelah akun dibuat.</div>
</div>
<div class="mb-3">
<label class="form-label" for="email">Email</label>
<input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email', $user->email) }}" required>
@error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<button class="btn btn-primary">Simpan Profil</button>
</form>
</div>

<div class="card border-0 shadow-sm rounded-4 p-4">
<h2 class="h5 fw-bold">Ganti Password</h2>
<p class="muted small">Setelah password diubah, gunakan password baru pada login berikutnya.</p>
<form method="POST" action="{{ route('profile.password') }}">
@csrf @method('PUT')
<div class="mb-3">
<label class="form-label" for="current_password">Password Saat Ini</label>
<input id="current_password" class="form-control @error('current_password') is-invalid @enderror" type="password" name="current_password" required autocomplete="current-password">
@error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
<div class="col-md-6 mb-3">
<label class="form-label" for="new_password">Password Baru</label>
<input id="new_password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password">
<div class="form-text">Minimal 8 karakter.</div>
@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="col-md-6 mb-3">
<label class="form-label" for="password_confirmation">Konfirmasi Password Baru</label>
<input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
</div>
</div>
<button class="btn btn-primary">Ubah Password</button>
</form>
</div>
</div>
</div>

<style>
.avatar-lg { width:88px;height:88px;border-radius:50%;object-fit:cover;background:#ede9fe;border:3px solid #fff;box-shadow:0 6px 18px rgba(15,23,42,.08); }
</style>
@endsection
