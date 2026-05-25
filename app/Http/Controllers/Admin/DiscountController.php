<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.discounts.index', compact('discounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'percentage' => 'required|numeric|min:0|max:100',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'percentage' => $request->percentage,
            'active_days' => $request->active_days ? implode(',', $request->active_days) : null,
            'active_months' => $request->active_months ? implode(',', $request->active_months) : null,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('banners', 'public');
            $data['banner_image'] = $path;
        }

        Discount::create($data);

        return back()->with('success', 'Diskon berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $discount = Discount::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'percentage' => $request->percentage,
            'active_days' => $request->active_days ? implode(',', $request->active_days) : null,
            'active_months' => $request->active_months ? implode(',', $request->active_months) : null,
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('banner_image')) {
            $path = $request->file('banner_image')->store('banners', 'public');
            $data['banner_image'] = $path;
        }

        $discount->update($data);

        return back()->with('success', 'Diskon berhasil diperbarui');
    }

    public function destroy($id)
    {
        Discount::findOrFail($id)->delete();
        return back()->with('success', 'Diskon berhasil dihapus');
    }
}
