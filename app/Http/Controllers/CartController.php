<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    //
    public function index()
    {
        $cart = Cart::with('product')
            ->where('user_id', Auth::id())
            ->get();
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item->product->price * $item->quantity;
        }

        return view('cart.index', compact('cart', 'totalPrice'));
    }
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }
    public function remove($id)
    {
        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($cart) {
            $cart->delete();
            return redirect()->back()->with('success', 'Product removed from cart successfully.');
        }

        return redirect()->back()->with('error', 'Product not found in cart.');
    }
    public function update(Request $request)
{
    $quantities = $request->input('quantities', []);

    $userId = Auth::id();
    $totalPrice = 0;
    $itemSubtotal = 0;

    foreach ($quantities as $productId => $quantity) {
        $cart = Cart::where('user_id', $userId)
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            $cart->update(['quantity' => $quantity]);

            // Hitung subtotal untuk produk yang diupdate
            $itemSubtotal = $cart->quantity * $cart->product->price;
        }
    }

    // Hitung total harga seluruh cart user
    $totalPrice = Cart::where('user_id', $userId)
        ->get()
        ->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

    return response()->json([
        'itemSubtotal' => $itemSubtotal,
        'totalPrice' => $totalPrice,
    ]);
}


}
