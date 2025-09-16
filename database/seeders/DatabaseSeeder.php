<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
    }
}