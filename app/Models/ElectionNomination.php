<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionNomination extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function nominationRequests()
    {
        return $this->hasMany(NominationRequest::class, 'nomination_id');
    }
}
