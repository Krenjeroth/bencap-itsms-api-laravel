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
        User::factory()->create([
          'id' => '88964338-6721-4816-be39-9a9afbe8df95',
            'name' => 'Admin',
            'email' => 'admin@itsms.com',
        ]);

        User::factory()->create([
          'id' => '152f3ecd-2e69-4cd4-bdc8-43c685602e54',
            'name' => 'User',
            'email' => 'user@itsms.com',
        ]);

        $this->call([
          RoleSeeder::class,
          PermissionSeeder::class,
          PermissionRoleTableSeeder::class,
          RoleUserTableSeeder::class,
        ]);
    }
}
