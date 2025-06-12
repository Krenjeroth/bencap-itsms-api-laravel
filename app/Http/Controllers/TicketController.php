<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Http\Resources\TicketResource;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request) {
      // Gate::authorize('it_service_index');

      $query = Ticket::query();

      if($request->has('search')) {
        $search = $request->search;
        $query->where(function ($q) use($search) {
          $q->where('concern', 'LIKE', "%{$search}%")
          ->orWhere('ticket_number', 'LIKE', "%{$search}%");
        });
      }

      if ($request->has('classification')) {
        $query->where('classification', $request->classification);
      }

      // Sorting (default to ID)
      if ($request->has('sort')) {
        $order = $request->input('order', 'asc');
        $query->orderBy($request->sort, $order);
      }

      // Paginate with customizable per-page count
      $tickets = $query->paginate($request->input('per_page', 5))->appends($request->query());

      return response()->json([
          'data' => TicketResource::collection($tickets),
          'meta' => [
              'total' => $tickets->total(),
              'per_page' => $tickets->perPage(),
              'current_page' => $tickets->currentPage(),
              'last_page' => $tickets->lastPage(),
          ]
      ]);
    }

    public function store(StoreTicketRequest $request) {
      // Gate::authorize('it_service_store');
      
      $data = $request->validated();

      $data['ticket_number'] = Ticket::generateTicketNumber();

      $ticket = Ticket::create($data);

      return new TicketResource($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket) {
      // Gate::authorize('it_service_update');

      $data = $request->validated();

      $ticket->update($data);

      return new TicketResource($ticket);
    }

    public function destroy(Ticket $ticket) {
      // Gate::authorize('it_service_destroy');

      $ticket->delete();
      
      return new TicketResource($ticket);
    }
}
