<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;


class product extends Controller
{
    public function getProduct($name){

        $getProductResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_STORE_URL').'/admin/api/2021-07/products.json');

        $products = $getProductResponse->json()['products'];
        foreach ($products as $product) {
            if ($product['title'] == $name) {
                return $product;
            }
        }
        return 'product not found';
    }


    public function createProduct($name, $description, $price, $quantity)
    {
        //idealmente hacer la validación de si el producto existe por el ID, pero por requerimiento se hace por el nombre
        $getProductResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->get(env('SHOPIFY_STORE_URL').'/admin/api/2021-07/products.json');

        $products = $getProductResponse->json()['products'];
        foreach ($products as $product) {
            if ($product['title'] == $name) {
                return 'product already exist';
            }
        }

        $createProductResponse = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => env('SHOPIFY_ACCESS_TOKEN')
        ])->post(env('SHOPIFY_STORE_URL').'/admin/api/2021-07/products.json', [
            'product' => [
                'title' => $name,
                'body_html' => $description,
                'variants' => [
                    [
                        'price' => $price,
                        'inventory_management' => 'shopify',
                        'inventory_quantity' => $quantity
                    ]
                ]
            ]
        ]);
        return $createProductResponse->json();
    }
}
