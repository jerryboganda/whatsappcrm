<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSourceEvent extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'meta_json' => 'array',
        'captured_at' => 'datetime',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

