<?php

use App\Livewire\Auth\Login;
use App\Livewire\FormShow;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/forms/{nanoid}', FormShow::class)->name('forms.show');
