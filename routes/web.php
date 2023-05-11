<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

// Route::get('/example', function () {
//     return view('welcome');
// });

// Route::get('/row-example', function () {
//     return view('row-example-index');
// });
