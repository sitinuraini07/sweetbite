<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $image = null;

        if ($request->file('image')) {
            $image = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $image
        ]);

        return redirect('/admin/products')->with('success', 'Produk berhasil ditambah');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->file('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->update($request->all());

        return redirect('/admin/products')->with('success', 'Produk diupdate');
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();

        return back()->with('success', 'Produk dihapus');
    }
}