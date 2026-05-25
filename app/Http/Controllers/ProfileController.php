<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->get();
        
        // Count orders by status for the Shopee-like icons
        $orderCounts = [
            'pending' => Transaction::where('user_id', $user->id)->where('status', 'pending')->count(),
            'confirmed' => Transaction::where('user_id', $user->id)->where('status', 'confirmed')->count(),
            'shipping' => Transaction::where('user_id', $user->id)->where('status', 'shipping')->count(),
            'delivered' => Transaction::where('user_id', $user->id)->where('status', 'delivered')->count(),
        ];
            
        return view('profile.index', compact('user', 'addresses', 'orderCounts'));
    }

    public function edit()
    {
        $user = auth()->user();
        $addresses = Address::where('user_id', $user->id)->get();
        return view('profile.edit', compact('user', 'addresses'));
    }

    public function myOrders(Request $request)
    {
        $user = auth()->user();
        $status = $request->get('status', 'all');
        
        $query = Transaction::with(['details.product', 'courier'])
            ->where('user_id', $user->id);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->has('search')) {
            $query->where('id', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->latest()->get();

        return view('profile.orders', compact('user', 'transactions', 'status'));
    }

    public function trackOrder($id)
    {
        $transaction = Transaction::with(['courier', 'address', 'details.product'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);
            
        return view('profile.track', compact('transaction'));
    }

    public function confirmOrder($id)
    {
        $transaction = Transaction::where('user_id', auth()->id())
            ->where('status', 'delivered')
            ->findOrFail($id);

        $transaction->update([
            'status' => 'completed',
            'customer_confirmed_at' => now()
        ]);

        return back()->with('success', 'Hore! Pesanan telah selesai. Terima kasih sudah jajan di SweetBite! ✨');
    }

    public function refundOrder(Request $request, $id)
    {
        $request->validate([
            'refund_reason' => 'required|string|max:500',
        ]);

        $transaction = Transaction::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed', 'shipping', 'delivered'])
            ->findOrFail($id);

        $transaction->update([
            'status' => 'refunded',
            'refund_reason' => $request->refund_reason
        ]);

        return back()->with('success', 'Permintaan pengembalian dana telah diajukan. Kami akan segera menghubungi Anda.');
    }

    public function getCourierLocation($id)
    {
        $transaction = Transaction::with('courier')->findOrFail($id);
        
        if ($transaction->courier) {
            return response()->json([
                'lat' => $transaction->courier->current_lat,
                'lng' => $transaction->courier->current_lng,
                'status' => $transaction->status
            ]);
        }
        
        return response()->json(['error' => 'Courier not found'], 404);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'bio' => 'nullable|string|max:500',
            'gender' => 'nullable|string',
            'birthdate' => 'nullable|date',
            'phone_number' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'bio', 'gender', 'birthdate', 'phone_number']);

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles'), $filename);
            $data['profile_photo'] = 'uploads/profiles/' . $filename;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'alamat_lengkap' => 'required|string',
            'postal_code' => 'required|string',
            'phone_number' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Address::create([
            'user_id' => auth()->id(),
            'alamat_lengkap' => $request->alamat_lengkap,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return back()->with('success', 'Alamat berhasil ditambahkan');
    }

    public function updateAddress(Request $request, $id)
    {
        $address = Address::where('user_id', auth()->id())->findOrFail($id);
        
        $request->validate([
            'alamat_lengkap' => 'required|string',
            'postal_code' => 'required|string',
            'phone_number' => 'required|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $address->update($request->all());

        return back()->with('success', 'Alamat berhasil diperbarui');
    }
    public function markNotificationsAsRead()
    {
        Transaction::where('user_id', auth()->id())
            ->whereNotNull('admin_note')
            ->where('is_note_read', false)
            ->update(['is_note_read' => true]);

        return response()->json(['status' => 'success']);
    }
}
