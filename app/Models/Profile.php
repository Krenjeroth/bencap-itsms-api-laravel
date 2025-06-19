<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'display_name',
        'designation',
        'status',
        'status_text',
        'engagement',
        'img_path',
    ];

    public function user() {
      return $this->belongsTo(User::class);
    }

    // public function tickets() {
    //   return $this->belongsToMany(Ticket::class);
    // }

    public function assignedTickets() {
      return $this->belongsToMany(Ticket::class, 'ticket_assignees');
    }
}
