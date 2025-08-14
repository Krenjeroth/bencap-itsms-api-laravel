<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'display_name',
        'name',
        'designation',
        'status',
        'status_text',
        'engagement',
        'gender',
        'img_path',
    ];

    const STATUS_ONLINE = 'online';
    const STATUS_OFFLINE = 'offline';
    const STATUS_BUSY = 'busy';

    public function user() {
      return $this->belongsTo(User::class);
    }

    // public function tickets() {
    //   return $this->belongsToMany(Ticket::class);
    // }

    public function ticketPersonnel() {
      return $this->belongsToMany(Ticket::class, 'ticket_personnel');
    }

    public function solutions() {
      return $this->hasMany(Solution::class, 'author_id');
    }

}
