<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExtractionSession extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'expires_at' => 'datetime',
        'attested_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(GroupExtractionJob::class, 'session_id');
    }

    public function nonces()
    {
        return $this->hasMany(GroupExtractionApiNonce::class, 'session_id');
    }
}

