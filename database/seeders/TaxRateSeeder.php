<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaxRate;

class TaxRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $taxRates = [
            ['country_code' => 'FR', 'country_name' => 'France', 'rate' => 20.00, 'is_default' => true],
            ['country_code' => 'BE', 'country_name' => 'Belgique', 'rate' => 21.00, 'is_default' => false],
            ['country_code' => 'DE', 'country_name' => 'Allemagne', 'rate' => 19.00, 'is_default' => false],
            ['country_code' => 'ES', 'country_name' => 'Espagne', 'rate' => 21.00, 'is_default' => false],
            ['country_code' => 'IT', 'country_name' => 'Italie', 'rate' => 22.00, 'is_default' => false],
            ['country_code' => 'NL', 'country_name' => 'Pays-Bas', 'rate' => 21.00, 'is_default' => false],
            ['country_code' => 'PT', 'country_name' => 'Portugal', 'rate' => 23.00, 'is_default' => false],
            ['country_code' => 'GB', 'country_name' => 'Royaume-Uni', 'rate' => 20.00, 'is_default' => false],
            ['country_code' => 'IE', 'country_name' => 'Irlande', 'rate' => 23.00, 'is_default' => false],
            ['country_code' => 'AT', 'country_name' => 'Autriche', 'rate' => 20.00, 'is_default' => false],
            ['country_code' => 'DK', 'country_name' => 'Danemark', 'rate' => 25.00, 'is_default' => false],
            ['country_code' => 'SE', 'country_name' => 'Suède', 'rate' => 25.00, 'is_default' => false],
            ['country_code' => 'FI', 'country_name' => 'Finlande', 'rate' => 24.00, 'is_default' => false],
            ['country_code' => 'PL', 'country_name' => 'Pologne', 'rate' => 23.00, 'is_default' => false],
            ['country_code' => 'CZ', 'country_name' => 'République Tchèque', 'rate' => 21.00, 'is_default' => false],
            ['country_code' => 'HU', 'country_name' => 'Hongrie', 'rate' => 27.00, 'is_default' => false],
            ['country_code' => 'RO', 'country_name' => 'Roumanie', 'rate' => 19.00, 'is_default' => false],
            ['country_code' => 'GR', 'country_name' => 'Grèce', 'rate' => 24.00, 'is_default' => false],
            ['country_code' => 'LU', 'country_name' => 'Luxembourg', 'rate' => 17.00, 'is_default' => false],
            ['country_code' => 'CH', 'country_name' => 'Suisse', 'rate' => 7.70, 'is_default' => false],
        ];

        foreach ($taxRates as $taxRate) {
            TaxRate::updateOrCreate(
                ['country_code' => $taxRate['country_code']],
                $taxRate
            );
        }
    }
}
