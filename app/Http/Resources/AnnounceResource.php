<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnnounceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $receiver=null;
        if($this->type=='Section') $receiver=$this->sectionReceiver;
        else if($this->type=='Direct') $receiver=$this->employeeReceiver;

        return[
            "id"=> $this->id,
            "label"=>$this->label,
            "message"=>$this->message,
            "type"=> $this->type,
            "receiver"=>$receiver,
            "is_active"=>$this->is_active,
            "status"=>$this->status,
            "end_date"=>$this->end_date
        ];
    }
}
