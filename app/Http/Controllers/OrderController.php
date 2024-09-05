<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Pack;
use App\Models\Product;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class OrderController extends Controller
{
    public function checkoutform()
    {
        return view('clients.checkoutinformations');
    }

    public function handleInformationForm(Request $request)
    {
        // Validate the incoming request data

        $orderDetails = json_decode($request->orderdetails, true);



        session([
            'orderdetails' => $orderDetails,
            'customer_info' => [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address
            ]
        ]);

        return redirect()->route('order.review');
    }

    public function showReviewPage()
    {
        // Retrieve order details and customer information from the session
        $orderDetails = session('orderdetails');
        $customerInfo = session('customer_info');

        // Retrieve the product details
        $produits = [];
        $packs = [];


        foreach ($orderDetails['items'] as $item) {
            if ($item['type'] === 'product') {
                $produits[] = Product::find($item['id']);
            } elseif ($item['type'] === 'pack') {
                $packs[] = Pack::find($item['id']);
            }
        }

        return view('clients.orderreview', compact('produits', 'customerInfo', 'orderDetails', 'packs'));
    }


    public function cancelorder(Request $request)
    {
        $request->session()->forget('orderdetails');
        $request->session()->forget('customer_info');
        $request->session()->forget('cart');

        return redirect()->route('homepage');
    }

    public function submitOrder(Request $request)
    {
        $orderDetails = session('orderdetails');
        $clientInfo = session('customer_info');

        // Save the order to the database
        $order = Order::create([
            'customer_name' => $clientInfo['name'],
            'customer_email' => $clientInfo['email'],
            'customer_phone' => $clientInfo['phone'],
            'customer_address' => $clientInfo['address'],
            'total_price' => $orderDetails['orderTotal'],
            'notificationstatus' => false,
            'orderstatus' => 'pending'
        ]);

        // Iterate through the items in the order details
        foreach ($orderDetails['items'] as $item) {
            if ($item['type'] === 'product') {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'pack_id' => null,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            } elseif ($item['type'] === 'pack') {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => null,
                    'pack_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        // Clear the session
        session()->forget('orderdetails');
        session()->forget('customer_info');
        session()->forget('cart');

        return redirect()->route('homepage')->with('success', 'Your order was placed successfully. We will contact you soon.');
    }

    public function adminindex() {
        $orders = Order::with('orderDetails.product', 'orderDetails.pack')->get();
        
        return view('admin.orders', compact('orders'));
        
    }

   
}
