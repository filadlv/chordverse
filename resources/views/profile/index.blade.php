@extends('layouts.app')
@section('content')
<div class="row align-items-center mb-4">
<div class="col"><h1 class="h2 fw-bold mb-1">Profil</h1><p class="muted mb-0">{{ $user->name }} · {{ $user->email }}</p></div>
<div class="col-auto"><a class="btn btn-primary" href="{{ route('songs.create') }}">+ Tambah Chord</a></div>
</div>

<ul class="nav nav-pills mb-4" id="profileTabs">
<li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#songs">Lagu Saya</button></li>
<li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#bookmarks">Bookmark</button></li>
<li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#settings">Pengaturan</button></li>
</ul>

<div class="tab-content">
<div class="tab-pane fade show active" id="songs">
<div class="row g-3">
@forelse($songs as $song)
<div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 p-3">
<div class="d-flex justify-content-between gap-3"><div><span class="badge text-bg-light">{{ $song->genre->name }}</span><h2 class="h6 fw-bold mt-2">{{ $song->title }}</h2><p class="muted small mb-0">{{ $song->artist }}</p></div>
<div class="d-flex gap-1"><a class="btn btn-sm btn-outline-secondary" href="{{ route('songs.edit',$song) }}">Edit</a>
<form method="POST" action="{{ route('songs.destroy',$song) }}" onsubmit="return confirm('Hapus chord ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form></div></div>
</div></div>
@empty <div class="col-12"><div class="alert alert-light border">Kamu belum punya chord.</div></div>@endforelse
</div>
<div class="mt-3">{{ $songs->links() }}</div>
</div>

<div class="tab-pane fade" id="bookmarks">
<div class="row g-3">
@forelse($bookmarks as $song)
<div class="col-md-6"><div class="card border-0 shadow-sm rounded-4 p-3"><span class="badge text-bg-light">{{ $song->genre->name }}</span><h2 class="h6 fw-bold mt-2">{{ $song->title }}</h2><p class="muted small">{{ $song->artist }}</p><a class="btn btn-sm btn-primary" href="{{ route('songs.show',$song) }}">Buka Chord</a></div></div>
@empty <div class="col-12"><div class="alert alert-light border">Belum ada bookmark.</div></div>@endforelse
</div>
<div class="mt-3">{{ $bookmarks->links() }}</div>
</div>

<div class="tab-pane fade" id="settings">
<div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
<h2 class="h5 fw-bold">Data Akun</h2>
<form method="POST" action="{{ route('profile.update') }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ $user->name }}" required></div>
<div class="mb-3"><label class="form-label">Username</label><input class="form-control" value="{{ $user->username }}" disabled></div>
<div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ $user->email }}" required></div>
<button class="btn btn-primary">Simpan Profil</button>
</form>
</div>
<div class="card border-0 shadow-sm rounded-4 p-4">
<h2 class="h5 fw-bold">Ganti Password</h2>
<form method="POST" action="{{ route('profile.password') }}">@csrf @method('PUT')
<div class="mb-3"><label class="form-label">Password Saat Ini</label><input class="form-control" type="password" name="current_password" required></div>
<div class="mb-3"><label class="form-label">Password Baru</label><input class="form-control" type="password" name="password" required></div>
<div class="mb-3"><label class="form-label">Konfirmasi Password</label><input class="form-control" type="password" name="password_confirmation" required></div>
<button class="btn btn-primary">Ubah Password</button>
</form>
</div>
</div>
</div>
@endsection