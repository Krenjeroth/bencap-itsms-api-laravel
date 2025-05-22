<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::find('88964338-6721-4816-be39-9a9afbe8df95')->roles()->attach(1); // Admin - 1 = Admin
        User::find('152f3ecd-2e69-4cd4-bdc8-43c685602e54')->roles()->attach(2); // User - 2 = User
    }
}
