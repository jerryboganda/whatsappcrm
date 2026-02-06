<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'conversation_id',
        'amount',
        'currency',
        'status',
        'products_json',
    ];

    protected $casts = [
        'products_json' => 'array',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
