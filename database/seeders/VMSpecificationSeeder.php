<?php
// database/seeders/VMSpecificationSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VMSpecification;

class VMSpecificationSeeder extends Seeder
{
    public function run()
    {
        $specs = [
            [
                'name' => 'Basic',
                'cpu_cores' => 1,
                'ram_gb' => 1,
                'storage_gb' => 20,
                'price_per_hour' => 0.50,
                'description' => 'Paket dasar untuk penggunaan ringan'
            ],
            [
                'name' => 'Standard',
                'cpu_cores' => 2,
                'ram_gb' => 4,
                'storage_gb' => 50,
                'price_per_hour' => 1.00,
                'description' => 'Paket standar untuk aplikasi medium'
            ],
            [
                'name' => 'Premium',
                'cpu_cores' => 4,
                'ram_gb' => 8,
                'storage_gb' => 100,
                'price_per_hour' => 2.00,
                'description' => 'Paket premium untuk aplikasi besar'
            ],
        ];

        foreach ($specs as $spec) {
            VMSpecification::create($spec);
        }
    }
}
