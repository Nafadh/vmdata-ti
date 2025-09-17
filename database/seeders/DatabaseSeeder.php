<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;    
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            VMSpecificationSeeder::class,
            ServerSeeder::class,
            RentalSeeder::class,
            // UserSeeder::class,
            // VMSeeder::class,
            // RentalSeeder
         ]); 

         // Admin
        DB::table('users')->insertOrIgnore([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // default password = "password"
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // User Demo
        DB::table('users')->insertOrIgnore([
            'name' => 'User Demo',
            'email' => 'user@example.com',
            'password' => Hash::make('password'), // default password = "password"
            'role' => 'user',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}