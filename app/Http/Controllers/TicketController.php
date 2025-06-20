<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Enums\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\TicketResource;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

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

    public function accept(Request $request, Ticket $ticket) {
        $profile = Auth::user()->profile;

        if (!$profile) {
            return response()->json(['error' => 'Profile not found.'], 404);
        }

        $alreadyAccepted = $ticket->personnel()->where('profile_id', $profile->id)->exists();

        if (!$alreadyAccepted) {
            $ticket->personnel()->attach($profile->id);

            if ($ticket->personnel()->count() === 1) {
                $ticket->update([
                    'query_status' => TicketStatus::InProgress,
                    'request_status' => TicketStatus::Accepted,
                ]);
            }
        }

        return response()->json(['message' => 'Ticket accepted successfully.']);
    }

    public function checkStock(Request $request, Ticket $ticket) {
      $ticket->update([
          'query_status' => TicketStatus::CheckingStock,
      ]);

      return new TicketResource($ticket);
    }

    public function awaitStock(Request $request, Ticket $ticket) {
      $ticket->update([
          'query_status' => TicketStatus::AwaitingStock,
      ]);

      return new TicketResource($ticket);      
    }

    public function resolve(Request $request, Ticket $ticket) {
      $ticket->update([
          'query_status' => TicketStatus::Resolved,
          'request_status' => TicketStatus::Closed,
      ]);

      return new TicketResource($ticket);
    }

    public function cancel(Request $request, Ticket $ticket) {
      $ticket->update([
          'query_status' => TicketStatus::Cancelled,
          'request_status' => TicketStatus::Closed,
      ]);

      return new TicketResource($ticket);
    }

    public function reopen(Request $request, Ticket $ticket) {
      $ticket->update([
          'query_status' => TicketStatus::InProgress,
          'request_status' => TicketStatus::Reopened,
      ]);

      return new TicketResource($ticket);
    }
}
