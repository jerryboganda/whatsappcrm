<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampaignMessageEvent extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'meta_json' => 'array',
        'event_ts' => 'datetime',
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function campaignContact()
    {
        return $this->belongsTo(CampaignContact::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}

