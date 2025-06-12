<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Enums\QueryStatus;

class Ticket extends Model
{
    protected $with = ['profile', 'employee', 'item', 'itService'];

    protected $fillable = [
        'ticket_number',
        'concern',
        'query_status',
        'request_status',
        'priority',
        'date',
    ];

    protected $casts = [
    'query_status' => QueryStatus::class,
    ];

    public static function generateTicketNumber(): string {
      $today = Carbon::now()->format('Ymd');
      $count = self::whereDate('created_at', Carbon::today())->count();
      $serial = str_pad($count + 1, 4, '0', STR_PAD_LEFT);
      return "TICK-{$today}-{$serial}";
    }

    public function profile() {
      return $this->belongsTo(Profile::class);
    }

    public function employee() {
      return $this->belongsTo(Employee::class);
    }

    public function item() {
      return $this->belongsTo(Item::class);
    }
    
    public function itService() {
      return $this->belongsTo(ItService::class);
    }
}
