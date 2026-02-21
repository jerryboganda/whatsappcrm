<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use App\Models\AdAccount;
use FacebookAds\Api;
use FacebookAds\Object\AdAccount as FbAdAccount;
use FacebookAds\Object\Campaign as FbCampaign;
use FacebookAds\Object\AdSet as FbAdSet;
use FacebookAds\Object\Ad as FbAd;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\Fields\AdSetFields;
use FacebookAds\Object\Values\CampaignObjectiveValues;
use FacebookAds\Object\Values\AdSetBillingEventValues;
use FacebookAds\Object\Values\AdSetOptimizationGoalValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MetaAdsController extends Controller
{
    public function index()
    {
        $pageTitle = "Meta Ads Dashboard";
        $adAccounts = AdAccount::where('user_id', getParentUser()->id)->get();
        // Fetch ads from local DB for now, syncing can be a background job
        $ads = Ad::where('user_id', getParentUser()->id)->with('account')->latest()->paginate(10);

        return view('Template::user.ads.index', compact('pageTitle', 'adAccounts', 'ads'));
    }

    public function connect()
    {
        $pageTitle = "Connect Ad Account";
        return view('Template::user.ads.connect', compact('pageTitle'));
    }

    public function storeAccount(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'account_id' => 'required',
            'access_token' => 'required',
        ]);

        $user = getParentUser();

        // Validate Token with Meta API (Mocking if needed, but best to try)
        try {
            Api::init(null, null, $request->access_token);
            $account = new FbAdAccount('act_' . str_replace('act_', '', $request->account_id));
            $account->read(['name', 'currency', 'timezone_name']);
        } catch (\Exception $e) {
            $notify[] = ['error', 'Invalid Ad Account ID or Token: ' . $e->getMessage()];
            return back()->withNotify($notify)->withInput();
        }

        AdAccount::updateOrCreate(
            ['user_id' => $user->id, 'account_id' => $request->account_id],
            [
                'name' => $request->name,
                'access_token' => $request->access_token,
                'currency' => 'USD', // Should come from API
                'timezone' => 'UTC' // Should come from API
            ]
        );

        $notify[] = ['success', 'Ad Account Connected Successfully'];
        return redirect()->route('user.ads.index')->withNotify($notify);
    }

    public function create()
    {
        $pageTitle = "Create CTWA Ad";
        $adAccounts = AdAccount::where('user_id', getParentUser()->id)->get();
        if ($adAccounts->isEmpty()) {
            $notify[] = ['error', 'Please connect an Ad Account first'];
            return redirect()->route('user.ads.connect')->withNotify($notify);
        }
        return view('Template::user.ads.create', compact('pageTitle', 'adAccounts'));
    }

    public function storeAd(Request $request)
    {
        $request->validate([
            'ad_account_id' => 'required',
            'campaign_name' => 'required',
            'daily_budget' => 'required|numeric|min:1',
            'media_url' => 'required|url',
            'primary_text' => 'required',
            'headline' => 'required',
        ]);

        $user = getParentUser();
        $accountDb = AdAccount::where('user_id', $user->id)->findOrFail($request->ad_account_id);

        try {
            Api::init(null, null, $accountDb->access_token);
            $accountId = 'act_' . str_replace('act_', '', $accountDb->account_id);
            $account = new FbAdAccount($accountId);

            // 1. Create Campaign
            $campaign = $account->createCampaign([], [
                CampaignFields::NAME => $request->campaign_name,
                CampaignFields::OBJECTIVE => 'OUTCOME_TRAFFIC', // Simplified for CTWA
                CampaignFields::SPECIAL_AD_CATEGORIES => [],
                CampaignFields::STATUS => 'PAUSED', // Create as paused for safety
            ]);

            // 2. Create Ad Set
            $adSet = $account->createAdSet([], [
                AdSetFields::NAME => $request->campaign_name . ' - Set',
                AdSetFields::CAMPAIGN_ID => $campaign->id,
                AdSetFields::DAILY_BUDGET => $request->daily_budget * 100, // Cents
                AdSetFields::BILLING_EVENT => AdSetBillingEventValues::IMPRESSIONS,
                AdSetFields::OPTIMIZATION_GOAL => AdSetOptimizationGoalValues::LINK_CLICKS,
                AdSetFields::TARGETING => [
                    'geo_locations' => ['countries' => ['US']], // Default test
                ],
                AdSetFields::STATUS => 'PAUSED',
                AdSetFields::DESTINATION_TYPE => 'WEBSITE', // Simplified
            ]);

            // 3. Create Creative (simplified image)
            $creative = $account->createAdCreative([], [
                'name' => $request->campaign_name . ' - Creative',
                'object_story_spec' => [
                    'page_id' => '<PAGE_ID_REQUIRED>', // This is a blocker without Page ID in DB
                    'link_data' => [
                        'image_hash' => '<IMAGE_HASH>', // Need to upload image first
                        'link' => 'https://wa.me/' . $user->mobile, // CTWA Link
                        'message' => $request->primary_text,
                        'call_to_action' => [
                            'type' => 'SEND_WHATSAPP_MESSAGE', // Key for CTWA
                            'value' => [
                                'app_destination' => 'WHATSAPP_MESSENGER',
                            ]
                        ]
                    ]
                ]
            ]);

            // 4. Create Ad
            $ad = $account->createAd([], [
                'name' => $request->campaign_name . ' - Ad',
                'adset_id' => $adSet->id,
                'creative' => ['creative_id' => $creative->id],
                'status' => 'PAUSED',
            ]);

            // Store Local
            Ad::create([
                'user_id' => $user->id,
                'ad_account_id' => $accountDb->id,
                'name' => $request->campaign_name,
                'campaign_id' => $campaign->id,
                'ad_set_id' => $adSet->id,
                'ad_id' => $ad->id,
                'status' => 'PAUSED',
                'budget' => $request->daily_budget
            ]);

            $notify[] = ['success', 'Ad Created Successfully on Meta!'];
            return redirect()->route('user.ads.index')->withNotify($notify);

        } catch (\Exception $e) {
            Log::error("Meta Ad Error: " . $e->getMessage());
            $notify[] = ['error', 'Meta API Error: ' . $e->getMessage()];
            return back()->withNotify($notify)->withInput();
        }
    }
}
