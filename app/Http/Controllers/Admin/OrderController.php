<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\OrderStatusMail;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($qu) use ($search) {
                      $qu->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $orders = $query->latest()->paginate(10);
        $couriers = User::where('role', 'courier')->get();

        return view('admin.orders.index', compact('orders', 'couriers'));
    }

    public function confirm($id)
    {
        $order = Transaction::with(['details.product', 'user', 'address'])->findOrFail($id);

        $order->update([
            'status' => 'confirmed'
        ]);

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusMail(
                    $order,
                    'Pesanan Dikonfirmasi! 👍',
                    'Kabar baik! Pesanan Anda telah dikonfirmasi oleh admin SweetBite dan sekarang sedang kami persiapkan di dapur.'
                ));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email konfirmasi pesanan ke ' . ($order->user->email ?? 'unknown') . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Order dikonfirmasi');
    }

    public function assignCourier(Request $request, $id)
    {
        $order = Transaction::with(['details.product', 'user', 'address'])->findOrFail($id);

        $order->update([
            'courier_id' => $request->courier_id,
            'status' => 'shipping'
        ]);

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusMail(
                    $order,
                    'Pesanan Sedang Dikirim! 🚚',
                    'Pesanan manis Anda telah diserahkan kepada kurir kami dan sedang dalam perjalanan menuju ke alamat Anda.'
                ));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email pengiriman pesanan ke ' . ($order->user->email ?? 'unknown') . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Kurir ditugaskan');
    }

    public function notify(Request $request, $id)
    {
        $order = Transaction::with(['details.product', 'user', 'address'])->findOrFail($id);
        $order->update([
            'admin_note' => $request->note,
            'is_note_read' => false
        ]);

        try {
            if ($order->user && $order->user->email) {
                Mail::to($order->user->email)->send(new OrderStatusMail(
                    $order,
                    'Catatan Baru dari SweetBite ✉️',
                    'Admin SweetBite baru saja mengirimkan catatan terkait pesanan Anda.',
                    $request->note
                ));
            }
        } catch (\Exception $e) {
            \Log::error('Gagal mengirim email catatan admin ke ' . ($order->user->email ?? 'unknown') . ': ' . $e->getMessage());
        }

        return back()->with('success', 'Notifikasi terkirim ke pelanggan');
    }
}