<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Traits\ProductAnalyticTrait;
use App\Traits\StripePaymentTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use StripePaymentTrait, ProductAnalyticTrait;

    public function show(Order $order)
    {
        try 
        {
            $order = Order::with('products')->where('user_id', auth()->id())->where('order_code', $order->order_code)->firstOrFail();
            return view('orders.show', compact('order'));
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->back()->with('error', 'Invalid URL');
        }
    }

    /** 
    * client-side AJAX request send JSON payload in the Request body
    * retrieve the $request using $request->json()
    */
    public function store(Request $request)
    {
        $order = $this->processOrder($request);

        return response()->json([
            'message' => 'Order created successfully',
            'order_code' => $order->order_code,
        ]);
    }

    public function success(Request $request)
    {
        try 
        {
            $order = Order::where('order_code', $request->input('order'))->firstOrFail();
            return view('orders.success', compact(['order']));
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->route('home');
        }
    }

    /**
     * Process the order based on the payment method
     * 
     * @param string $paymentMethod
     * @return Order
     */
    protected function processOrder(Request $request) 
    {
        $paymentMethod = $request->json('form_data.payment_method');

        $order = new Order();
        $order->order_code = 'c' . Carbon::now()->format('yds') . strtolower(Str::random('3'));
        $order->user_id = auth()->id();
        $order->total_price = $request->json('form_data.total_amount');
        $order->description = 'Payment test description';
        
        if($paymentMethod == 'cash')
        {
            $order->payment_type = $paymentMethod;
            $this->cancelPayment($request->json('payment_intent_id'));
        }
        if($paymentMethod == 'card')
        {
            $order->payment_intent_id = $request->json('payment_intent_id');
            $order->payment_type = $paymentMethod;
        }

        $order->save();

        $productIdArray = explode(",", $request->json('form_data.products'));
        $quantityArray = explode(",", $request->json('form_data.quantities'));
        
        for($i = 0; $i < count($productIdArray); ++ $i)
        {
            $records[$productIdArray[$i]] = ['quantity' => $quantityArray[$i]];
        }

        /** create order_product records */
        $order->products()->attach($records);

        /** add product analytics */
        $this->processOrderAnalytics($productIdArray);

        return $order;
    }

    /**
     * @param array $ids - array of product id
     */
    protected function processOrderAnalytics($ids)
    {
        $products = Product::whereIn('id', $ids)->get();
        foreach($products as $product)
        {
            $this->dailyProductStats($product, 'order');
        }
    }
}
