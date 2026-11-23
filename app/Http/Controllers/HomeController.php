<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Song;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $genres = Genre::withCount('songs')
            ->orderByDesc('is_featured')
            ->orderBy('name')
            ->get();

        $popularSongs = Song::with(['genre', 'user'])
            ->orderByDesc('views')
            ->latest()
            ->take(8)
            ->get();

        $bookmarkedIds = $this->bookmarkedSongIds();

        return view('home', compact('genres', 'popularSongs', 'bookmarkedIds'));
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
