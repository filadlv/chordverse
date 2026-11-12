<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Song;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Pop', 'is_featured' => true],
            ['name' => 'Rock', 'is_featured' => true],
            ['name' => 'K-Pop', 'is_featured' => true],
            ['name' => 'Indie', 'is_featured' => true],
            ['name' => 'Jazz', 'is_featured' => false],
            ['name' => 'R&B', 'is_featured' => false],
            ['name' => 'Dangdut', 'is_featured' => false],
            ['name' => 'Reggae', 'is_featured' => false],
        ];

        foreach ($genres as $item) {
            Genre::updateOrCreate(
                ['slug' => Str::slug($item['name'])],
                ['name' => $item['name'], 'is_featured' => $item['is_featured']]
            );
        }

        $admin = User::updateOrCreate(
            ['email' => 'admin@chordverse.test'],
            [
                'name' => 'Admin ChordVerse',
                'username' => 'admin',
                'password' => Hash::make('Admin12345!'),
                'role' => 'admin',
            ]
        );

        $user = User::updateOrCreate(
            ['email' => 'user@chordverse.test'],
            [
                'name' => 'Demo User',
                'username' => 'demouser',
                'password' => Hash::make('User12345!'),
                'role' => 'user',
            ]
        );

        $pop = Genre::where('slug', 'pop')->first();
        $rock = Genre::where('slug', 'rock')->first();
        $kpop = Genre::where('slug', 'k-pop')->first();

        $songs = [
            [
                'user_id' => $admin->id,
                'genre_id' => $pop->id,
                'title' => 'Contoh Lagu Pop',
                'artist' => 'ChordVerse Demo',
                'chord' => "[Intro]\nC  G  Am  F\n\n[Verse]\nC\nIni contoh chord untuk demo.\nG\nGunakan untuk menguji tampilan.",
                'notes' => 'Contoh data awal dari seeder.',
                'views' => 240,
            ],
            [
                'user_id' => $user->id,
                'genre_id' => $rock->id,
                'title' => 'Contoh Lagu Rock',
                'artist' => 'Band Demo',
                'chord' => "[Intro]\nE  A  B  E\n\n[Chorus]\nE\nContoh bagian chorus.\nA\nLanjut ke bagian berikutnya.",
                'notes' => null,
                'views' => 180,
            ],
            [
                'user_id' => $user->id,
                'genre_id' => $kpop->id,
                'title' => 'Contoh Lagu K-Pop',
                'artist' => 'K-Pop Demo',
                'chord' => "[Verse]\nAm  F  C  G\n\n[Chorus]\nC  G  Am  F",
                'notes' => 'Silakan ganti dengan chord lagu milikmu.',
                'views' => 320,
            ],
        ];

        foreach ($songs as $song) {
            Song::updateOrCreate(
                ['title' => $song['title'], 'artist' => $song['artist']],
                $song
            );
        }
    }
}