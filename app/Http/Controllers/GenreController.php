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

        if ($request->filled('q')) {
            $keyword = trim($request->string('q'));
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('artist', 'like', "%{$keyword}%");
            });
        }

        $sort = $request->string('sort', 'terbaru');

        if ($sort === 'terpopuler') {
            $query->orderByDesc('views')->latest();
        } else {
            $query->latest();
        }

        $songs = $query->paginate(12)->withQueryString();

        return view('genres.show', compact('genre', 'songs'));
    }
}