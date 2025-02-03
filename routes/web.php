<?php

use App\Http\Controllers\product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/product/create/', function () {
    $name = request('name');
    $description = request('description');
    $price = request('price');
    $quantity = request('quantity');
    return app('App\Http\Controllers\product')->createProduct($name, $description, $price, $quantity);

});

Route::get('/product/get', function () {
    $name = request('name');
    return app('App\Http\Controllers\product')->getProduct($name);

});
