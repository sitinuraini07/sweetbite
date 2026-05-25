<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        return view('cart.index', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        
        if ($product->stock <= 0) {
            if ($request->ajax()) {
                return response()->json(['status' => 'error', 'message' => 'Maaf, stok produk ini sedang habis!'], 400);
            }
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis!');
        }

        $cart = Cart::firstOrCreate([
            'user_id' => auth()->id()
        ]);

        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $id)
            ->first();

        $totalItems = CartItem::where('cart_id', $cart->id)->sum('quantity');

        if ($item) {
            if ($item->quantity + 1 > $product->stock) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => 'Stok tidak mencukupi!'], 400);
                }
                return redirect()->back()->with('error', 'Stok tidak mencukupi! Hanya tersedia ' . $product->stock . ' pcs.');
            }
            if ($totalItems + 1 > 100) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => 'Keranjang penuh!'], 400);
                }
                return redirect()->back()->with('error', 'Keranjang maksimal 100 barang!');
            }
            $item->update(['quantity' => $item->quantity + 1]);
        } else {
            if ($totalItems + 1 > 100) {
                if ($request->ajax()) {
                    return response()->json(['status' => 'error', 'message' => 'Keranjang penuh!'], 400);
                }
                return redirect()->back()->with('error', 'Keranjang maksimal 100 barang!');
            }
            CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $id,
                'quantity' => 1
            ]);
        }

        $newTotalCount = CartItem::where('cart_id', $cart->id)->sum('quantity');

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $newTotalCount
            ]);
        }

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function buyNow($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Maaf, stok produk ini sedang habis!');
        }
        
        return redirect('/checkout?product_id=' . $id . '&qty=1');
    }

    public function remove($id)
    {
        CartItem::findOrFail($id)->delete();
        return redirect('/cart')->with('success', 'Item berhasil dihapus!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $item = CartItem::with('product')->findOrFail($id);
        
        if ($request->quantity > $item->product->stock) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi! Hanya tersedia ' . $item->product->stock . ' pcs.');
        }

        $otherItemsQuantity = CartItem::where('cart_id', $item->cart_id)
            ->where('id', '!=', $id)
            ->sum('quantity');

        if ($otherItemsQuantity + $request->quantity > 100) {
            return redirect()->back()->with('error', 'Keranjang maksimal 100 barang!');
        }

        $item->update(['quantity' => $request->quantity]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success', 'message' => 'Keranjang diperbarui']);
        }

        return redirect('/cart')->with('success', 'Keranjang berhasil diperbarui!');
    }

    public function updateQty(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);
        $item = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return response()->json(['status' => 'success']);
    }
}