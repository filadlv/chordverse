<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function songs()
    {
        return $this->hasMany(Song::class);
    }

    public function bookmarks()
    {
        return $this->belongsToMany(Song::class, 'bookmarks')
            ->withTimestamps();
    }

    /**
     * Alias eksplisit untuk daftar lagu yang di-bookmark pengguna.
     */
    public function bookmarkedSongs()
    {
        return $this->bookmarks();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}