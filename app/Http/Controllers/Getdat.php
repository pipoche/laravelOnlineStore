<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Pack;
use App\Models\Product;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Getdat extends Controller
{
    public function index()
    {

         // Count orders by status
         $pendingOrders = Order::where('orderstatus', 'pending')->count();
         $deliveringOrders = Order::where('orderstatus', 'delivering')->count();
         $cancelledOrders = Order::where('orderstatus', 'cancelled')->count();
         $successOrders = Order::where('orderstatus', 'completed')->count();
 
         // Calculate earnings for the current and previous month
         $currentMonthEarnings = Order::whereMonth('created_at', Carbon::now()->month)
                                      ->sum('total_price');
         $previousMonthEarnings = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
                                       ->sum('total_price');
         // Count orders for the current and previous month
         $currentMonthOrders = Order::whereMonth('created_at', Carbon::now()->month)
                                    ->count();
         $previousMonthOrders = Order::whereMonth('created_at', Carbon::now()->subMonth()->month)
                                     ->count();

        $categoriesCount = Category::count(); // Total categories
        $productsCount = Product::count(); // Total products
        $packsCount = Pack::count(); // Total packs
        $promotionsCount = Promotion::count(); // Total promotions

        $totalOrders = $pendingOrders + $deliveringOrders + $cancelledOrders + $successOrders;



        return view('dashboard', [
            'categoriesCount' => $categoriesCount,
            'productsCount' => $productsCount,
            'packsCount' => $packsCount,
            'promotionsCount' => $promotionsCount,
            'pendingOrders' => $pendingOrders,
             'deliveringOrders' => $deliveringOrders,
             'cancelledOrders' => $cancelledOrders,
             'successOrders' => $successOrders,
             'currentMonthEarnings' => $currentMonthEarnings,
             'previousMonthEarnings' => $previousMonthEarnings,
             'currentMonthOrders' => $currentMonthOrders,
             'previousMonthOrders' => $previousMonthOrders,
             'totalOrders' => $totalOrders,
        ]);
    }


    public function  homepage()
    {
        $packs = Pack::with('products')->orderby('created_at', 'desc')->limit(6)->get();

        $products = Product::where('producttype', 'ET')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        $books = Product::where('producttype', 'B&N')

            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();


        return view('clients.index', compact('products', 'books', 'packs'));
    }

    public function educationaltools()
    {
        $products = Product::where('producttype', 'ET')
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        $categoriestools = Category::whereHas('products', function ($query) {
            $query->where('producttype', 'ET');
        })->get();



        return view('clients.educationaltools', compact('products','categoriestools'));
    }

    public function booknovels()
    {

        $books = Product::where('producttype', 'B&N')

            ->orderBy('created_at', 'desc')
            ->paginate(6);

        $categoriesbooks = Category::whereHas('products', function ($query) {
            $query->where('producttype', 'B&N');
        })->get();


        return view('clients.bandn', compact('books', 'categoriesbooks'));
    }

    public function lespacks()
    {

        $packs = Pack::with('products')->orderby('created_at', 'desc')->get();

        return view('clients.promotions', compact('packs'));
    }




    public function sendpannier(Request $request)
    {
        // Get the comma-separated string from the request
        $ids = explode(',', $request->input('product_ids', ''));

        // Separate product IDs and pack IDs
        $productIds = array_filter($ids, function ($id) {
            return !empty($id) && !str_contains($id, 'pack_'); // Filter out empty values and pack IDs
        });

        $packIds = array_filter($ids, function ($id) {
            return str_contains($id, 'pack_'); // Identify pack IDs

        });



        // Remove 'pack_' prefix from pack IDs for querying
        $cleanPackIds = array_map(function ($id) {
            return str_replace('pack_', '', $id);
        }, $packIds);

        // Retrieve products and packs from the database
        $products = Product::whereIn('id', $productIds)->get();
        $packs = Pack::whereIn('id', $cleanPackIds)->get();



        // Return the view with the product and pack details
        return view('clients.pannier', compact('products', 'packs'));
    }


    public function removeFromCart($id)
    {
        // Retrieve the cart from session storage
        $cart = session()->get('cart', []);

        // Remove the product from the cart using the provided ID
        if (($key = array_search($id, $cart)) !== false) {
            unset($cart[$key]);
        }

        // Update the session with the new cart
        session()->put('cart', array_values($cart));

        // Redirect back to the cart page
        return redirect()->route('sendpannier');
    }





    public function voirproduct($id)
    {

        $product = Product::with('images', 'category')->findOrFail($id);

        return view('clients.explore', compact('product'));
    }

    public function showpack($id)
    {
        $pack = Pack::with('products.images')->findOrFail($id);

        return view('clients.voirpack', compact('pack'));
    }
}
