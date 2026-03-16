<?php

namespace App\Models;

use App\Traits\ApiQuery;
use Illuminate\Database\Eloquent\Model;

class ContactTag extends Model
{
    use ApiQuery;

    protected $fillable = [
        'user_id',
        'name',
        'created_at',
        'updated_at',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_tag_contacts');
    }
}
