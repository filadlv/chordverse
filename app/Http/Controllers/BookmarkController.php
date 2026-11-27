<?php

namespace App\Http\Controllers;

use App\Models\Song;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /**
     * Simpan atau batalkan bookmark lagu untuk pengguna yang sedang login.
     */
    public function toggle(Request $request, Song $song): RedirectResponse
    {
        $user = $request->user();

        $removed = $user->bookmarks()->detach($song->id);

        if ($removed > 0) {
            return back()->with('success', 'Bookmark dihapus.');
        }

        $user->bookmarks()->attach($song->id);

        return back()->with('success', 'Lagu ditambahkan ke bookmark.');
    }
}
