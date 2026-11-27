@extends('layouts.app')

@section('title', 'Profil '.$user->name.' — ChordVerse')

@section('content')
    <div class="cv-profile mb-4">
        <div class="cv-profile__cover"></div>
        <div class="cv-profile__body">
            <x-avatar :user="$user" size="xl" ring class="cv-profile__avatar" />

            <div class="cv-profile__info">
                <h1 class="cv-profile__name">{{ $user->name }}</h1>
                <p class="cv-profile__handle">{{ $user->email }} &middot; &#64;{{ $user->username }}</p>
            </div>

            <div class="cv-profile__actions">
                <a class="btn btn-primary btn-sm d-inline-flex align-items-center gap-2" href="{{ route('songs.create') }}">
                    <x-icon name="plus" /> Tambah Chord
                </a>
            </div>
        </div>

        <div class="cv-profile__stats">
            <span><strong>{{ $songs->total() }}</strong> chord dibuat</span>
            <span><strong>{{ $bookmarks->total() }}</strong> lagu di-bookmark</span>
            <span>Bergabung {{ $user->created_at->format('d M Y') }}</span>
        </div>
    </div>

    <ul class="nav nav-pills cv-tabs" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab === 'songs' ? 'active' : '' }}" id="songs-tab" type="button"
                    role="tab" data-bs-toggle="pill" data-bs-target="#songs"
                    aria-controls="songs" aria-selected="{{ $tab === 'songs' ? 'true' : 'false' }}">
                Lagu Saya
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab === 'bookmarks' ? 'active' : '' }}" id="bookmarks-tab" type="button"
                    role="tab" data-bs-toggle="pill" data-bs-target="#bookmarks"
                    aria-controls="bookmarks" aria-selected="{{ $tab === 'bookmarks' ? 'true' : 'false' }}">
                Bookmark
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $tab === 'settings' ? 'active' : '' }}" id="settings-tab" type="button"
                    role="tab" data-bs-toggle="pill" data-bs-target="#settings"
                    aria-controls="settings" aria-selected="{{ $tab === 'settings' ? 'true' : 'false' }}">
                Pengaturan
            </button>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade {{ $tab === 'songs' ? 'show active' : '' }}" id="songs" role="tabpanel" aria-labelledby="songs-tab">
            @if ($songs->isEmpty())
                <x-empty-state icon="music" title="Belum ada chord"
                               message="Chord yang kamu tambahkan akan tampil di sini.">
                    <a class="btn btn-primary" href="{{ route('songs.create') }}">Tambah chord pertamamu</a>
                </x-empty-state>
            @else
                <div class="row g-3">
                    @foreach ($songs as $song)
                        <div class="col-md-6">
                            <div class="cv-row-item h-100">
                                <div class="min-w-0">
                                    <span class="cv-badge">{{ $song->genre->name }}</span>
                                    <h2 class="cv-row-item__title">{{ $song->title }}</h2>
                                    <p class="cv-row-item__meta">{{ $song->artist }}</p>
                                    <p class="cv-row-item__meta mt-1">
                                        {{ $song->created_at->format('d M Y') }} &middot; {{ number_format($song->views) }} dilihat
                                    </p>
                                </div>
                                <div class="cv-row-item__actions">
                                    <a class="btn btn-sm btn-light" href="{{ route('songs.show', $song) }}">Lihat</a>
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('songs.edit', $song) }}">Edit</a>
                                    <form method="POST" action="{{ route('songs.destroy', $song) }}"
                                          onsubmit="return confirm('Hapus chord ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">{{ $songs->links() }}</div>
            @endif
        </div>

        <div class="tab-pane fade {{ $tab === 'bookmarks' ? 'show active' : '' }}" id="bookmarks" role="tabpanel" aria-labelledby="bookmarks-tab">
            @if ($bookmarks->isEmpty())
                <x-empty-state icon="bookmark" title="Belum ada bookmark"
                               message="Tekan tombol bookmark pada halaman chord untuk menyimpannya di sini.">
                    <a class="btn btn-primary" href="{{ route('songs.search') }}">Jelajahi chord</a>
                </x-empty-state>
            @else
                <div class="row g-3">
                    @foreach ($bookmarks as $song)
                        <div class="col-md-6">
                            <div class="cv-row-item h-100">
                                <div class="min-w-0">
                                    <span class="cv-badge">{{ $song->genre->name }}</span>
                                    <h2 class="cv-row-item__title">{{ $song->title }}</h2>
                                    <p class="cv-row-item__meta">
                                        {{ $song->artist }} &middot; oleh {{ $song->user->name }}
                                    </p>
                                </div>
                                <div class="cv-row-item__actions">
                                    <a class="btn btn-sm btn-primary" href="{{ route('songs.show', $song) }}">Buka Chord</a>
                                    <form method="POST" action="{{ route('bookmarks.toggle', $song) }}"
                                          onsubmit="return confirm('Hapus lagu ini dari bookmark?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">{{ $bookmarks->links() }}</div>
            @endif
        </div>

        <div class="tab-pane fade {{ $tab === 'settings' ? 'show active' : '' }}" id="settings" role="tabpanel" aria-labelledby="settings-tab">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="cv-panel h-100">
                        <h2 class="cv-panel__title">Data Akun</h2>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="cv-file-preview mb-3">
                                <img id="avatarPreview" src="{{ $user->avatar_url }}" alt="Avatar {{ $user->name }}">
                                <div class="flex-grow-1 min-w-0">
                                    <label class="form-label" for="avatar">Avatar</label>
                                    <input id="avatar" class="form-control form-control-sm @error('avatar') is-invalid @enderror"
                                           type="file" name="avatar" accept="image/png,image/jpeg,image/webp"
                                           data-preview-target="#avatarPreview">
                                    @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="name">Nama</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                       value="{{ old('name', $user->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="username">Username</label>
                                <input id="username" class="form-control" value="{{ $user->username }}" disabled>
                                <div class="form-text">Username tidak dapat diubah setelah akun dibuat.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button class="btn btn-primary" type="submit">Simpan Profil</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="cv-panel h-100">
                        <h2 class="cv-panel__title">Ganti Password</h2>
                        <p class="muted small">Setelah password diubah, gunakan password baru pada login berikutnya.</p>

                        <form method="POST" action="{{ route('profile.password') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label" for="current_password">Password Saat Ini</label>
                                <div class="cv-pw">
                                    <input id="current_password" class="form-control @error('current_password') is-invalid @enderror"
                                           type="password" name="current_password" required autocomplete="current-password">
                                    <button type="button" class="cv-pw__btn" data-toggle-password="current_password"
                                            aria-label="Tampilkan password" aria-pressed="false">
                                        <x-icon name="eye" />
                                    </button>
                                    @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="new_password">Password Baru</label>
                                <div class="cv-pw">
                                    <input id="new_password" class="form-control @error('password') is-invalid @enderror"
                                           type="password" name="password" required autocomplete="new-password">
                                    <button type="button" class="cv-pw__btn" data-toggle-password="new_password"
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

                            <button class="btn btn-primary" type="submit">Ubah Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
