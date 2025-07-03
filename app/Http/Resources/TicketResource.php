<?php

namespace App\Http\Resources;

use App\Enums\TicketStatus;
use App\Enums\ServiceMethod;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\ItServiceResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SolutionResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $hasAccepted = $this->personnel->contains(Auth::user()->profile->id);

        return [
          'id' => $this->id,
          'profile' => ProfileResource::make($this->whenLoaded('profile')),
          'employee' => EmployeeResource::make($this->whenLoaded('employee')),
          'item' => ItemResource::make($this->whenLoaded('item')),
          'item_type' => ItemTypeResource::make($this->whenLoaded('item_type')),
          'it_service' => ItServiceResource::make($this->whenLoaded('itService')),
          'personnel' => ProfileResource::collection($this->whenLoaded('personnel')),
          'solution' => SolutionResource::make($this->whenLoaded('solution')),
          'ticket_number' => $this->ticket_number,
          'concern' => $this->concern,
          'query_status' => $this->query_status,
          'request_status' => $this->request_status,
          'priority' => $this->priority,
          'service_method' => $this->service_method,
          'service_method_formatted' => match ($this->service_method) {
              ServiceMethod::OnSite => 'On site',
              ServiceMethod::PulledOut => 'Pulled out',
              default => null,
          },
          'date' => $this->date,
          'released_at' => $this->released_at,
          'contact_number' => $this->contact_number,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'is_accepted_by_me' => $hasAccepted,
          'can_accept' => in_array($this->query_status, [
                    TicketStatus::Queued,
                    TicketStatus::InProgress,
                    TicketStatus::CheckingStock,
                    TicketStatus::AwaitingPart,
                    TicketStatus::AwaitingUser,
                    TicketStatus::AwaitingVendor
                ])
                && !$hasAccepted,
        ];
    }
}
