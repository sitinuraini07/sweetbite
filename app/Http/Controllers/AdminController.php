<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $paidStatuses = ['SUCCESS', 'confirmed', 'shipping', 'delivered'];
        $transactions = Transaction::with('user')->latest()->limit(5)->get();
        $products = Product::count();
        $total_revenue = Transaction::whereIn('status', $paidStatuses)->sum('total_price');
        $total_users = User::where('role', 'customer')->count();
        $pending_orders = Transaction::where('status', 'pending')->count();
        
        // Data for chart (last 7 days revenue)
        $revenue_data = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $total = Transaction::whereIn('status', $paidStatuses)
                ->whereDate('created_at', $date)
                ->sum('total_price');
                
            $revenue_data->push([
                'date' => now()->subDays($i)->format('d M'),
                'total' => $total
            ]);
        }
        
        $revenue_data = $revenue_data; // It's already a collection of arrays

        return view('admin.dashboard', compact(
            'transactions', 
            'products', 
            'total_revenue', 
            'total_users', 
            'pending_orders',
            'revenue_data'
        ));
    }
}