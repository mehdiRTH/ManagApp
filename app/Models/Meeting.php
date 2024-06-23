<?php

namespace App\Models;

use App\Observers\MeetingObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;

#[ObservedBy([MeetingObserver::class])]
class Meeting extends Model
{
    use HasFactory,hasUuids, Notifiable;

    protected $guarded=[];


    protected function casts():array
    {
        return [
            'participants_id'=>'array'
        ];
    }

    //retreive the user who created the meeting

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    //retreive the reponsible of the meeting
    public function responsible(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsible_id');
    }

    //retreive the participants of the meeting
    public function getParticipantsAttribute()
    {
        return User::findMany($this->participants_id);
    }
}
