<?php

namespace App\Repositories;

use App\Jobs\MeetingJob;
use App\Models\Meeting;

class MeetingRepository{

    public function store($request)
    {
        $meeting=Meeting::create([
            'created_by'=>auth()->user()->id,
            'responsible_id'=>$request->responsible_id,
            'participants_id'=>$request->participants_id,
            'start_date'=>$request->start_date,
            'end_date'=> $request->end_date
        ]);

        dispatch(new MeetingJob($meeting,'created'));

    }

    public function update($request,$meeting)
    {
        $meeting->update([
            'responsible_id'=>$request->responsible_id,
            'participants_id'=>$request->participants_id,
            'start_date'=>$request->start_date,
            'end_date'=> $request->end_date
        ]);

        dispatch(new MeetingJob($meeting,'updated'));
    }

    public function delete($meeting)
    {
        $meeting->delete();

        dispatch(new MeetingJob($meeting,'deleted'));
    }

}
