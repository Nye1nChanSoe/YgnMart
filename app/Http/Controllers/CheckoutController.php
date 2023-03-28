<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Traits\StripePaymentTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CheckoutController extends Controller
{
    use StripePaymentTrait;

    public function index()
    {
        /** if user try to directly access the route without adding items to checkout, redirect them back */
        try 
        {
            $checkout = Checkout::where('user_id', auth()->id())->firstOrFail();
        } 
        catch (ModelNotFoundException $e) 
        {
            return redirect()->route('carts.index');
        }

        /** 
         * a secret key that is used to authenticate the client-side API request (in Stripe server) to confirm the payment
         * we need to pass that key to the client-side, to confirm card payment and it's a one-time use key
         */
        $paymentIntent = $this->retrievePayment($checkout->payment_intent_id);
        $clientSecret = $paymentIntent->client_secret;

        $cartItems = Cart::with('product')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->get();
        $addresses = auth()->user()->addresses;

        return view('checkout.index', compact(['cartItems', 'addresses', 'clientSecret', 'checkout']));
    }

    /** the method will be called asynchronous in the process of making Payments using Stripe and creating order  */
    public function destroy(Checkout $checkout)
    {
        Cart::where('user_id', $checkout->user_id)->delete();    
        $checkout->delete();

        /** 200: the request was successful, empty response body */
        return response()->json([
            'message' => 'Checkout session removed successfully',
        ]);
    }
}
