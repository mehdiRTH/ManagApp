<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OffRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id'=>$this->id,
            'user'=>$this->user,
            'label'=>$this->label,
            'description'=>$this->description,
            'type'=>$this->type,
            'duration'=>$this->duration,
            'justification'=>$this->type=="Files" ? json_decode($this->justification) :$this->justification,
            'status'=>$this->status,
            'created_at'=>$this->created_at->format('Y-m-d H:m'),
            'status_answer'=>$this->status_answer,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date
        ];
    }
}
