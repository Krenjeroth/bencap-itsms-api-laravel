<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{

    protected $with = ['roles.permissions'];
    
    protected $fillable = [
        'title',
    ];

    public function roles() {
      return $this->belongsToMany(Role::class);
    }
}
