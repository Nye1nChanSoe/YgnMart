<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        /** if user try to directly access the route without adding items to checkout, redirect them back */
        if(!Checkout::where('user_id', auth()->id())->exists())
        {
            return redirect()->route('carts.index');
        }

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        $addresses = auth()->user()->addresses;

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        /** 
         * includes the details of the transaction, 
         * such as supported payment methods, amount to collect and the desired currency 
         * 'amount' and 'currency' are attributes required for the payment to complete
         */
        $paymentIntent = PaymentIntent::create([
            'amount' => Checkout::where('user_id', auth()->id())->first()->total_price,
            'currency' => 'usd'
        ]);

        /** 
         * clientSecret is a key that is a unique identifier for this PaymentIntent object
         * we need to pass that key to the client-side, to confirm card payment
         */
        $clientSecret = $paymentIntent->client_secret;
        return view('checkout.index', compact(['cartItems', 'addresses', 'clientSecret']));
    }

    public function store(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        /** 
         * Stripe API object that represents a payment attempt
         * 
         * contains all the information needed to complete a payment, 
         * this object includes a 'status' field, which can be used to check the current status of the payment
         * and when this object is created, Stripe generates a unique 'client_secret' value that is return by the API response
         * 'client_secret' is used to authenticate the payment on the client-side, 
         */
        $intent = PaymentIntent::create([
            'amount' => $request->input('total_amount'),
            'currency' => 'usd',
            'payment_method_types' => [$request->input('payment_method')],
            'description' => 'Test Payment',
            'receipt_email' => auth()->user()->email,
            'metadata' => [
                'customer_name' => auth()->user()->name,
                'order_number' => fake()->randomNumber(4, true)
            ],
        ]);

        dd($intent);
    }
}
