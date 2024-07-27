<?php

namespace App\Repositories;

use App\Jobs\MeetingJob;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class MeetingRepository{

    public function getMeetings() : LengthAwarePaginator
    {
        $user=User::find(auth()->user()->id);
        $meetings=null;

        if ($user->hasRole(['admin', 'responsible']))
        {
            $meetings=Meeting::with(['responsible','createdBy'])->paginate(5);
        }else{
            $meetings=Meeting::with(['responsible','createdBy'])->whereJsonContains('participants_id',$user->id)->paginate(5);
        }

        return $meetings;
    }
    public function store($request) : void
    {
        $meeting=Meeting::create([
            'created_by'=>auth()->user()->id,
            'responsible_id'=>$request->responsible_id,
            'participants_id'=>$request->participants_id,
            'start_date'=>$request->start_date,
            'end_date'=> $request->end_date,
            'description'=> $request->description
        ]);

        MeetingJob::dispatch($meeting,'created');

    }

    public function update($request,$meeting) : void
    {
        $meeting->update([
            'responsible_id'=>$request->responsible_id,
            'participants_id'=>$request->participants_id,
            'start_date'=>$request->start_date,
            'end_date'=> $request->end_date,
            'description'=> $request->description
        ]);

        MeetingJob::dispatch($meeting,'updated');
    }

    public function delete($meeting) : void
    {
        $start_date = Carbon::parse($meeting->start_date);

        if ($start_date->isAfter(Carbon::now())) MeetingJob::dispatch($meeting, 'deleted');

        $meeting->delete();

    }

}
