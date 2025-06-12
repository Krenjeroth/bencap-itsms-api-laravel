<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
          'ticket_number' => $this->ticket_number,
          // 'concern' => $this->concern,
          // 'query_status' => $this->query_status,
          // 'request_status' => $this->request_status,
          // 'priority' => $this->priority,
          // 'date' => $this->date,
          // 'created_at' => $this->created_at,
          // 'updated_at' => $this->updated_at,
        ];
    }
}
