<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
        // Set Midtrans Configuration
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        Config::$is3ds = env('MIDTRANS_IS_3DS', true);
    }

    public function pay($id)
    {
        $transaction = Transaction::with(['details.product', 'user'])->findOrFail($id);

        $params = [
            'transaction_details' => [
                'order_id' => 'SB-' . $transaction->id . '-' . time(),
                'gross_amount' => (int) $transaction->total_price,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
            ],
            'item_details' => array_merge(
                $transaction->details->map(function($detail) {
                    return [
                        'id' => 'PROD-' . $detail->product_id,
                        'price' => (int) $detail->price,
                        'quantity' => (int) $detail->quantity,
                        'name' => $detail->product->name,
                    ];
                })->toArray(),
                [
                    [
                        'id' => 'SHIP-COST',
                        'price' => (int) $transaction->shipping_cost,
                        'quantity' => 1,
                        'name' => 'Biaya Pengiriman (Ongkir)',
                    ],
                    [
                        'id' => 'TAX',
                        'price' => (int) $transaction->tax,
                        'quantity' => 1,
                        'name' => 'Pajak (PPN 11%)',
                    ],
                    [
                        'id' => 'DISC',
                        'price' => -(int) $transaction->discount,
                        'quantity' => 1,
                        'name' => 'Diskon SweetBite',
                    ],
                ]
            ),
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('payment.index', compact('transaction', 'snapToken'));
    }

    public function success($id)
    {
        $transaction = Transaction::with(['details.product', 'user', 'address'])->findOrFail($id);
        
        // Only decrease stock if the status hasn't been updated to SUCCESS yet
        if ($transaction->status !== 'SUCCESS') {
            foreach ($transaction->details as $detail) {
                $product = $detail->product;
                if ($product) {
                    $product->decrement('stock', $detail->quantity);
                }
            }
            $transaction->update(['status' => 'SUCCESS']);

            // Send Email Notification
            try {
                if ($transaction->user && $transaction->user->email) {
                    \Illuminate\Support\Facades\Mail::to($transaction->user->email)
                        ->send(new \App\Mail\OrderStatusMail(
                            $transaction,
                            'Pembayaran Berhasil! 🍰',
                            'Terima kasih atas pesanan Anda. Pembayaran Anda telah kami terima dan pesanan manis Anda sedang kami persiapkan.'
                        ));
                }
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim email pembayaran sukses ke ' . ($transaction->user->email ?? 'unknown') . ': ' . $e->getMessage());
            }
        }
        
        return redirect('/profile')->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
    }
}