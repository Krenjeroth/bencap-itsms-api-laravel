<?php

namespace Database\Seeders;

use App\Models\User;
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
            'name' => 'SysAdmin',
            'email' => 'admin@itsms.com',
        ]);

        User::factory()->create([
          'id' => 'cf6f9ac2-1cd4-43a8-bfba-acdc431282f9',
            // 'name' => 'Krenjer Jan J. Sapitola',
            'name' => 'KrenjerJS',
            'email' => 'krenjerjs@itsms.com',
        ]);

        User::factory()->create([
          'id' => '3292e07c-a2a6-40bf-8070-0bb9e76292d6',
            // 'name' => 'Brian B. Mang-Oy Jr.',
            'name' => 'BrianBM',
            'email' => 'brianbm@itsms.com',
        ]);

        User::factory()->create([
          'id' => '5ea07171-e126-4142-9997-9ec24e180e53',
            // 'name' => 'Rae Sandy B. Calado',
            'name' => 'RaeBC',
            'email' => 'raebc@itsms.com',
        ]);

        User::factory()->create([
          'id' => '4885e9d6-7f1c-4283-b1c1-954316312be2',
            // 'name' => 'Perseus B. Pangilinan',
            'name' => 'PerseusBP',
            'email' => 'perseusbp@itsms.com',
        ]);

        User::factory()->create([
          'id' => 'e749da8a-8924-44a5-b9a8-b270f43c0e42',
            // 'name' => 'Neilsen P. Kisim',
            'name' => 'NeilsenPK',
            'email' => 'neilsenpk@itsms.com',
        ]);

        User::factory()->create([
          'id' => 'bf4475b5-257e-4679-b7bc-35941392d659',
            // 'name' => 'Lester P. Metua',
            'name' => 'LesterPM',
            'email' => 'lesterpm@itsms.com',
        ]);

        $this->call([
          ProfileSeeder::class,
          RoleSeeder::class,
          PermissionSeeder::class,
          PermissionRoleTableSeeder::class,
          RoleUserTableSeeder::class,
          MeasurementUnitSeeder::class,
        ]);
    }
}
