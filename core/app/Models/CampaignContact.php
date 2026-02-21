<?php

namespace App\Models;

use App\Constants\Status;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class CampaignContact extends Model
{
    protected $guard = ['id'];

    protected $casts = [
        'send_at' => 'datetime',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'failed_at' => 'datetime',
        'responded_at' => 'datetime',
        'meta_billable' => 'boolean',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function message()
    {
        return $this->belongsTo(Message::class);
    }

    public function firstResponseMessage()
    {
        return $this->belongsTo(Message::class, 'first_response_message_id');
    }

    public function messageEvents()
    {
        return $this->hasMany(CampaignMessageEvent::class);
    }

    /**
     * specified column for export with column manipulation 
     *
     * @var array
     */
    public function exportColumns(): array
    {
        return  [
            'campaign_id' => [
                'name' => "Campaign",
                "callback" => function ($item) {
                    return $item->campaign->title;
                }
            ],
            'contact_id' => [
                'name' => "Contact",
                "callback" => function ($item) {
                    return $item->contact->mobileNumber;
                }
            ],
            'status' => [
                'name' => "Status",
                "callback" => function ($item) {
                    return strip_tags($item->statusBadge);
                }
            ],
            'send_at' => [
                'name'     => "Send At",
                "callback" => function ($item) {
                    return showDateTime($item->send_at, lang: 'en');
                }
            ],
            'created_at' => [
                'name'     => "Created At",
                "callback" => function ($item) {
                    return showDateTime($item->created_at, lang: 'en');
                }
            ],
            'updated_at' => [
                'name'     => "Updated At",
                "callback" => function ($item) {
                    return showDateTime($item->updated_at, lang: 'en');
                }
            ]
        ];
    }

    public function statusBadge(): Attribute
    {
        return new Attribute(function () {
            $html = '';
            if ($this->status == Status::CAMPAIGN_MESSAGE_NOT_SENT) {
                $html = '<span class="custom--badge badge--secondary">Not Sent</span>';
            } elseif ($this->status == Status::CAMPAIGN_MESSAGE_IS_SENT) {
                $html = '<span class="custom--badge badge--primary">Sent</span>';
            } elseif ($this->status == Status::CAMPAIGN_MESSAGE_IS_FAILED) {
                $html = '<span class="custom--badge badge--danger">Failed</span>';
            } elseif ($this->delivery_status == Status::CAMPAIGN_DELIVERY_READ) {
                $html = '<span class="custom--badge badge--success">Read</span>';
            } elseif ($this->delivery_status == Status::CAMPAIGN_DELIVERY_DELIVERED) {
                $html = '<span class="custom--badge badge--success">Delivered</span>';
            } else {
                $html = '<span class="custom--badge badge--success">Success</span>';
            }

            return $html;
        });
    }
}
