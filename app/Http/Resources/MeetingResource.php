<?php

namespace App\Http\Resources;

use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $date1 = new DateTime($this->start_date);
        $date2 = new DateTime($this->end_date);
        return [
            'id'=>$this->id,
            'created_by'=>new UserResource($this->whenLoaded('createdBy')),
            'responsible'=>new UserResource($this->whenLoaded('responsible')),
            'participants'=>UserResource::collection($this->participants),
            'participants_id'=>$this->participants_id,
            'start_date'=>$this->start_date,
            'end_date'=>$this->end_date,
            'description'=>$this->description,
            'diff'=>$date2->diff($date1)
        ];
    }
}
