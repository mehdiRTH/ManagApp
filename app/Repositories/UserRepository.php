<?php

namespace App\Repositories;

use App\Models\Notification;
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

    public function readNotification($modal_id)
    {
        $notification=Notification::where('notifiable_id',auth()->user()->id)->whereJsonContains('data->route->params', $modal_id)->first();
        if($notification)
        {
            $notification->update([
                'read_at'=> now()
            ]);
        }

    }

    public function destroy($user)
    {
        $user->delete();
    }


}
