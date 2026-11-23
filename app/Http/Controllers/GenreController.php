<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GenreController extends Controller
{
    public function show(Request $request, Genre $genre): View
    {
        $query = $genre->songs()->with(['user', 'genre']);

        $keyword = trim((string) $request->query('q', ''));

        if ($keyword !== '') {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('artist', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->query('sort', 'terbaru') === 'terpopuler' ? 'terpopuler' : 'terbaru';

        if ($sort === 'terpopuler') {
            $query->orderByDesc('views')->latest();
        } else {
            $query->latest();
        }

        $songs = $query->paginate(12)->withQueryString();

        $bookmarkedIds = $this->bookmarkedSongIds();

        return view('genres.show', compact('genre', 'songs', 'bookmarkedIds', 'keyword'));
    }

    private function bookmarkedSongIds(): array
    {
        $user = auth()->user();

        if (! $user) {
            return [];
        }

        return $user->bookmarks()->pluck('songs.id')->all();
    }
}
