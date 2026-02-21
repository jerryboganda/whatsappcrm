<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExtractionApiNonce extends Model
{
    protected $guarded = ['id'];

    public function session()
    {
        return $this->belongsTo(GroupExtractionSession::class, 'session_id');
    }
}

