<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\RedirectResponse;

class BookmarkController extends Controller
{
    public function toggle(Song $song): RedirectResponse
    {
        $user = auth()->user();

        if ($user->bookmarks()->whereKey($song->id)->exists()) {
            $user->bookmarks()->detach($song->id);
            $message = 'Bookmark dihapus.';
        } else {
            $user->bookmarks()->attach($song->id);
            $message = 'Lagu ditambahkan ke bookmark.';
        }

        return back()->with('success', $message);
    }
}