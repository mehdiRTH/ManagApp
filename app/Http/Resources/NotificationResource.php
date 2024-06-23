<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'data'=>$this->data,
            'type'=>str_replace('Notification', '', class_basename($this->type)),
            'date'=>Carbon::parse($this->created_at)->diffForHumans()
        ];
    }
}
