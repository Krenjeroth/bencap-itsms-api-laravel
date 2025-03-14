<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
          'id' => '7f84b7d8-3e2c-4a1a-96f3-9e8a2b6c74d1',
            'name' => 'Admin',
            'email' => 'admin@itsms.com',
        ]);

        User::factory()->create([
          'id' => 'f47ac10b-58cc-4372-a567-0e02b2c3d479',
            'name' => 'User',
            'email' => 'user@itsms.com',
        ]);
    }
}
