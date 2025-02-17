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
