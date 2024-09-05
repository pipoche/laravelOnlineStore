<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PackController extends Controller
{

    public function index()
    {
      
      $packs = Pack::all();

        return view('admin.packs', compact('packs'));
    }
  





    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric|min:0',
            'products' => 'required|array',
        ]);


        $packData = $request->only('name', 'description', 'price');

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/packs'), $imageName);
            $packData['image'] = $imageName;
        } else {
            $packData['image'] = 'default.jpg';
        }

        $pack = Pack::create($packData);

        $pack->products()->attach($request->products);

        return redirect()->route('packs')->with('success', 'Pack created successfully.');
    }

    public function create()
    {
        $products = Product::all(); // Get all products to add to the pack
        return view('admin.createpack', compact('products'));
    }

    public function show($id)
    {
        $pack = Pack::with('products.images')->findOrFail($id);

        return view('admin.showpack', compact('pack'));
    }

    public function edit($id)
    {
        $pack = Pack::findOrFail($id);
        return view('admin.editpack', compact('pack'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // For the main pack image
        ]);

        $pack = Pack::findOrFail($id);
        $pack->name = $request->input('name');
        $pack->description = $request->input('description');
        $pack->price = $request->input('price');

        // Handle main image update
        if ($request->hasFile('image')) {
            // New image uploaded
            $newImage = $request->file('image');
            $newImageName = time() . '_' . $newImage->getClientOriginalName();

            // Delete the old image if it exists and is different from the new one
            if ($pack->image && $pack->image !== $newImageName) {
                if (file_exists(public_path('images/packs/' . $pack->image))) {
                    unlink(public_path('images/packs/' . $pack->image));
                }
            }

            // Upload the new image
            $newImage->move(public_path('images/packs/'), $newImageName);

            // Save the new image name to the database
            $pack->image = $newImageName;
        }

        $pack->save();

        return redirect()->route('packs')->with('success', 'Pack updated successfully.');
    }


    public function destroy($id)
    {
        $pack = Pack::findOrFail($id);

        // Delete the image file if it exists
        if ($pack->image && file_exists(public_path('images/packs/' . $pack->image))) {
            unlink(public_path('images/packs/' . $pack->image));
        }

        // Delete the pack record
        $pack->delete();

        return redirect()->route('packs')->with('success', 'Pack deleted successfully.');
    }
}
