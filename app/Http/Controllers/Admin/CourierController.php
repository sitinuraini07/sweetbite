<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CourierController extends Controller
{
    public function index()
    {
        $couriers = User::where('role', 'courier')->latest()->get();
        return view('admin.couriers.index', compact('couriers'));
    }

    public function create()
    {
        return view('admin.couriers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'courier',
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ]);

        return redirect('/admin/couriers')->with('success', 'Kurir berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $courier = User::findOrFail($id);
        return view('admin.couriers.edit', compact('courier'));
    }

    public function update(Request $request, $id)
    {
        $courier = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $courier->name = $request->name;
        $courier->email = $request->email;
        $courier->phone_number = $request->phone_number;
        $courier->address = $request->address;

        if ($request->password) {
            $courier->password = Hash::make($request->password);
        }

        $courier->save();

        return redirect('/admin/couriers')->with('success', 'Data kurir berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $courier = User::findOrFail($id);
        $courier->delete();

        return redirect('/admin/couriers')->with('success', 'Kurir berhasil dihapus!');
    }
}
