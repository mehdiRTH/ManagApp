<?php

namespace Database\Seeders;

use App\Models\DailyActivity;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DailyActivitySeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::whereHas('roles',function($query){
            return $query->where('name','!=','super admin')->where('name','!=','admin');
        })->get()->each(function($user){
            //create Daily activity
            DailyActivity::create([
                'user_id'=>$user->id
            ]);

        });


    }
}
