<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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

        // Buat beberapa VM lewat factory (hostname otomatis keisi)
        $vms = Vm::factory()->count(3)->create();

        // Assign setiap VM ke rental
        foreach ($vms as $vm) {
            Rental::create([
                'user_id' => $user->id,
                'vm_id'   => $vm->id,
                'admin_id' => 1,
                'start_date' => now(),
                'end_date'   => now()->addDays(7),
                'status'     => 'active',
            ]);
        }

        $this->command->info('Rentals seeded successfully!');
    }
}
