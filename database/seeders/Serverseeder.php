<?php

namespace Database\Seeders;

use App\Models\Server;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        Server::create([
            'name' => 'Web Server',
            'local_network' => '192.168.1.0/24',
            'status' => 'active',
            'description' => 'Server untuk hosting website'
        ]);

        Server::create([
            'name' => 'Database Server',
            'local_network' => '192.168.2.0/24',
            'status' => 'active',
            'description' => 'Server untuk database MySQL'
        ]);

        Server::create([
            'name' => 'Mail Server',
            'local_network' => '192.168.3.0/24',
            'status' => 'maintenance',
            'description' => 'Server untuk email'
        ]);
    }
}