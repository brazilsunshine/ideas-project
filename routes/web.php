<?php

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/**
 * Frontend routes
 */
Route::get('/', 'Ideas\IdeaController@index');

Route::get('/ideas/{id:slug}', 'Ideas\IdeaController@show'); // id:slug will give me the slug of the idea that matches the id

Route::get('/register', function () {
    return view('root');
});

Route::get('/login', function () {
    return view('root');
});

Route::get('/dashboard', function () {
    return view('root');
});


