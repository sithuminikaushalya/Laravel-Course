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
9. [Route Parameter Regex](#route-parameter-regex)
10. [Named Routes](#named-routes)
11. [Name Routes with Parameters](#named-routes-with-parameters)
12. [Route Groups](#route-groups)
13. [View Registered Routes with Artisan](#view-registered-routes-with-artisan)

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
1. 

```php
Route::get('/product/{id}', function(string $id) {
    return "Works! $id";
}) ->whereNumber('id');
```
Matches the following URLs

- `/product/1`
- `/product/01234`
- `/product/56789`

Does not match

- `/product/test`
- `/product/123test`
- `/product/test123`

2.

```php
Route::get('/user/{username}', function(string $username) {
    
}) ->whereAlpha('username');
```

Matches the following URLs

- `/user/zura`
- `/user/thecodeholic`
- `/user/ZURA`

Does not match

- `/user/zura123`
- `/user/123ZURA`

3.

```php
Route::get('/user/{username}', function(string $username) {
    
}) ->whereAlphaNumeric('username');
```

Matches the following URLs

- `/user/zura123`
- `/user/123thecodeholic`
- `/user/ZURA123`

Does not match

- `/user/zura.123`
- `/user/123_ZURA`
- `/user/123-ZURA`

4.

```php
Route::get('{lang}/product/{id}', function(string $ulang, string $id) {
    
}) ->whereAlpha('lang'); // only uppercase and lowercase letters
   ->whereNumber('id')   // only digits
;
```

Matches the following URLs

- `/en/product/123`
- `/k/product/456`
- `/test/product/01234`

Does not match

- `/en/product/123abc`
- `/ka/product/abc456`
- `/en123/producct/01234`

5. 

```php
Route::get('{lang}/products', function(string $ulang) {
    
})->whereIn("lang",["en","ka","in"]);
```

Matches the following URLs

- `/en/products`
- `/ka/products`
- `/in/products`

Does not match

- `/de/products`
- `/es/products`
- `/test/products`

---

## Route Parameter Regex

1. User route with name validation (only lowercase letters)

```php
Route::get('/user/{name}', function(string $name) {
    return "User name: $name";
})->where('name', '[a-z]+');
```

2. Multi-condition route (language and product ID)

```php
Route::get("{lang}/product/{id}", function(string $lang, string $id) {
})->where(['lang' => '[a-z]{2}', 'id'=> '\d{4,}']);
```

3. Search route (matches any input)

```php
Route::get('/search/{search}', function(string $search) {
    return $search;
})->where('search','.+');
```

---

## Named Routes

```php
Route::get('/', function() {
    $aboutPageUrl = route('about');
    dd($aboutPageUrl);
    return view('welcome');
});

Route::view('/about', 'about');
```

---

## Name Routes with Parameters

1.

```php
Route::get('/{lang}/product/{id}', function (string $lang, string $id) {
    return "Product ID: $id in Language: $lang";
})->where(['id' => '\d+'])->name("product.view");

Route::get('/', function () {
    $productUrl = route('product.view', ['lang' => 'en', 'id' => 1]);
    dd($productUrl); // Outputs: "/en/product/1"

    return view('welcome');
});
```

2.

```php
Route::get('/', function() {
    return view('welcome');
});

Route::get('/user/profile', function(){})->name('profile');

Route::get('/current-user', function(){
    return to_route('profile');
});
```

---

## Route Groups

If we want to define routes with the same prefix, we can do this in the following way.

```php
Route::prefix('admin')->group(function () {
  Route::get('/users', function () {
    return '/admin/users';
  });
});
```

In the same way, we can define a prefix for the root name.

```php
Route::name('admin.')->group(function () {
  Route::get('/users', function () {
    return '/users'; // But the route name is "admin.users"
  })->name('users');
});
```

---

## Fallback Routes

When the route is not matched, Laravel will show a 404 error.
For this issue, we will call the fallback providing function, executed every time a route is not matched.

```php
Route::fallback(function() {
  return 'Falback';
});
```

---

## View Registered Routes with Artisan

```php
php artisan route:list

php artisan route:list -v

php artisan route:list --except-vendor

php artisan route:list --only-vendor

php artisan route:list --path=api
```

### `php artisan route:list`
📌 **Description:**  
Lists all registered routes in your Laravel application.  
Shows basic details like HTTP method, URI, associated controller, and route name.

💡 **Comment:**  
This is the most commonly used command for checking defined routes.  
If a route is missing or incorrectly named, this command helps verify it.

### `php artisan route:list -v`
📌 **Description:**  
The `-v` (verbose) flag provides more details about each route.  
It includes middleware, namespace, and other internal route details.

💡 **Comment:**  
Useful when debugging middleware-related issues.  
Helps check if a specific route is being protected by middleware (e.g., `auth`).

### `php artisan route:list --except-vendor`
📌 **Description:**  
Excludes vendor-provided routes (like those from Laravel packages).  
Shows only application-defined routes.

💡 **Comment:**  
Useful when you only want to focus on the routes you've created.  
Helps declutter the route list by removing package-generated routes.

### `php artisan route:list --only-vendor`
📌 **Description:**  
Displays only vendor-provided routes (routes from Laravel packages).  
Opposite of `--except-vendor`.

💡 **Comment:**  
Helpful for checking which routes are added by installed packages (like `passport`, `sanctum`, or `nova`).  
Can be used to debug package-related issues.

### `php artisan route:list --path=api`
📌 **Description:**  
Filters the route list to only show routes that include `"api"` in their path.

💡 **Comment:**  
Useful when working with API routes defined in `routes/api.php`.  
Helps focus on API-related issues without being distracted by web routes.


### `php artisan route:list -v --except-vendor --path=admin`
📌 **Description:**  
Combines multiple filters:  
- `-v`: Shows detailed information.  
- `--except-vendor`: Hides package routes.  
- `--path=admin`: Filters routes to only show those containing `"admin"` in the path.

💡 **Comment:**  
This is useful for debugging routes related to an admin panel.  
Helps check if the admin routes exist and are correctly defined.  
Excludes package routes, making it easier to focus on application-specific admin routes.


php artisan route:list -v --except-vendor --path=admin
```



