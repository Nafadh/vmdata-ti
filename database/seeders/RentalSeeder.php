<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\VMSpecification;
use App\Models\Rental;
use App\Models\User;
use App\Models\Vm;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user pertama (atau bikin dummy user kalau belum ada)
        $user = User::first() ?? User::factory()->create();

        // Buat beberapa VM yang otomatis terhubung ke user ini
        $vms = Vm::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        // Assign setiap VM ke rental
        foreach ($vms as $vm) {
            Rental::create([
                'user_id'   => $user->id,
                'vm_id'     => $vm->id,
                'admin_id'  => 1,
                'start_date'=> now(),
                'end_date'  => now()->addDays(7),
                'status'    => 'available',
            ]);
        }

        // bikin kategori default
        $category = Category::firstOrCreate(
        ['name' => 'Basic']
        );

        // bikin spesifikasi default
        $spec = VMSpecification::firstOrCreate(
        ['name' => 'Standard Package'],
        [
            'ram_gb' => 8,
            'storage_gb' => 256,
            'description' => 'Spesifikasi standar untuk testing'
        ]
    );

         // buat VM
    $vm = Vm::create([
        'name' => 'VM Demo',
        'category_id' => $category->id,
        'specification_id' => $spec->id,
        'ram' => 4,
        'storage' => 50,
        'backup_disk' => 10,
        'description' => 'VM untuk testing',
        'status' => 'available',
        'user_id' => $user->id,
    ]);
        $this->command->info('Rentals seeded successfully!');
    }
}
