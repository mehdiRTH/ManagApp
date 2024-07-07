<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasFactory, Notifiable, softDeletes ,hasUuids,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'section_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function section() : BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function getUserAnnounceAttribute() : Collection
    {
        $announces=[];
        $user=auth()->user();

        if(!$user) return [];

        //Query for get announces for authenticated user
        $announces=Announce::where(function ($query) use($user){
            $query->where('type','Direct')
                  ->where('receiver',$user->id);
        })->orWhere(function ($query) use ($user){
            $query->where('type','Section')
                  ->where('receiver',$user->section?->id);
        })->orWhere('type','All')
          ->get();

        return $announces;
    }
}
