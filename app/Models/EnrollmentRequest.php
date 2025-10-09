<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EnrollmentRequest extends Model
{
   protected $fillable = [
        'user_id',
        'user_become_status',
        'status',
        'reason',
    ];

    protected $visible = [
        'user_id',
        'user_become_status',
        'status',
        'reason',
    ];

    protected $editable = [
        'user_id',
        'user_become_status',
        'status',
        'reason',
    ];

    /**
     * Get the user that owns the enrollment request.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
