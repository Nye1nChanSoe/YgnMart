<?php

namespace App\Traits;

use Stripe\PaymentIntent;
use Stripe\Stripe;

trait StripePaymentTrait
{
    /**
     * Create Stripe's PaymentIntent object with specified amount and currency
     * 
     * @param array $options
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
     * Retrieve the specified PaymentIntent by ID
     * 
     * @param string $id
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
     * @param string $id
     * @param array $data
     * @return PaymentIntent
     */
    public function updatePayment(string $id, array $data)
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $intent = PaymentIntent::update($id, $data);
        return $intent;
    }
}