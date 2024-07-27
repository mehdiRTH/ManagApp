<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository{

    public function store($request)
    {
        $user=User::create([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> Hash::make($request->password),
            "section_id"=>$request->section
        ]);

        $user->assignRole($request->role);
    }

    public function update($request, $user)
    {
        $user->update([
            "name"=> $request->name,
            "email"=> $request->email,
            "password"=> Hash::make($request->password),
            "section_id"=>$request->section
        ]);
    }

    public function destroy($user)
    {
        $user->delete();
    }


}
