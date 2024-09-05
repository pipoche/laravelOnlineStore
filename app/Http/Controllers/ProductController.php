<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(9);

        return view('admin.products', compact('categories', 'products'));
    }

    public function show($id)
    {
        $product = Product::with('images', 'category')->findOrFail($id);

        return view('admin.showproduct', compact('product'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_category' => 'required|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'product_type' => 'required|in:B&N,ET',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:51200 ',
            'price' => 'required|numeric',
        ]);

        try {
            // Prepare the product data
            $productData = [
                'nom' => $validatedData['nom'],
                'description' => $validatedData['description'],
                'id_category' => $validatedData['id_category'],
                'producttype' => $validatedData['product_type'],
                'price' => $validatedData['price'],
            ];

            // Create the product
            $product = Product::create($productData);

            // Handle multiple image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $destinationPath = 'images/products/';
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path($destinationPath), $imageName);
                    // Save image path to the database
                    Image::create([
                        'path' =>  $imageName,
                        'id_product' => $product->id,
                    ]);
                }
            }

            // Insert initial stock quantity into the product_stock table
            ProductStock::create([
                'stockquantity' => $validatedData['stock_quantity'],
                'product_id' => $product->id,
            ]);

            // Redirect back with success message
            return redirect()->route('products')->with('success', 'Product created successfully with initial stock!');
        } catch (\Exception $e) {
            // If there's an error, redirect back with input and errors
            return redirect()->route('products')->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        // Find the product by ID
        $product = Product::findOrFail($id);

        // Delete associated images
        foreach ($product->images as $image) {
            // Delete the image file from storage
            if (Storage::exists('public/images/products/' . $image->path)) {
                Storage::delete('public/images/products/' . $image->path);
            }

            // Delete the image record from the database
            $image->delete();
        }

        // Delete the product's stock (if exists)
        if ($product->stock) {
            $product->stock->delete();
        }

        // Finally, delete the product itself
        $product->delete();

        // Optionally, return a response or redirect
        return redirect()->route('products')->with('success', 'Product deleted successfully.');
    }


    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.editproduct', compact('product', 'categories'));
    }




    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'id_category' => 'required|integer|exists:categories,id',
            'stock_quantity' => 'required|integer|min:0',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update product details
        $product->update([
            'nom' => $request->input('nom'),
            'description' => $request->input('description'),
            'id_category' => $request->input('id_category'),
        ]);

        // Update stock quantity if a stock relationship exists
        if ($product->stock) {
            $product->stock->update(['stockquantity' => $request->input('stock_quantity')]);
        } else {
            // Create stock if it doesn't exist
            $product->stock()->create(['stockquantity' => $request->input('stock_quantity')]);
        }

        // Handle image deletions
        if ($request->filled('images_to_delete')) {
            $imagesToDelete = explode(',', $request->input('images_to_delete'));
            foreach ($imagesToDelete as $imageId) {
                $image = Image::findOrFail($imageId);
                // Optionally, delete the image file from storage
                if (file_exists(public_path('images/products/' . $image->path))) {
                    unlink(public_path('images/products/' . $image->path));
                }
                $image->delete();
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $destinationPath = 'images/products/';
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path($destinationPath), $imageName);
                // Save image path to the database
                Image::create([
                    'path' =>  $imageName,
                    'id_product' => $product->id,
                ]);
            }
        }

        return redirect()->route('products')->with('success', 'Product ',  $product->id, ' updated successfully!');
    }


    
}
