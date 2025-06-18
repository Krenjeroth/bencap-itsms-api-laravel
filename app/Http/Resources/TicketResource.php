<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItServiceResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'profile' => ProfileResource::make($this->whenLoaded('profile')),
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'item' => ItemResource::make($this->whenLoaded('item')),
          'it_service' => ItServiceResource::make($this->whenLoaded('itService')),
          'ticket_number' => $this->ticket_number,
          'concern' => $this->concern,
          'query_status' => $this->query_status,
          'request_status' => $this->request_status,
          'priority' => $this->priority,
          'date' => $this->date,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ];
    }
}
