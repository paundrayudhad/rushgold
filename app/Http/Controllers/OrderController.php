<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;


class OrderController extends Controller
{
    //
    public function index()
    {
        // Logic to display orders
        return view('orders.index');
    }
    public function invoice(Order $order)
    {
        // Logic to display invoice for a specific order
        return view('orders.invoice', compact('order'));
    }
}
