<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
     // Add product to cart
     public function addToCart(Request $request)
     {
         $productId = $request->input('product_id');
         $productName = $request->input('product_name');
         $productPrice = $request->input('product_price');
 
         $cart = session()->get('cart', []);
 
         $cart[$productId] = [
             'name' => $productName,
             'price' => $productPrice,
             'quantity' => isset($cart[$productId]) ? $cart[$productId]['quantity'] + 1 : 1,
         ];
 
         session(['cart' => $cart]);
 
         return response()->json(['success' => true, 'cart' => $cart]);
     }
 
     // Remove product from cart
     public function removeFromCart(Request $request)
     {
         $productId = $request->input('product_id');
 
         $cart = session()->get('cart', []);
 
         if (isset($cart[$productId])) {
             unset($cart[$productId]);
             session(['cart' => $cart]);
         }
 
         return response()->json(['success' => true, 'cart' => $cart]);
     }
 
     // Clear the entire cart
     public function clearCart()
     {
         session()->forget('cart');
         return response()->json(['success' => true]);
     }
}
