<?php
// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Web Server', 'description' => 'Server untuk aplikasi web'],
            ['name' => 'Database Server', 'description' => 'Server untuk database'],
            ['name' => 'Development', 'description' => 'Server untuk development'],
            ['name' => 'Testing', 'description' => 'Server untuk testing aplikasi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
