<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LinkLog extends Model
{
    protected $guarded = ['id'];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
