<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $guarded = [];

    public function voters()
    {
        return $this->hasMany(ElectionVoter::class);
    }

    public function votes()
    {
        return $this->hasMany(ElectionVote::class);
    }

}
