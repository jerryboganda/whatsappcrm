<?php

namespace App\Lib\Payment;

use Stripe\StripeClient;
use Razorpay\Api\Api;
use Exception;

class PaymentLinkService
{
    public function generateStripeLink($apiKey, $amount, $currency, $description, $successUrl, $cancelUrl)
    {
        try {
            $stripe = new StripeClient($apiKey);
            $session = $stripe->checkout->sessions->create([
                'payment_method_types' => ['card'],
                'line_items' => [
                    [
                        'price_data' => [
                            'currency' => $currency,
                            'product_data' => [
                                'name' => $description,
                            ],
                            'unit_amount' => round($amount * 100),
                        ],
                        'quantity' => 1,
                    ]
                ],
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
            ]);

            return [
                'success' => true,
                'url' => $session->url,
                'id' => $session->id
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function generateRazorpayLink($keyId, $keySecret, $amount, $currency, $description, $callbackUrl)
    {
        try {
            $api = new Api($keyId, $keySecret);
            $link = $api->paymentLink->create([
                'amount' => round($amount * 100),
                'currency' => $currency,
                'accept_partial' => false,
                'description' => $description,
                'callback_url' => $callbackUrl,
                'callback_method' => 'get'
            ]);

            return [
                'success' => true,
                'url' => $link->short_url,
                'id' => $link->id
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
