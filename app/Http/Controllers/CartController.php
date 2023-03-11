<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Checkout;
use App\Models\Product;
use App\Traits\StripePaymentTrait;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use StripePaymentTrait;

    public function index()
    {
        return view('carts.index', [
            'carts' => Cart::with('product')->where('user_id', auth()->id())->orderBy('created_at', 'asc')->get(),
        ]);
    }

    /** show a specifically added item here */
    public function show(Product $product)
    {
        return view('carts.show', [
            'product' => $product,
        ]);
    }

    public function destroy(Cart $cart)
    {
        // Can add more functionalities like recently added items 
        // Add this cart item to the recently added items before deletion

        $cart->delete();
        
        $quantity = $cart->quantity;
        $totalPrice = $cart->product->price * $quantity;
        $count = Cart::where('user_id', auth()->id())->count();

        /** AJAX request so send JSON respond back to the client */
        return response()->json([
            'message' => 'Item removed from the cart', 
            'totalPrice' => $totalPrice, 
            'quantity' => $quantity, 
            'count' => $count,
        ]);
    }

    /** handles the login for checkout */
    public function checkout(Request $request)
    {
        $checkout = Checkout::updateOrCreate(
            ['user_id' => auth()->id()],       // search with user_id  if exists ? update : create
            [
                'total_price' => $request->input('total_amount'),
            ]
        );

        $user = auth()->user();

        $paymentOptions = array([
            'amount' => $checkout->total_price * 100,
            'currency' => 'mmk',
            'payment_method_types' => ['card'],     // https://stripe.com/docs/payments/payment-methods/overview
            'statement_descriptor' => 'Yangon Mart',
            'description' => 'Online Purchase',
            'receipt_email' => $user->email,
            'metadata' => [
                'customer_id' => $user->id,
            ]
        ]);

        /** check if a payment intent ID already exists in the checkout record or not */
        if(!$checkout->payment_intent_id) 
        {
            $paymentIntent = $this->createPayment($paymentOptions);
            $checkout->payment_intent_id = $paymentIntent->id;
            $checkout->save();
        } 
        else 
        {
            $paymentIntent = $this->updatePayment($checkout->payment_intent_id, $paymentOptions);
        }

        return redirect()->route('checkout.index');
    }
}
