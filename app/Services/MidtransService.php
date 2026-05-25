<?php

namespace App\Services;

class MidtransService
{
    public function createSnapToken($trx)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => 'TRX-' . $trx->id,
                'gross_amount' => $trx->total_price,
            ],
            'customer_details' => [
                'first_name' => 'User',
                'email' => 'user@gmail.com',
            ],
        ];

        return \Midtrans\Snap::getSnapToken($params);
    }
}