<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Section;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SectionPerformances extends Model
{
    use HasFactory,HasUuids;

    protected $guarded=[];

    //retreive section
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}
