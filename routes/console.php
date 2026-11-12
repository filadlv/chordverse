<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('chordverse:info', function () {
    $this->info('ChordVerse Laravel 13');
});

