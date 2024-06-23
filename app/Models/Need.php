<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Need extends Model
{
    use HasFactory,HasUuids;

    protected $guarded=[];

    protected function casts():array
    {
        return [
            'other_users'=>'array'
        ];
    }

    //retreive the person who created the Need
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
