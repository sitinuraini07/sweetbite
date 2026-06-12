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

        // Auto-geocode null coordinates for active orders
        foreach ($orders as $order) {
            $address = $order->address;
            if ($address && (is_null($address->latitude) || is_null($address->longitude))) {
                $queryStr = urlencode($address->alamat_lengkap . ', ' . ($address->kota ?? 'Depok') . ', Jawa Barat, Indonesia');
                $url = "https://nominatim.openstreetmap.org/search?format=json&q={$queryStr}&limit=1";
                
                $opts = [
                    'http' => [
                        'method' => "GET",
                        'header' => "User-Agent: SweetBiteApp/1.0\r\n",
                        'timeout' => 3.0
                    ]
                ];
                $context = stream_context_create($opts);
                try {
                    $response = @file_get_contents($url, false, $context);
                    if ($response) {
                        $data = json_decode($response, true);
                        if (!empty($data) && isset($data[0]['lat']) && isset($data[0]['lon'])) {
                            $address->update([
                                'latitude' => $data[0]['lat'],
                                'longitude' => $data[0]['lon']
                            ]);
                        }
                    }
                } catch (\Exception $e) {
                    // Ignore geocoding failures
                }
            }
        }

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