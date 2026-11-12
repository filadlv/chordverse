<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->restrictOnDelete();
            $table->string('title', 150);
            $table->string('artist', 150);
            $table->longText('chord');
            $table->text('notes')->nullable();
            $table->string('cover')->nullable();
            $table->unsignedInteger('views')->default(0);
            $table->timestamps();

            $table->index(['title']);
            $table->index(['artist']);
            $table->index(['genre_id', 'created_at']);
            $table->index(['views']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};