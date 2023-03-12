<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\StripePaymentTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;

class OrderController extends Controller
{
    use StripePaymentTrait;

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
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
     * @param string $paymentMethod
     * @return Order
     */
    protected function processOrder(Request $request) 
    {
        $paymentMethod = $request->json('form_data.payment_method');

        $order = new Order();
        $order->order_code = 'od-'.Str::uuid()->toString();
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

        $productIdArray = explode(",", $request->json('form_data.products'));
        $quantityArray = explode(",", $request->json('form_data.quantities'));
        
        for($i = 0; $i < count($productIdArray); ++ $i)
        {
            $records[$productIdArray[$i]] = ['quantity' => $quantityArray[$i]];
        }

        /** create order_product records */
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

        try 
        {
            if($paymentIntent->status !== 'succeeded' && $paymentIntent->status !== 'canceled') {
                $paymentIntent->cancel();
            } else {
                Log::warning('Unexpected payment intent status: '. $paymentIntent->status);
            }
        } 
        catch(ApiErrorException $e) 
        {
            Log::error('Error canceling payment intent: '. $e->getMessage());
            return response()->json([
                'message' => 'Error canceling payment intent',
            ], 400);
        }
    }
}
