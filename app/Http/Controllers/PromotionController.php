<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{

    public function index()
    {
        // Fetch promotions with associated products and their images
        $promotions = Promotion::with('product.images')->get();

        // Prepare data for view
        $promotionsData = $promotions->map(function ($promotion) {
            $product = $promotion->product;
            $firstImage = $product->images->first() ? asset('images/products/' . $product->images->first()->path) : asset('images/products/default.jpg');
            $oldPrice = $product->price;
            $newPrice = $promotion->new_price;
            $percentage = ($oldPrice == 0) ? 0 : (($oldPrice - $newPrice) / $oldPrice) * 100;

            return [
                'product_name' => $product->nom,
                'first_image' => $firstImage,
                'old_price' => $oldPrice,
                'new_price' => $newPrice,
                'percentage' => round($percentage, 2),
                'id' => $promotion->id

            ];
        });

        return view('admin.promotions', compact('promotionsData'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $promotionReq = $request->validate([
            'new_price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
        ]);

        // Extract data
        $newPrice = $promotionReq['new_price'];
        $productId = $promotionReq['product_id'];

        // Retrieve the product
        $product = Product::findOrFail($productId);

        // Check if the new price is less than the original product price
        if ($newPrice >= $product->price) {
            return redirect()->back()->withErrors(['new_price' => 'The new price must be less than the original price.']);
        }

        // Check if a promotion already exists for the given product
        $existingPromotion = Promotion::where('id_product', $productId)->first();

        if ($existingPromotion) {
            // If a promotion already exists, update it
            $existingPromotion->update([
                'new_price' => $newPrice,
            ]);
        } else {
            // If no promotion exists, create a new one
            Promotion::create([
                'new_price' => $newPrice,
                'id_product' => $productId,
            ]);
        }

        return redirect()->route('products')->with('success', 'Promotion saved successfully.');
    }




    public function edit($id)
    {
        $promotion = Promotion::findOrFail($id);
        $product = $promotion->product; // Assuming you want to allow the user to select a product to associate with this promotion
        return view('admin.editpromotion', compact('promotion', 'product'));
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update($request->all());
        return redirect()->route('admin.promotions')->with('success', 'Promotion updated successfully');
    }

    public function destroy($id)
    {
        $check = Promotion::findOrFail($id);
        // Delete the associated promotion if it exists
        if ($check) {
            $check->delete();
        }


        return redirect()->route('products')->with('success', 'Product and its promotion deleted successfully.');
    }
}
