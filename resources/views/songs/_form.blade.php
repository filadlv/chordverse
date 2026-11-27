@php($song = $song ?? null)

<div class="row g-3">
    <div class="col-md-7">
        <label class="form-label" for="title">Judul lagu <span class="text-danger">*</span></label>
        <input id="title" class="form-control @error('title') is-invalid @enderror" name="title"
               value="{{ old('title', $song->title ?? '') }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-5">
        <label class="form-label" for="artist">Penyanyi / Band <span class="text-danger">*</span></label>
        <input id="artist" class="form-control @error('artist') is-invalid @enderror" name="artist"
               value="{{ old('artist', $song->artist ?? '') }}" required>
        @error('artist')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-5">
        <label class="form-label" for="genre_id">Genre <span class="text-danger">*</span></label>
        <select id="genre_id" class="form-select @error('genre_id') is-invalid @enderror" name="genre_id" required>
            <option value="">Pilih genre</option>
            @foreach ($genres as $genre)
                <option value="{{ $genre->id }}" @selected(old('genre_id', $song->genre_id ?? '') == $genre->id)>
                    {{ $genre->name }}
                </option>
            @endforeach
        </select>
        @error('genre_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-7">
        <label class="form-label" for="cover">Cover lagu</label>
        <input id="cover" class="form-control @error('cover') is-invalid @enderror" type="file" name="cover"
               accept=".jpg,.jpeg,.png,.webp" data-preview-target="#coverPreview">
        @error('cover')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="cv-file-preview mt-2">
            <img id="coverPreview" src="{{ $song->cover_url ?? asset('images/default-cover.svg') }}" alt="Pratinjau cover">
            <div class="small muted">JPG, PNG, atau WEBP. Maksimal 2 MB. Kosongkan bila tidak ingin mengganti cover.</div>
        </div>
    </div>

    <div class="col-12">
        <label class="form-label" for="chord">Chord <span class="text-danger">*</span></label>
        <textarea id="chord" class="form-control @error('chord') is-invalid @enderror" name="chord"
                  rows="16" style="font-family: var(--cv-mono); line-height: 1.7" required>{{ old('chord', $song->chord ?? '') }}</textarea>
        @error('chord')<div class="invalid-feedback">{{ $message }}</div>@enderror
        <div class="form-text">Spasi dan baris baru akan dipertahankan agar posisi chord tetap rapi.</div>
    </div>

    <div class="col-12">
        <label class="form-label" for="notes">Catatan <span class="muted fw-normal">(opsional)</span></label>
        <textarea id="notes" class="form-control @error('notes') is-invalid @enderror" name="notes" rows="4">{{ old('notes', $song->notes ?? '') }}</textarea>
        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="d-flex flex-wrap gap-2 mt-4">
    <button class="btn btn-primary" type="submit">{{ $button }}</button>
    <a class="btn btn-light" href="{{ route('profile') }}">Batal</a>
</div>
