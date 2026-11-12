<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = auth()->user()->load('songs.genre');

        $songs = $user->songs()->with('genre')->latest()->paginate(8, ['*'], 'songs_page');

        $bookmarks = $user->bookmarks()->with(['genre', 'user'])->latest('bookmarks.created_at')->paginate(
            8, ['*'], 'bookmarks_page'
        );

        return view('profile.index', compact('user', 'songs', 'bookmarks'));
    }

    public function update(ProfileUpdateRequest $request)
    {
        $request->user()->update($request->validated());

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}