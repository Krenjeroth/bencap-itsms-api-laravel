<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
        'concern',
        'status',
        'request_status',
        'priority',
        'date',
    ];

    public function profile() {
      return $this->belongsTo(Profile::class);
    }

    public function client() {
      return $this->belongsTo(Client::class);
    }

    public function item() {
      return $this->belongsTo(Item::class);
    }
    
    public function service() {
      return $this->belongsTo(Service::class);
    }
}
