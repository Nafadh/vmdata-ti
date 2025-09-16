<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VMSpecification;

class VMSpecificationSeeder extends Seeder
{
    public function run(): void
    {
        VMSpecification::create([
            'name' => 'Basic',
            'cpu_cores' => 1,
            'ram_gb' => 1,
            'storage_gb' => 20,
            'price_per_hour' => 0.5,
            'description' => 'Paket dasar untuk penggunaan ringan',
        ]);

        VMSpecification::create([
            'name' => 'Standard',
            'cpu_cores' => 2,
            'ram_gb' => 4,
            'storage_gb' => 50,
            'price_per_hour' => 1.5,
            'description' => 'Paket standar untuk penggunaan menengah',
        ]);

        VMSpecification::create([
            'name' => 'Premium',
            'cpu_cores' => 4,
            'ram_gb' => 8,
            'storage_gb' => 100,
            'price_per_hour' => 3.0,
            'description' => 'Paket premium untuk penggunaan berat',
        ]);

        echo "VM Specifications seeded successfully!\n";
    }
}
