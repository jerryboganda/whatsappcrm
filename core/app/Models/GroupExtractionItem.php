<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupExtractionItem extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'processing_meta_json' => 'array',
    ];

    public function job()
    {
        return $this->belongsTo(GroupExtractionJob::class, 'job_id');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}

