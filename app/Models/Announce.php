<?php

namespace App\Models;

use App\Models\Scopes\IsAnnounceActivatedScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Attributes\ScopedBy;

#[ScopedBy([IsAnnounceActivatedScope::class])]
class Announce extends Model
{
    use HasFactory,HasUuids;

    protected $guarded=[];

    protected $casts=[
        'is_active'=>'boolean'
    ];


    public function sectionReceiver() : BelongsTo
    {
        return $this->belongsTo(Section::class,"receiver");
    }

    public function employeeReceiver() : BelongsTo
    {
        return $this->belongsTo(User::class,"receiver");
    }

}
