<?php

use App\Livewire\Auth\Login;
use App\Livewire\FormShow;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    $user = Auth::user();

    if ($user->role === 'admin') {
        return redirect('/admin');
    }

    $form = Form::where('school_id', $user->school_id)
        ->where('is_active', true)
        ->latest()
        ->first();

    if ($form) {
        return redirect()->route('forms.show', $form->nanoid);
    }

    return abort(404, 'No active forms available for your school.');
})->name('home');
Route::get('/login', Login::class)->name('login')->middleware('guest');
Route::get('/forms/{nanoid}', FormShow::class)->name('forms.show');
