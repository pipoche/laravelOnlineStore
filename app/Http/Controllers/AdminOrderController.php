<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function inbox()
    {
        // Fetch all orders
        $orders = Order::orderBy('created_at', 'desc')->get();

        return view('admin.inbox', compact('orders'));
    }


    public function showOrder($id)
    {
        $order = Order::with('orderDetails.product', 'orderDetails.pack')->findOrFail($id);

        // Mark the order as read
        if (!$order->notificationstatus) {
            $order->notificationstatus = true;
            $order->save();
        }

        return view('admin.showorder', compact('order'));
    }

    public function updateOrder(Request $request, $id){

        $order = Order::findOrFail($id);

        $orderStatus = $request->input('orderstatus');

        if($orderStatus){
            $order->orderstatus = $orderStatus;

            $order->save();
        }

        return redirect()->route('inbox')->with('success', 'Order Status Changed');
    }

}
