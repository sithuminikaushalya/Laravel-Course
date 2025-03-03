<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;

// Default route with sample data
// Route::get('/', function () {
//     $person = [
//         "name" => "Zura",
//         "email" => "zura@example.com",
//     ];
//     //dump($person); // laravel building function which builds every information given variable
//     // dd($person); // "dd" - dump and die
//     return view('welcome');
// });

// Route::get('/', function() {

//     // $aboutPageUrl = route('about');
//     // dd($aboutPageUrl);

//     return view('welcome');
// });

Route::view('/about-us', 'about'); // view function is used to return view


// name Route with parameters

// Route::get('/{lang}/product/{id}', function (string $lang, string $id) {
//     return "Product ID: $id in Language: $lang";
// })->where(['id' => '\d+'])->name("product.view");

// Route::get('/', function () {
//     $productUrl = route('product.view', ['lang' => 'en', 'id' => 1]);
//     dd($productUrl); // Outputs: "/en/product/1"

//     return view('welcome');
// });

Route::get('/', function() {
    return view('welcome');
});

Route::get('/user/profile', function(){})->name('profile');

Route::get('/current-user', function(){
    return to_route('profile');
});

//group routes
Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
      return '/admin/users';
    });
});

// fallback
Route::fallback(function() {
    return 'Falback';
});

Route::get('car', [CarController::class, 'index']);

// Route::get('/sum/{a}/{b}', function(float $a, float $b) {
//     return $a + $b;
// })->whereNumber(['a', 'b']);

// Route::get('/product/{id}', function(string $id) {
//     return "Product id: $id";
// });

// Route::get('/product/{category?}' , function(string $category = null) {
//     return "Product for category= $category";
// });

// Product route with numeric validation
// Route::get('/product/{id}', function(string $id) {
//     return "Works! $id";
// })->whereNumber('id');

// // User route with name validation (only lowercase letters)
// Route::get('/user/{name}', function(string $name) {
//     return "User name: $name";
// })->where('name', '[a-z]+');

// // Multi-condition route (language and product ID)
// Route::get("{lang}/product/{id}", function(string $lang, string $id) {
//     return "Language: $lang, Product ID: $id";
// })->where(['lang' => '[a-z]{2}', 'id'=> '\d{4,}']);

// // Search route (matches any input)
// Route::get('/search/{search}', function(string $search) {
//     return $search;
// })->where('search', '.+'); // Fixed missing semicolon
