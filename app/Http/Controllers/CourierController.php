<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class CourierController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product', 'address'])
            ->where('courier_id', auth()->id())
            ->where('status', 'shipping');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->get();

        // Daily Statistics
        $deliveredOrdersToday = Transaction::with(['user', 'details.product', 'address'])
            ->where('courier_id', auth()->id())
            ->whereIn('status', ['delivered', 'completed'])
            ->whereDate('updated_at', today())
            ->get();

        $deliveredToday = $deliveredOrdersToday->count();

        return view('courier.orders', compact('orders', 'deliveredToday', 'deliveredOrdersToday'));
    }

    public function done(Request $request, $id)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $order = Transaction::with(['details.product', 'user', 'address'])->findOrFail($id);

        if ($request->hasFile('proof_image')) {
            $imagePath = $request->file('proof_image')->store('proofs', 'public');
            
            $order->update([
                'status' => 'delivered',
                'proof_image' => $imagePath
            ]);

            try {
                if ($order->user && $order->user->email) {
                    Mail::to($order->user->email)->send(new OrderStatusMail(
                        $order,
                        'Pesanan Telah Tiba! 🎉',
                        'Kue/dessert manis Anda telah berhasil diantarkan oleh kurir kami ke alamat Anda. Silakan dinikmati!'
                    ));
                }
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email pesanan selesai ke ' . ($order->user->email ?? 'unknown') . ': ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Pesanan berhasil dikonfirmasi sampai tujuan! ✨');
    }

    public function updateLocation(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        auth()->user()->update([
            'current_lat' => $request->lat,
            'current_lng' => $request->lng
        ]);

        return response()->json(['status' => 'success']);
    }
}