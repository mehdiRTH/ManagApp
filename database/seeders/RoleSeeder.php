<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //create Super Admin Role
        Role::create(['name' => 'super admin']);

        //create Admin Role
        Role::create(['name' => 'admin']);

        //create Responsible Role
        Role::create(['name' => 'responsible']);

        //create HR Role
        Role::create(['name' => 'HR']);

        //create Employee Role
        Role::create(['name' => 'employee']);

    }
}
