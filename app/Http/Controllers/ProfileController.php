<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil pesanan user dengan paginasi 10 data per halaman, urut terbaru
        $orders = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Hitung total spent untuk pesanan yang completed
        $total_spent = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->sum('total_amount');

        return view('profile.index', compact('user', 'orders', 'total_spent'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        // Update email jika berubah
        if ($request->email !== $user->email) {
            $user->email = $request->email;
        }

        // Jika user isi current_password, maka cek dan update password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect.']);
            }

            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
}
