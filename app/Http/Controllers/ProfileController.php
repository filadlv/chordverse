<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $songs = $user->songs()->with('genre')->latest()->paginate(8, ['*'], 'songs_page');

        $bookmarks = $user->bookmarks()->with(['genre', 'user'])->latest('bookmarks.created_at')->paginate(
            8, ['*'], 'bookmarks_page'
        );

        $tab = in_array(request('tab'), ['songs', 'bookmarks', 'settings'], true)
            ? request('tab')
            : 'songs';

        return view('profile.index', compact('user', 'songs', 'bookmarks', 'tab'));
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->safe()->only(['name', 'email']);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        $request->user()->update([
            'password' => Hash::make($request->validated('password')),
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
