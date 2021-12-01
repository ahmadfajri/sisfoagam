<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view("admin.auth.login");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/admin.php';

// Delete Detail

