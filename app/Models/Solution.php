<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solution extends Model
{

    protected $with = ['tickets', 'author'];

    protected $fillable = [
        'description',
        'author_id',
    ];

    public function tickets() {
        return $this->hasMany(Ticket::class);
    }

    public function author() {
        return $this->belongsTo(Profile::class, 'author_id');
    }
}
