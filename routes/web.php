<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.index');
});


Route::get('/book', function () {
    return view('pages.book-sessions');
});

Route::get('/counselors', function () {
    return view('pages.counselors');
});
