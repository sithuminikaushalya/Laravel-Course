# Laravel Routing Basics

This repository provides examples and explanations of basic routing in Laravel. Routing is a core feature of Laravel that allows you to define how your application responds to client requests.

## Table of Contents
1. [Basic Routing](#basic-routing)
2. [Available Request Methods](#available-request-methods)
3. [Route Matching Multiple Methods](#route-matching-multiple-methods)
4. [Route Matching All Methods](#route-matching-all-methods)
5. [Redirect Routes](#redirect-routes)
6. [View Routes](#view-routes)
7. [Route Required Parameters](#route-required-parameters)
8. [Route Optional Parameters](#route-optional-parameters)

---

## Basic Routing

The simplest form of routing in Laravel is defining a route that responds to a specific URI and returns a view or response.

```php
Route::get('/about', function() {
    return view('about');
});
```
---

## Available Request Methods

Laravel provides several request methods to handle different types of HTTP requests:

```php
Route::get($uri, $callback);     // Get the information
Route::post($uri, $callback);    // Create new information
Route::put($uri, $callback);     // Full update (replaces resource)
Route::patch($uri, $callback);   // Partial update (modifies specific fields)
Route::delete($uri, $callback);  // Delete the information
Route::options($uri, $callback); // Get more information about the resource
```
---

## Route Matching Multiple Methods

You can define a route that responds to multiple HTTP methods using Route::match().

```php
Route::match(['get', 'post'], '/', function () {
    return "This route responds to both GET and POST requests.";
});
```

---

## Route Matching All Methods

If you want a route to respond to all HTTP request methods, you can use Route::any().

```php
Route::any('/', function () {
    return "This route responds to all HTTP request methods.";
});
```

---

## Redirect Routes

Laravel provides a simple way to redirect one URI to another using Route::redirect().

```php
// Basic redirect
Route::redirect('/home', '/');

// Permanent redirect with 301 status code
Route::redirect('/home', '/', 301);

// Alternative way for permanent redirect
Route::permanentRedirect('/home', '/');
```

---

### View Routes

You can return a view directly using Route::view() without needing a controller or closure.

```php
// Basic view route
Route::view('/contact', 'contact');

// View route with data passed to the view
Route::view('/contact', 'contact', ['phone' => '+995557123456']);
```

---

## Route Required Parameters

Laravel routes can accept required parameters, which are passed to the callback function.

```php
Route::get('/product/{id}', function (string $id) {
    return "Product ID = $id";
});
```

Matches the following URLs:

/product/1
/product/test
/product/{any_string}

```php
Route::get(
    '{lang}/product/{id}/review/{reviewId}', 
    function (string $lang, string $id, string $reviewId) {
        return "Language = $lang, Product ID = $id, Review ID = $reviewId";
    }
);
```

Matches the following URLs:

/en/product/1/review/123
/ka/product/test/review/foo
/{any_string}/product/{any_string}/review/{any_string}

---

## Route Optional Parameters

You can make route parameters optional by appending a ? to the parameter name and providing a default value.

```php
Route::get('/product/{category?}', function (string $category = null) {
    return "Product for category = $category";
});
```

Matches the following URLs:

/product/
/product/electronics
/product/{any_string}

---

## Route Parameter Validation

You can constrain the format of route parameters using regular expressions.

```php
// Only allows numeric values for id
Route::get('/product/{id}', function (int $id) {
    return "Product ID = $id";
})->where('id', '[0-9]+');

// Multiple parameter constraints
Route::get('/product/{category}/{id}', function (string $category, int $id) {
    return "Category = $category, Product ID = $id";
})->where(['category' => '[a-z]+', 'id' => '[0-9]+']);
```

Examples of constraints:

[0-9]+: Only numeric values
[a-z]+: Only lowercase letters
[A-Za-z]+: Both uppercase and lowercase letters


