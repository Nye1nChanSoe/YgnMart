<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentIntent;
use Stripe\Stripe;

trait StripePaymentTrait
{
    /**
     * Create Stripe's PaymentIntent object with specified options
     * 
     * @param array $options Associative array of attributes that are required to create PaymentIntent
     * @return PaymentIntent
     */
    public function createPayment(array $options)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        /** 
         * PaymentIntent object requires amount, currency, payment_method_types 
         * https://stripe.com/docs/api/payment_intents
         */
        $intent = PaymentIntent::create($options);
        return $intent;
    }

    /**
     * Retrieve the specified PaymentIntent
     * 
     * @param string $id PaymentIntent's unique identifier
     * @return PaymentIntent
     */
    public function retrievePayment(string $id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $intent = PaymentIntent::retrieve($id);
        return $intent;
    }

    /**
     * Update the specified PaymentIntent with the given data
     * 
     * @param string $id PaymentIntent's unique identifier
     * @param array $data Associative array of attributes to update the specified PaymentIntent's data
     * @return PaymentIntent
     */
    public function updatePayment(string $id, array $data)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $intent = PaymentIntent::update($id, $data);
        return $intent;
    }

    /**
     * Cancel the specified Payment on Strip server
     * 
     * @param string $id PaymentIntent's id 
     * @return void
     */
    public function cancelPayment($id)
    {
        $paymentIntent = $this->retrievePayment($id);

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