<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shippingRates = [
            // Colissimo
            [
                'name' => 'Colissimo - Moins de 250g',
                'carrier' => 'La Poste',
                'weight_min' => 0,
                'weight_max' => 0.25,
                'price' => 5.50,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 250g à 500g',
                'carrier' => 'La Poste',
                'weight_min' => 0.251,
                'weight_max' => 0.5,
                'price' => 7.50,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 500g à 1kg',
                'carrier' => 'La Poste',
                'weight_min' => 0.501,
                'weight_max' => 1,
                'price' => 9.50,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 1kg à 2kg',
                'carrier' => 'La Poste',
                'weight_min' => 1.001,
                'weight_max' => 2,
                'price' => 12.00,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 2kg à 5kg',
                'carrier' => 'La Poste',
                'weight_min' => 2.001,
                'weight_max' => 5,
                'price' => 15.50,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 5kg à 10kg',
                'carrier' => 'La Poste',
                'weight_min' => 5.001,
                'weight_max' => 10,
                'price' => 22.00,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Colissimo - 10kg à 30kg',
                'carrier' => 'La Poste',
                'weight_min' => 10.001,
                'weight_max' => 30,
                'price' => 35.00,
                'zone' => 'France',
                'delivery_days_min' => 2,
                'delivery_days_max' => 3,
                'is_active' => true,
            ],
            // Chronopost Express
            [
                'name' => 'Chronopost Express - Moins de 1kg',
                'carrier' => 'Chronopost',
                'weight_min' => 0,
                'weight_max' => 1,
                'price' => 18.00,
                'zone' => 'France',
                'delivery_days_min' => 1,
                'delivery_days_max' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Chronopost Express - 1kg à 5kg',
                'carrier' => 'Chronopost',
                'weight_min' => 1.001,
                'weight_max' => 5,
                'price' => 25.00,
                'zone' => 'France',
                'delivery_days_min' => 1,
                'delivery_days_max' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Chronopost Express - 5kg à 10kg',
                'carrier' => 'Chronopost',
                'weight_min' => 5.001,
                'weight_max' => 10,
                'price' => 35.00,
                'zone' => 'France',
                'delivery_days_min' => 1,
                'delivery_days_max' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Chronopost Express - 10kg à 30kg',
                'carrier' => 'Chronopost',
                'weight_min' => 10.001,
                'weight_max' => 30,
                'price' => 50.00,
                'zone' => 'France',
                'delivery_days_min' => 1,
                'delivery_days_max' => 1,
                'is_active' => true,
            ],
        ];

        foreach ($shippingRates as $rate) {
            \App\Models\ShippingRate::create($rate);
        }
    }
}
