<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ElectionVoter extends Model
{
    protected $guarded = [];

    public function election()
    {
        return $this->belongsTo(Election::class);
    }
}
