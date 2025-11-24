<?php

namespace App\Services;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class PayPalService
{
    private $client;

    public function __construct()
    {
        $this->client = $this->getClient();
    }

    /**
     * Get PayPal HTTP client
     */
    private function getClient()
    {
        $clientId = config('services.paypal.client_id');
        $clientSecret = config('services.paypal.secret');
        $mode = config('services.paypal.mode', 'sandbox');

        // Check if credentials are configured
        if (empty($clientId) || empty($clientSecret)) {
            throw new \Exception('PayPal credentials are not configured. Please set PAYPAL_CLIENT_ID and PAYPAL_SECRET in your .env file.');
        }

        if ($mode === 'live') {
            $environment = new ProductionEnvironment($clientId, $clientSecret);
        } else {
            $environment = new SandboxEnvironment($clientId, $clientSecret);
        }

        return new PayPalHttpClient($environment);
    }

    /**
     * Create a PayPal order
     */
    public function createOrder(float $amount, string $currency = 'EUR', array $items = [])
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');

        $itemsData = [];
        $itemsTotal = 0;

        foreach ($items as $item) {
            $itemPrice = number_format($item['price'], 2, '.', '');
            $itemTotal = number_format($item['price'] * $item['quantity'], 2, '.', '');
            $itemsTotal += $itemTotal;

            $itemsData[] = [
                'name' => $item['name'],
                'description' => $item['description'] ?? '',
                'unit_amount' => [
                    'currency_code' => $currency,
                    'value' => $itemPrice,
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => $currency,
                        'value' => number_format($amount, 2, '.', ''),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => $currency,
                                'value' => number_format($itemsTotal, 2, '.', ''),
                            ],
                        ],
                    ],
                    'items' => $itemsData,
                ]
            ],
            'application_context' => [
                'brand_name' => config('app.name'),
                'locale' => 'fr-FR',
                'landing_page' => 'BILLING',
                'shipping_preference' => 'NO_SHIPPING',
                'user_action' => 'PAY_NOW',
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel'),
            ]
        ];

        try {
            $response = $this->client->execute($request);
            return [
                'success' => true,
                'order_id' => $response->result->id,
                'data' => $response->result,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Capture a PayPal order
     */
    public function captureOrder(string $orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        try {
            $response = $this->client->execute($request);

            return [
                'success' => true,
                'status' => $response->result->status,
                'data' => $response->result,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Get PayPal client ID for frontend
     */
    public static function getClientId(): string
    {
        return config('services.paypal.client_id') ?? '';
    }
}
