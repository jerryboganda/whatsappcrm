<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPaymentGateway extends Model
{
    protected $table = 'payment_gateways_user';

    protected $fillable = [
        'user_id',
        'gateway_name',
        'credentials_json',
        'status',
        'currency',
    ];

    protected $casts = [
        'credentials_json' => 'array',
        'status' => 'boolean',
    ];
}
