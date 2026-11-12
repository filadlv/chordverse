<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'genre_id',
        'title',
        'artist',
        'chord',
        'notes',
        'cover',
        'views',
    ];

    protected $hidden = [];

    protected $casts = [
        'views' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function bookmarkedBy()
    {
        return $this->belongsToMany(User::class, 'bookmarks')
            ->withTimestamps();
    }

    public function isBookmarkedBy(?User $user): bool
    {
        if (!$user) {
            return false;
        }

        return $this->bookmarkedBy()->whereKey($user->id)->exists();
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover
            ? asset('storage/' . $this->cover)
            : asset('images/default-cover.svg');
    }
}