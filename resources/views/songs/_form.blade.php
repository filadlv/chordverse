@php $song = $song ?? null; @endphp

<div class="mb-3">
    <label class="form-label" for="title">Judul *</label>
    <input class="form-control @error('title') is-invalid @enderror" id="title" name="title"
           value="{{ old('title', $song->title ?? '') }}" maxlength="150" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="artist">Penyanyi/Band *</label>
    <input class="form-control @error('artist') is-invalid @enderror" id="artist" name="artist"
           value="{{ old('artist', $song->artist ?? '') }}" maxlength="150" required>
    @error('artist')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="genre_id">Genre *</label>
    <select class="form-select @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id" required>
        <option value="">Pilih genre</option>
        @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" @selected((string) old('genre_id', $song->genre_id ?? '') === (string) $genre->id)>
                {{ $genre->name }}
            </option>
        @endforeach
    </select>
    @error('genre_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="chord">Chord *</label>
    <textarea class="form-control @error('chord') is-invalid @enderror" id="chord" name="chord"
              rows="16" style="font-family: ui-monospace, SFMono-Regular, Menlo, monospace;" required>{{ old('chord', $song->chord ?? '') }}</textarea>
    @error('chord')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">Spasi dan baris baru akan dipertahankan.</div>
</div>

<div class="mb-3">
    <label class="form-label" for="notes">Catatan</label>
    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes"
              rows="4">{{ old('notes', $song->notes ?? '') }}</textarea>
    @error('notes')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label" for="cover">Cover (opsional)</label>
    <input class="form-control @error('cover') is-invalid @enderror" id="cover" type="file" name="cover"
           accept=".jpg,.jpeg,.png,.webp">
    @error('cover')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <div class="form-text">JPG, JPEG, PNG, atau WEBP, maksimal 2 MB. Kosongkan untuk memakai cover bawaan.</div>

    @if ($song && $song->cover)
        <img class="cover mt-2" style="max-width: 160px;" src="{{ $song->cover_url }}" alt="Cover saat ini">
        <div class="form-text">Cover saat ini. Unggah file baru untuk menggantinya.</div>
    @endif
</div>

<div class="d-flex gap-2">
    <a class="btn btn-light" href="{{ $cancelUrl ?? route('home') }}">Batal</a>
    <button class="btn btn-primary">{{ $button }}</button>
</div>
