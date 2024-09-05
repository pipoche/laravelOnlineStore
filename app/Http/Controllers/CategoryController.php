<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Promotion;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $categories = Category::where('nom', 'like', "%{$search}%")
            ->paginate(8); // Adjust the number of items per page as needed

        return view('admin.categories', compact('categories'));
    }

    public function search(Request $request)
    {
        $search = $request->input('search', '');
        $categories = Category::where('nom', 'like', "%{$search}%")
            ->paginate(9); // Adjust the number of items per page as needed

        return view('admin.categorieslist', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);



        $input = $request->all();

        if ($picture = $request->file('picture')) {
            $destinationPath = 'images/categories/';
            $profileImage = date('YmdHis') . "." . $picture->getClientOriginalExtension();
            $picture->move($destinationPath, $profileImage);
            $input['picture'] = "$profileImage";
        }

        Category::create($input);


        return redirect()->route('categories')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.editcategorie', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();

        if ($picture = $request->file('picture')) {
            $destinationPath = 'images/categories/';
            $profileImage = date('YmdHis') . "." . $picture->getClientOriginalExtension();
            $picture->move($destinationPath, $profileImage);
            $input['picture'] = "$profileImage";
        } else {
            $input['picture'] = $category->picture; // Keep the old image if no new image is uploaded
        }

        $category->update($input);

        return redirect()->route('categories')->with('success', 'Category updated successfully.');
    }


    /*public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

   

    */

    public function destroy($categoryId)
    {
        // Retrieve the category with its related products, images, promotions, stock, and packs
        $category = Category::with(['products.images', 'products.promotions', 'products.stock', 'products.packs'])
            ->findOrFail($categoryId);

        foreach ($category->products as $product) {
            // Delete associated images
            foreach ($product->images as $image) {
                if (Storage::exists('public/images/products/' . $image->path)) {
                    Storage::delete('public/images/products/' . $image->path);
                }
                $image->delete();
            }

            // Delete associated promotion
            if ($product->promotions) {
                $product->promotions->delete();
            }

            // Delete associated stock
            if ($product->stock) {
                $product->stock->delete();
            }

            // Remove product from associated packs
            $product->packs()->detach();

            // Delete the product itself
            $product->delete();
        }

        // Delete the category
        $category->delete();

        return redirect()->route('categories')->with('success', 'Category and its associated products have been deleted successfully.');
    }
}
