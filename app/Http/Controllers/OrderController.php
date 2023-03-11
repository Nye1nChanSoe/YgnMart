<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Traits\StripePaymentTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;

class OrderController extends Controller
{
    use StripePaymentTrait;

    public function show()
    {
        return view('orders.show');
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

    /**
     * @param string $paymentMethod
     * @return Order
     */
    protected function processOrder(Request $request) 
    {
        $paymentMethod = $request->json('form_data.payment_method');

        $order = new Order();
        $order->order_code = 'od_'.Str::uuid()->toString();
        $order->user_id = auth()->id();
        $order->total_price = $request->json('form_data.total_amount');
        $order->description = 'Payment test description';
        
        if($paymentMethod == 'cash')
        {
            $order->payment_type = $paymentMethod;
            $this->cancelPaymentOnStripe($request->json('payment_intent_id'));
        }
        
        if($paymentMethod == 'card')
        {
            $order->payment_intent_id = $request->json('payment_intent_id');
            $order->payment_type = $paymentMethod;
        }

        $order->save();

        /** create order_product records */
        $productIdArray = explode(",", $request->json('form_data.products'));
        $quantityArray = explode(",", $request->json('form_data.quantities'));
        for($i = 0; $i < count($productIdArray); ++ $i)
        {
            $records[$productIdArray[$i]] = ['quantity' => $quantityArray[$i]];
        }
        $order->products()->attach($records);

        return $order;
    }

    /**
     * @param string $paymentIntentId Stripe's unique identifier for payment intents
     * @return void
     */
    protected function cancelPaymentOnStripe($paymentIntentId)
    {
        $paymentIntent = $this->retrievePayment($paymentIntentId);

        try {
            if($paymentIntent->status !== 'succeeded' && $paymentIntent->status !== 'canceled')
            {
                $paymentIntent->cancel();
            }
        } catch(ApiErrorException $e) {

        }
    }
}
