<?php

use App\Livewire\FormShow;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::get('/forms/{nanoid}', FormShow::class)->name('forms.show');
