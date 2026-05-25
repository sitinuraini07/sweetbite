<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'total_price',
        'tax',
        'discount',
        'shipping_cost',
        'status',
        'admin_note',
        'is_note_read',
        'courier_id',
        'proof_image',
        'customer_confirmed_at',
        'refund_reason'
    ];

    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getEstimatedArrivalAttribute()
    {
        if ($this->status === 'pending') {
            return 'Akan diproses setelah pembayaran';
        }
        
        if ($this->status === 'confirmed') {
            // Est. preparation time: 30-45 minutes from order time
            $time = $this->created_at->addMinutes(45)->format('H:i');
            return "Est. siap pukul {$time} (30 - 45 mnt)";
        }
        
        if ($this->status === 'shipping') {
            // Est. shipping time: 15-25 minutes from status change
            $time = $this->updated_at->addMinutes(25)->format('H:i');
            return "Est. tiba pukul {$time} (15 - 25 mnt)";
        }
        
        if ($this->status === 'delivered' || $this->status === 'completed') {
            return 'Telah tiba di tujuan';
        }
        
        return 'Tidak tersedia';
    }
}
