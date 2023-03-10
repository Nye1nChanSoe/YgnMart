<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        /** if user try to directly access the route without adding items to checkout, redirect them back */
        try {
            $checkout = Checkout::where('user_id', auth()->id())
                ->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return redirect()->route('carts.index');
        }

        $user = auth()->user();
        $cartItems = Cart::with('product')->where('user_id', $user->id)->orderBy('created_at', 'asc')->get();
        $addresses = $user->addresses;

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        /** check if a payment intent ID already exists in the checkout record */
        if($checkout->payment_intent_id) {
            $paymentIntent = PaymentIntent::retrieve($checkout->payment_intent_id);
        } else {
            /** 
             * Stripe supports a variety of payment types including 'card' https://stripe.com/docs/payments/payment-methods/overview
             */
            $paymentIntent = PaymentIntent::create([
                'amount' => Checkout::where('user_id', $user->id)->first()->total_price * 100,
                'currency' => 'usd',
                'payment_method_types' => ['card'],
                'statement_descriptor' => 'Yangon Mart Online',
                'description' => 'Online Purchase',
                'receipt_email' => $user->email,
                'metadata' => [
                    'order_id' => '',
                    'customer_id' => $user->id,
                ],
            ]);

            $checkout->payment_intent_id = $paymentIntent->id;
            $checkout->save();
        }

        /** 
         * a secret key that is used to authenticate the client-side API request (to Stripe server) to confirm the payment
         * we need to pass that key to the client-side, to confirm card payment and it's a one-time use key
         */
        $clientSecret = $paymentIntent->client_secret;
        return view('checkout.index', compact(['cartItems', 'addresses', 'clientSecret']));
    }


    public function destroy(Checkout $checkout)
    {
        $checkout->delete();

        /** 200: the request was successful, empty response body */
        return response()->json([
            'message' => 'Checkout session removed successfully',
        ]);
    }
}
