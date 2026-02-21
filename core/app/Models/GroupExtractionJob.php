<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExtractionJob extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'error_json' => 'array',
        'meta_json' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function session()
    {
        return $this->belongsTo(GroupExtractionSession::class, 'session_id');
    }

    public function items()
    {
        return $this->hasMany(GroupExtractionItem::class, 'job_id');
    }

    public function contactList()
    {
        return $this->belongsTo(ContactList::class, 'contact_list_id');
    }
}

