<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItServiceResource;
use App\Enums\TicketStatus;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hasAccepted = $this->personnel->contains($request->user()->profile_id);
        return [
          'id' => $this->id,
          'profile' => ProfileResource::make($this->whenLoaded('profile')),
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'item' => ItemResource::make($this->whenLoaded('item')),
          'it_service' => ItServiceResource::make($this->whenLoaded('itService')),
          // 'assignees' => ProfileResource::collection($this->whenLoaded('assignees')),
          'personnel' => ProfileResource::collection($this->whenLoaded('personnel')),
          'ticket_number' => $this->ticket_number,
          'concern' => $this->concern,
          'query_status' => $this->query_status,
          'request_status' => $this->request_status,
          'priority' => $this->priority,
          'date' => $this->date,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'is_accepted_by_me' => $hasAccepted,
          'can_accept' => in_array($this->query_status, [
                    TicketStatus::Queued,
                    TicketStatus::InProgress,
                    TicketStatus::CheckingStock,
                    TicketStatus::AwaitingStock,
                    TicketStatus::AwaitingUser,
                    TicketStatus::AwaitingVendor
                ])
                && $this->request_status === TicketStatus::Open
                && !$hasAccepted,
        ];
    }
}
