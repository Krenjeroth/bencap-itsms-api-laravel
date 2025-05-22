<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_permissions = Permission::all();

        $user_permissions = Permission::whereIn('title', [
          'user_index',
        ])->get();

        Role::find(1)->permissions()->attach($admin_permissions); // 1 = Admin
        Role::find(2)->permissions()->attach($user_permissions); // 2 = User
    }
}
