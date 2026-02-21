<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignMetaAnalyticsSnapshot extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'payload_json' => 'array',
        'date_start' => 'datetime',
        'date_end' => 'datetime',
        'fetched_at' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}

