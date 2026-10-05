<?php

use App\Livewire\FormShow;
use App\Livewire\Login;
use App\Livewire\Register;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    return redirect('/');
})->middleware('auth')->name('dashboard');
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/register', Register::class)->name('register')->middleware('guest');
Route::get('/forms/{nanoid}', FormShow::class)->name('forms.show');
Route::post('/logout', function () { Auth::logout(); return redirect('/'); })->name('logout');
