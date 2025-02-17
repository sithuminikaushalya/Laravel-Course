<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $person = [
        "name" => "Zura",
        "email" => "zura@example.com",
    ];
    //dump($person); // laravel building function which build every information given variable
    // dd($person); // "dd" - dump and die
    return view('welcome');
});

// Route::get('/about', function() {
//     return view('about');
// });

Route::view('/about', 'about'); // view function is used to return view

// Route::get('/product/{id}', function(string $id) {
//     return "Product id: $id";
// });

Route::get('/product/{category?}' , function(string $category = null) {
    return "Product for category= $category";
});
