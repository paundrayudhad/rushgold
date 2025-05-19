<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        $cartItems = Cart::with(['product.category'])
            ->where('user_id', $user->id)
            ->get();

        $hasGoldProducts = $cartItems->contains(function ($item) {
            return $item->product->category->slug === 'gold';
        });

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total', 'hasGoldProducts'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->get();

        $hasGoldProducts = $cartItems->contains(function ($item) {
            $category = strtolower($item->product->category->name);
            return in_array($category, ['gold', 'coin']);
        });

        $request->validate([
            'payment_method' => 'required',
            'game_nickname' => $hasGoldProducts ? 'required' : 'nullable',
        ]);

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        DB::beginTransaction();

        try {
            $data = [
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => $user->id,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ];

            if ($request->filled('game_nickname')) {
                $data['game_nickname'] = $request->game_nickname;
            }

            $order = Order::create($data);

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Not enough stock for " . $item->product->name);
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', $user->id)->delete();

            DB::commit();

            session(['current_order' => $order->order_number]);


            return redirect()->route('payment.form', ['order' => $order->order_number]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order creation failed: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Order failed: ' . $e->getMessage()]);
        }
    }
    public function showPaymentForm($orderNumber)
    {
        $user = Auth::user();

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->with(['orderItems.product', 'user'])
            ->firstOrFail();

        return view('orders.payment', compact('order'));
    }

    public function uploadPaymentProof(Request $request, $orderNumber)
    {
        $request->validate([
            'payment_proof' => 'required|image|max:5120', // 5MB max
            'transaction_proof' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $path = $file->storeAs('payment_proofs', $orderNumber . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension(), 'public');

            $order->update([
                'payment_proof' => $path,
                'transaction_proof' => $request->transaction_proof,
                'payment_proof_date' => now(),
                'status' => 'processing',
            ]);

            session()->forget('current_order');
            return redirect()->route('profile')->with('success', 'Payment proof uploaded successfully.');
        }

        return back()->withErrors(['payment_proof' => 'Payment proof is required.']);
    }
    public function show($order)
    {

        $order = Order::with('user', 'orderItems.product')
            ->where('order_number', $order)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            return redirect()->route('profile');
        }

        return view('orders.details', compact('order'));
    }
}
