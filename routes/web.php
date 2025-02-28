<?php

use Illuminate\Support\Facades\Route;

// Default route with sample data
Route::get('/', function () {
    $person = [
        "name" => "Zura",
        "email" => "zura@example.com",
    ];
    //dump($person); // laravel building function which builds every information given variable
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

// Route::get('/product/{category?}' , function(string $category = null) {
//     return "Product for category= $category";
// });

// Product route with numeric validation
Route::get('/product/{id}', function(string $id) {
    return "Works! $id";
})->whereNumber('id');

// User route with name validation (only lowercase letters)
Route::get('/user/{name}', function(string $name) {
    return "User name: $name";
})->where('name', '[a-z]+');

// Multi-condition route (language and product ID)
Route::get("{lang}/product/{id}", function(string $lang, string $id) {
    return "Language: $lang, Product ID: $id";
})->where(['lang' => '[a-z]{2}', 'id'=> '\d{4,}']);

// Search route (matches any input)
Route::get('/search/{search}', function(string $search) {
    return $search;
})->where('search', '.+'); // Fixed missing semicolon
