<?php

namespace App\Services;

use App\Constants\Status;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignMessageEvent;
use App\Models\CampaignMetaAnalyticsSnapshot;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CampaignReportAnalyticsService
{
    public function getReport(Campaign $campaign, array $filters = []): array
    {
        $from = $this->parseFilterDate($filters['from'] ?? null, true);
        $to = $this->parseFilterDate($filters['to'] ?? null, false);
        $tz = $filters['tz'] ?? config('app.timezone');

        $touchToken = $this->getTouchToken($campaign->id);
        $cacheKey = 'campaign_report_analytics:' . $campaign->id . ':' . md5(json_encode([
            'from' => optional($from)->toDateTimeString(),
            'to' => optional($to)->toDateTimeString(),
            'tz' => $tz,
            'touch' => $touchToken,
        ]));

        return Cache::remember($cacheKey, 300, function () use ($campaign, $from, $to) {
            return $this->buildReport($campaign, $from, $to);
        });
    }

    private function buildReport(Campaign $campaign, ?Carbon $from, ?Carbon $to): array
    {
        $contactsQuery = CampaignContact::where('campaign_id', $campaign->id);
        $contactsQuery = $this->applyDateFilter($contactsQuery, $from, $to);

        $targeted = (int) $contactsQuery->count();
        if ($targeted === 0) {
            $targeted = (int) $campaign->total_message;
        }

        $apiAttempted = (int) (clone $contactsQuery)->where(function ($query) {
            $query->where('status', '!=', Status::CAMPAIGN_MESSAGE_NOT_SENT)
                ->orWhereNotNull('message_id')
                ->orWhereNotNull('whatsapp_message_id');
        })->count();

        $apiAccepted = (int) (clone $contactsQuery)->where(function ($query) {
            $query->whereNotNull('message_id')->orWhereNotNull('whatsapp_message_id');
        })->count();

        $queued = (int) (clone $contactsQuery)->where('status', Status::CAMPAIGN_MESSAGE_NOT_SENT)->count();

        $sent = (int) (clone $contactsQuery)->where(function ($query) {
            $query->whereNotNull('sent_at')
                ->orWhereIn('delivery_status', [
                    Status::CAMPAIGN_DELIVERY_SENT,
                    Status::CAMPAIGN_DELIVERY_DELIVERED,
                    Status::CAMPAIGN_DELIVERY_READ,
                    Status::CAMPAIGN_DELIVERY_FAILED,
                ]);
        })->count();

        $delivered = (int) (clone $contactsQuery)->where(function ($query) {
            $query->whereNotNull('delivered_at')
                ->orWhereIn('delivery_status', [
                    Status::CAMPAIGN_DELIVERY_DELIVERED,
                    Status::CAMPAIGN_DELIVERY_READ,
                ]);
        })->count();

        $read = (int) (clone $contactsQuery)->where(function ($query) {
            $query->whereNotNull('read_at')
                ->orWhere('delivery_status', Status::CAMPAIGN_DELIVERY_READ);
        })->count();

        $failed = (int) (clone $contactsQuery)->where(function ($query) {
            $query->where('status', Status::CAMPAIGN_MESSAGE_IS_FAILED)
                ->orWhere('delivery_status', Status::CAMPAIGN_DELIVERY_FAILED);
        })->count();

        $pendingDelivery = max($apiAccepted - $delivered - $failed, 0);
        $replied = (int) (clone $contactsQuery)->whereNotNull('responded_at')->count();
        $clicked = $this->getUniqueClickers($campaign, $from, $to);

        $firstResponseDurations = $this->pluckDurationSeconds(
            (clone $contactsQuery)->whereNotNull('responded_at')->whereNotNull('sent_at'),
            'sent_at',
            'responded_at'
        );

        $sendToDeliverDurations = $this->pluckDurationSeconds(
            (clone $contactsQuery)->whereNotNull('delivered_at')->whereNotNull('sent_at'),
            'sent_at',
            'delivered_at'
        );

        $deliverToReadDurations = $this->pluckDurationSeconds(
            (clone $contactsQuery)->whereNotNull('read_at')->whereNotNull('delivered_at'),
            'delivered_at',
            'read_at'
        );

        $failureBreakdown = (clone $contactsQuery)
            ->where(function ($query) {
                $query->where('delivery_status', Status::CAMPAIGN_DELIVERY_FAILED)
                    ->orWhere('status', Status::CAMPAIGN_MESSAGE_IS_FAILED);
            })
            ->selectRaw('COALESCE(meta_error_code, "unknown") AS error_code, COALESCE(meta_error_title, "Unknown Error") AS error_title, COUNT(*) AS total')
            ->groupBy('error_code', 'error_title')
            ->orderByDesc('total')
            ->get();

        $timeline = $this->buildTimeline($campaign->id, $from, $to);
        $metaEstimated = $this->latestMetaSnapshots($campaign->id);

        return [
            'legacy_mode' => (int) ($campaign->analytics_version ?? 1) < 2,
            'summary' => [
                'targeted' => $targeted,
                'queued' => $queued,
                'api_attempted' => $apiAttempted,
                'api_accepted' => $apiAccepted,
                'sent' => $sent,
                'delivered' => $delivered,
                'read' => $read,
                'failed' => $failed,
                'pending_delivery' => $pendingDelivery,
            ],
            'engagement' => [
                'replied' => $replied,
                'clicked' => $clicked,
                'reply_rate' => $this->percentage($replied, $delivered),
                'ctr' => $this->percentage($clicked, $delivered),
                'opened_rate' => $this->percentage($read, $delivered),
                'delivery_rate' => $this->percentage($delivered, $targeted),
                'avg_first_response_seconds' => $this->average($firstResponseDurations),
                'median_first_response_seconds' => $this->median($firstResponseDurations),
                'avg_send_to_deliver_seconds' => $this->average($sendToDeliverDurations),
                'avg_deliver_to_read_seconds' => $this->average($deliverToReadDurations),
            ],
            'failures' => [
                'breakdown' => $failureBreakdown,
            ],
            'timeline' => $timeline,
            'meta_estimated' => $metaEstimated,
        ];
    }

    private function buildTimeline(int $campaignId, ?Carbon $from, ?Carbon $to): array
    {
        $query = CampaignMessageEvent::where('campaign_id', $campaignId)->whereNotNull('event_ts');
        if ($from) {
            $query->where('event_ts', '>=', $from);
        }
        if ($to) {
            $query->where('event_ts', '<=', $to);
        }

        $rows = $query->selectRaw('DATE(event_ts) AS event_date, event_type, COUNT(*) AS total')
            ->groupBy('event_date', 'event_type')
            ->orderBy('event_date')
            ->get();

        $daily = [];
        foreach ($rows as $row) {
            if (!isset($daily[$row->event_date])) {
                $daily[$row->event_date] = [
                    'event_date' => $row->event_date,
                    'sent' => 0,
                    'delivered' => 0,
                    'read' => 0,
                    'failed' => 0,
                    'replied' => 0,
                    'api_accepted' => 0,
                ];
            }
            $eventType = (string) $row->event_type;
            if (array_key_exists($eventType, $daily[$row->event_date])) {
                $daily[$row->event_date][$eventType] = (int) $row->total;
            }
        }

        return [
            'daily' => array_values($daily),
        ];
    }

    private function latestMetaSnapshots(int $campaignId): array
    {
        $snapshots = CampaignMetaAnalyticsSnapshot::where('campaign_id', $campaignId)
            ->orderByDesc('fetched_at')
            ->get()
            ->groupBy('source_type')
            ->map(function (Collection $items) {
                return $items->first();
            })
            ->values();

        return $snapshots->toArray();
    }

    private function getUniqueClickers(Campaign $campaign, ?Carbon $from, ?Carbon $to): int
    {
        $query = $campaign->linkLogs()->distinct('contact_id');
        if ($from) {
            $query->where('created_at', '>=', $from);
        }
        if ($to) {
            $query->where('created_at', '<=', $to);
        }
        return (int) $query->count();
    }

    private function pluckDurationSeconds($query, string $startColumn, string $endColumn): array
    {
        return $query->selectRaw("TIMESTAMPDIFF(SECOND, {$startColumn}, {$endColumn}) AS duration_seconds")
            ->pluck('duration_seconds')
            ->map(function ($value) {
                return (int) $value;
            })
            ->filter(function ($value) {
                return $value >= 0;
            })
            ->values()
            ->all();
    }

    private function percentage(int $value, int $total): float
    {
        if ($total <= 0) {
            return 0.0;
        }
        return round(($value / $total) * 100, 2);
    }

    private function average(array $numbers): int
    {
        if (count($numbers) === 0) {
            return 0;
        }
        return (int) round(array_sum($numbers) / count($numbers));
    }

    private function median(array $numbers): int
    {
        if (count($numbers) === 0) {
            return 0;
        }

        sort($numbers);
        $count = count($numbers);
        $middle = intdiv($count, 2);

        if ($count % 2 === 0) {
            return (int) round(($numbers[$middle - 1] + $numbers[$middle]) / 2);
        }

        return (int) $numbers[$middle];
    }

    private function applyDateFilter($query, ?Carbon $from, ?Carbon $to)
    {
        if ($from) {
            $query->where(function ($subQuery) use ($from) {
                $subQuery->where('send_at', '>=', $from)
                    ->orWhere('created_at', '>=', $from);
            });
        }
        if ($to) {
            $query->where(function ($subQuery) use ($to) {
                $subQuery->where('send_at', '<=', $to)
                    ->orWhere('created_at', '<=', $to);
            });
        }

        return $query;
    }

    private function parseFilterDate(?string $date, bool $start): ?Carbon
    {
        if (!$date) {
            return null;
        }

        try {
            $parsed = Carbon::parse($date);
            return $start ? $parsed->startOfDay() : $parsed->endOfDay();
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function getTouchToken(int $campaignId): string
    {
        $contactTouch = CampaignContact::where('campaign_id', $campaignId)->max('updated_at');
        $eventTouch = CampaignMessageEvent::where('campaign_id', $campaignId)->max('updated_at');
        $snapshotTouch = CampaignMetaAnalyticsSnapshot::where('campaign_id', $campaignId)->max('updated_at');

        return implode('|', [
            (string) ($contactTouch ?? ''),
            (string) ($eventTouch ?? ''),
            (string) ($snapshotTouch ?? ''),
        ]);
    }
}
