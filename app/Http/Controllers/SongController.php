<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSongRequest;
use App\Http\Requests\UpdateSongRequest;
use App\Models\Genre;
use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SongController extends Controller
{
    public function search(Request $request): View
    {
        $keyword = trim($request->string('q'));

        $songs = Song::with(['genre', 'user'])
            ->when($keyword !== '', function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'like', "%{$keyword}%")
                      ->orWhere('artist', 'like', "%{$keyword}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('songs.search', compact('songs', 'keyword'));
    }

    /**
     * Halaman detail chord: dapat dibuka semua pengunjung dan
     * menambah jumlah dilihat satu kali setiap kali dibuka.
     */
    public function show(Song $song): View
    {
        $song->increment('views');

        $song->load(['user', 'genre']);

        return view('songs.show', compact('song'));
    }

    public function create(): View
    {
        $genres = Genre::orderBy('name')->get();

        return view('songs.create', compact('genres'));
    }

    public function store(StoreSongRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->id;

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $song = Song::create($data);

        return redirect()
            ->route('songs.show', $song)
            ->with('success', 'Chord berhasil ditambahkan.');
    }

    public function edit(Song $song): View
    {
        $this->authorize('update', $song);

        $genres = Genre::orderBy('name')->get();

        return view('songs.edit', compact('song', 'genres'));
    }

    public function update(UpdateSongRequest $request, Song $song): RedirectResponse
    {
        $this->authorize('update', $song);

        $data = $request->validated();

        if ($request->hasFile('cover')) {
            if ($song->cover) {
                Storage::disk('public')->delete($song->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $song->update($data);

        return redirect()
            ->route('songs.show', $song)
            ->with('success', 'Chord berhasil diperbarui.');
    }

    public function destroy(Song $song): RedirectResponse
    {
        $this->authorize('delete', $song);

        if ($song->cover) {
            Storage::disk('public')->delete($song->cover);
        }

        $song->delete();

        return redirect()
            ->route('profile')
            ->with('success', 'Chord berhasil dihapus.');
    }
}
