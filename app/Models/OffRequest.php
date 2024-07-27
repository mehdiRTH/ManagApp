<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class OffRequest extends Model
{
    use HasFactory, hasUuids;

    protected $guarded=[];

    const FILE_PREFFIX='public/off_requests/';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
