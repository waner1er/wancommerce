<?php

namespace App\Http\Controllers;

use App\Services\PayPalService;
use Illuminate\Http\Request;

class PayPalTestController extends Controller
{
    public function test()
    {
        $results = [
            'configuration' => [
                'mode' => config('services.paypal.mode'),
                'client_id_configured' => !empty(config('services.paypal.client_id')),
                'secret_configured' => !empty(config('services.paypal.secret')),
                'client_id' => config('services.paypal.client_id') ? substr(config('services.paypal.client_id'), 0, 10) . '...' : 'NOT SET',
            ],
            'status' => '❌ Not tested yet',
        ];

        try {
            $paypalService = new PayPalService();

            // Test creating a simple order
            $testOrder = $paypalService->createOrder(
                10.00,
                'EUR',
                [
                    [
                        'name' => 'Test Product',
                        'description' => 'Test Description',
                        'price' => 10.00,
                        'quantity' => 1,
                    ]
                ]
            );

            if ($testOrder['success']) {
                $results['status'] = '✅ PayPal configuration is VALID';
                $results['test_order'] = [
                    'success' => true,
                    'order_id' => $testOrder['order_id'],
                    'message' => 'Test order created successfully in PayPal sandbox',
                ];
            } else {
                $results['status'] = '❌ PayPal configuration has ERRORS';
                $results['test_order'] = [
                    'success' => false,
                    'error' => $testOrder['error'],
                ];
            }

        } catch (\Exception $e) {
            $results['status'] = '❌ PayPal configuration has ERRORS';
            $results['error'] = $e->getMessage();
        }

        return view('paypal-test', ['results' => $results]);
    }
}
