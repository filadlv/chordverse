<div class="mb-3"><label class="form-label">Judul *</label><input class="form-control" name="title" value="{{ old('title',$song->title ?? '') }}" required></div>
<div class="mb-3"><label class="form-label">Penyanyi/Band *</label><input class="form-control" name="artist" value="{{ old('artist',$song->artist ?? '') }}" required></div>
<div class="mb-3"><label class="form-label">Genre *</label><select class="form-select" name="genre_id" required>
<option value="">Pilih genre</option>
@foreach($genres as $genre)<option value="{{ $genre->id }}" @selected(old('genre_id',$song->genre_id ?? '')==$genre->id)>{{ $genre->name }}</option>@endforeach
</select></div>
<div class="mb-3"><label class="form-label">Chord *</label><textarea class="form-control" name="chord" rows="16" style="font-family:monospace" required>{{ old('chord',$song->chord ?? '') }}</textarea><div class="form-text">Spasi dan baris baru akan dipertahankan.</div></div>
<div class="mb-3"><label class="form-label">Catatan</label><textarea class="form-control" name="notes" rows="4">{{ old('notes',$song->notes ?? '') }}</textarea></div>
<div class="mb-3"><label class="form-label">Cover</label><input class="form-control" type="file" name="cover" accept=".jpg,.jpeg,.png,.webp"></div>
<div class="d-flex gap-2"><a class="btn btn-light" href="{{ route('profile') }}">Batal</a><button class="btn btn-primary">{{ $button }}</button></div>