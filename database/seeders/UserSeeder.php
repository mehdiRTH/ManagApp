<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create user and Asign Role Super Admin
        User::factory()->count(1)->create()->each(function ($user){
            $user->assignRole("super admin");
        });

        //Create user and Asign Role Admin
        User::factory()->count(2)->create()->each(function ($user){
            $user->assignRole("admin");
        });

        //Create user and Asign Role HR
        User::factory()->count(1)->create()->each(function ($user){
            $user->assignRole("HR");
        });

        //Create user and Asign Role Responsible
        User::factory()->count(5)->create()->each(function ($user){
            $user->assignRole("responsible");
        });

        //Create user and Asign Role Employee
        User::factory()->count(5)->create()->each(function ($user){
            $user->assignRole("employee");
        });
    }
}
