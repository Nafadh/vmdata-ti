<?php

namespace Database\Factories;

use App\Models\Vm;
use Illuminate\Database\Eloquent\Factories\Factory;

class VmFactory extends Factory
{
    protected $model = Vm::class;

    public function definition(): array
    {
        return [
            'name' => 'VM-' . $this->faker->unique()->numberBetween(1, 100),
            'hostname' => $this->faker->unique()->domainWord() . '.local', // hostname unik
            'category_id' => 1, // bisa disesuaikan dengan CategorySeeder
            'vm_specification_id' => 1, // pastikan sesuai dengan VMSpecificationSeeder
            'os' => $this->faker->randomElement(['ubuntu', 'centos', 'windows', 'debian']),
            'ip_address' => $this->faker->ipv4(),
            'status' => $this->faker->randomElement(['available', 'rented', 'maintenance', 'offline']),
            'description' => $this->faker->sentence(),
            'ports' => json_encode([$this->faker->numberBetween(20, 9000)]),
        ];
    }
}
