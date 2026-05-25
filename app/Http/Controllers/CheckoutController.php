<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Address;
use App\Models\Discount;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Check Courier Availability
        $totalCouriers = \App\Models\User::where('role', 'courier')->count();
        $busyCouriers = \App\Models\Transaction::where('status', 'shipping')->distinct('courier_id')->count();
        $couriersBusy = ($totalCouriers > 0 && $busyCouriers >= $totalCouriers);

        // Handle "Buy Now" (Direct Checkout)
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->product_id);
            $qty = $request->get('qty', 1);
            
            // Create a fake cart structure for the view
            $cart = (object) [
                'items' => collect([
                    (object) [
                        'product_id' => $product->id,
                        'product' => $product,
                        'quantity' => $qty
                    ]
                ])
            ];
            
            // Calculate Summary for Display
            $subtotal = $product->price * $qty;
            $shipping_cost = 10000;
            $tax = $subtotal * 0.11;
            
            // Dynamic Discount
            $activeDiscount = Discount::getCurrentDiscount();
            $discountRate = $activeDiscount ? $activeDiscount->percentage / 100 : 0;
            $discount = $subtotal * $discountRate;
            
            $total = $subtotal + $shipping_cost + $tax - $discount;
            
            return view('checkout.index', compact('cart', 'subtotal', 'shipping_cost', 'tax', 'discount', 'total', 'activeDiscount'))
                ->with(['buy_now' => true, 'couriers_busy' => $couriersBusy]);
        }

        // Handle Normal Cart Checkout
        $cart = Cart::with('items.product')
            ->where('user_id', auth()->id())
            ->first();

        if (!$cart) {
            return redirect('/cart')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Calculate Summary for Display
        $subtotal = 0;
        foreach ($cart->items as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $shipping_cost = 10000; // Flat rate Rp 10.000
        $tax = $subtotal * 0.11; // 11% Tax
        
        // Dynamic Discount
        $activeDiscount = Discount::getCurrentDiscount();
        $discountRate = $activeDiscount ? $activeDiscount->percentage / 100 : 0;
        $discount = $subtotal * $discountRate;
        
        $total = $subtotal + $shipping_cost + $tax - $discount;

        return view('checkout.index', compact('cart', 'subtotal', 'shipping_cost', 'tax', 'discount', 'total', 'activeDiscount'))
            ->with(['buy_now' => false, 'couriers_busy' => $couriersBusy]);
    }

    public function process(Request $request)
    {
        // Simpan alamat baru dari form checkout
        $address = Address::create([
            'user_id' => auth()->id(),
            'alamat_lengkap' => $request->address,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone,
            'kota' => $request->city ?? '-',
            'province' => $request->province,
            'regency' => $request->regency,
            'district' => $request->district,
            'village' => $request->village,
        ]);

        $total = 0;
        $items = [];

        if ($request->has('product_id')) {
            // "Buy Now" processing
            $product = Product::findOrFail($request->product_id);
            $qty = $request->get('qty', 1);
            $total = $product->price * $qty;
            $items[] = [
                'product_id' => $product->id,
                'quantity' => $qty,
                'price' => $product->price
            ];
        } else {
            // Normal Cart processing
            $cart = Cart::with('items.product')
                ->where('user_id', auth()->id())
                ->first();

            if (!$cart || $cart->items->isEmpty()) {
                return redirect('/cart')->with('error', 'Gagal memproses, keranjang kosong.');
            }

            foreach ($cart->items as $item) {
                $total += $item->product->price * $item->quantity;
                $items[] = [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ];
            }
            
            // Clear cart if it's a normal checkout
            $cart->items()->delete();
        }

        // Calculations
        $shipping_cost = 10000;
        $tax = $total * 0.11;
        
        // Dynamic Discount
        $activeDiscount = Discount::getCurrentDiscount();
        $discountRate = $activeDiscount ? $activeDiscount->percentage / 100 : 0;
        $discount = $total * $discountRate;
        
        $grand_total = $total + $shipping_cost + $tax - $discount;

        // Create Transaction
        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'address_id' => $address->id,
            'total_price' => $grand_total,
            'tax' => $tax,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
            'status' => 'PENDING'
        ]);

        // Create Transaction Details
        foreach ($items as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
            
            // Deduct Stock
            $product = Product::find($item['product_id']);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        return redirect('/pay/'.$transaction->id)->with('success', 'Pesanan berhasil dibuat!');
    }
}