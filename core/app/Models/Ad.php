<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'analytics_json' => 'array',
    ];

    public function account()
    {
        return $this->belongsTo(AdAccount::class, 'ad_account_id');
    }
}
