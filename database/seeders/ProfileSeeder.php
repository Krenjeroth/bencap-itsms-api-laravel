<?php

namespace Database\Seeders;

use App\Models\Profile;
use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $profiles = [
          // Administrator
          ['user_id' => '88964338-6721-4816-be39-9a9afbe8df95', 'display_name' => 'System Administrator', 'designation' => 'System Administrator' , 'engagement' => 'ready'],
          // Personnel
          ['user_id' => 'cf6f9ac2-1cd4-43a8-bfba-acdc431282f9', 'display_name' => 'Krenjer Jan J. Sapitola', 'designation' => 'Computer Programmer I' , 'engagement' => 'ready'],
          ['user_id' => '3292e07c-a2a6-40bf-8070-0bb9e76292d6', 'display_name' => 'Brian B. Mang-Oy Jr.', 'designation' => 'CMT II' , 'engagement' => 'ready'],
          ['user_id' => '5ea07171-e126-4142-9997-9ec24e180e53', 'display_name' => 'Rae Sandy B. Calado', 'designation' => 'CMT I' , 'engagement' => 'ready'],
          ['user_id' => '4885e9d6-7f1c-4283-b1c1-954316312be2', 'display_name' => 'Perseus B. Pangilinan', 'designation' => 'CMT I' , 'engagement' => 'ready'],
          ['user_id' => 'e749da8a-8924-44a5-b9a8-b270f43c0e42', 'display_name' => 'Neilsen P. Kisim', 'designation' => 'CMT I' , 'engagement' => 'ready'],
          ['user_id' => 'bf4475b5-257e-4679-b7bc-35941392d659', 'display_name' => 'Lester P. Metua', 'designation' => 'CMT I' , 'engagement' => 'ready'],
          // User
          // ['user_id' => '152f3ecd-2e69-4cd4-bdc8-43c685602e54', 'display_name' => 'User', 'designation' => 'User' , 'engagement' => 'ready'],
        ];

        Profile::insert($profiles);
    }
}
