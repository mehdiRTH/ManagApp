<?php

namespace App\Repositories;

use App\Http\Requests\OffRequestRequest;
use App\Jobs\OffRequestJob;
use App\Jobs\UploadFilesJob;
use App\Models\OffRequest;
use App\Notifications\OffRequestNotification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class OffRequestRepository{

    public $authFilePrefix='';
    public function __construct()
    {
       if(auth()->check()) $this->authFilePrefix=OffRequest::FILE_PREFFIX.auth()->user()->name.'_'.auth()->user()->id;
    }

    public function getOffRequests() : LengthAwarePaginator
    {
        $offRequests=null;
        if(hasRole(['HR','admin','super admin']))
        {
            $offRequests=OffRequest::paginate(5);
        }else{
            $offRequests=OffRequest::where('user_id',auth()->user()->id)->paginate(5);
        }
        return $offRequests;
    }

    public function store(OffRequestRequest $request) : void
    {
        $justification='';
        if($request->type=="Textual") $justification=$request->justification;

        $interval=date_diff(date_create($request->start_date),date_create($request->end_date));

        $offRequest=OffRequest::create([
            'label'=>$request->label,
            'description'=>$request->description,
            "type" => $request->type,
            "justification" => $justification,
            "duration" => $interval->format("%a Day(s) | %H Hour(s)"),
            "user_id" => auth()->user()->id,
            "status" => 'Pending',
            "start_date"=>date_create($request->start_date),
            "end_date"=>date_create($request->end_date)
        ]);

        if($request->type=="Files")
        {
            $offRequest->update([
                "justification" => uploadFiles($request->justification,$this->authFilePrefix,$offRequest->id)
            ]);
        }

        OffRequestJob::dispatch($offRequest);
    }

    public function update(OffRequestRequest $request,OffRequest $offRequest)
    {
        $old_status=$offRequest->status;

        // check if there's new files to upload
       if($request->type=="Files"){
            $oldJusitifcation = json_decode($offRequest->justification);
            $this->handleFile($offRequest,$oldJusitifcation,$request->justification);
       }

       //if the date changed it will change the interval
       if($request->start_date==$offRequest->start_date && $request->end_date==$offRequest->end_date){
        $interval=date_diff(date_create($request->start_date),date_create($request->end_date));
        $request->merge(['duration'=>$interval->format("%a Day(s) | %H Hour(s)")]);
       }


       $offRequest->update($request->except('isInModal','justification'));

       if($old_status!=$request->status) OffRequestJob::dispatch($offRequest,'receiver');
    }

    public function delete(OffRequest $offRequest)
    {
        deleteFiles(json_decode($offRequest->justification));

        $offRequest->delete();
    }

    function handleFile(OffRequest $offRequest,$old_data,$new_data)
    {
        if($this->isArrayOfFiles($new_data)){

            $justification=uploadFiles($new_data,$this->authFilePrefix,$offRequest->id,$old_data);

            $offRequest->update([
                "justification"=>$justification
            ]);
        }
    }

    function isArrayOfFiles($variable)
    {
        if (!is_array($variable)) {
            return false;
        }

        foreach ($variable as $file) {
            if ($file instanceof UploadedFile) {
                return true;
            }
        }

    }
}
