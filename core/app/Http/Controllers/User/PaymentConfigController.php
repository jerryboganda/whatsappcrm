<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserPaymentGateway;
use Illuminate\Http\Request;

class PaymentConfigController extends Controller
{
    public function index()
    {
        $pageTitle = 'Payment Settings';
        $stripe = UserPaymentGateway::where('user_id', auth()->id())->where('gateway_name', 'stripe')->first();
        $razorpay = UserPaymentGateway::where('user_id', auth()->id())->where('gateway_name', 'razorpay')->first();
        return view('Template::user.payment.config', compact('pageTitle', 'stripe', 'razorpay'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'gateway_name' => 'required|in:stripe,razorpay',
            'status' => 'required|boolean',
            'stripe_publishable_key' => 'required_if:gateway_name,stripe',
            'stripe_secret_key' => 'required_if:gateway_name,stripe',
            'razorpay_key_id' => 'required_if:gateway_name,razorpay',
            'razorpay_key_secret' => 'required_if:gateway_name,razorpay',
        ]);

        $gateway = UserPaymentGateway::firstOrNew([
            'user_id' => auth()->id(),
            'gateway_name' => $request->gateway_name
        ]);

        $credentials = [];
        if ($request->gateway_name == 'stripe') {
            $credentials = [
                'publishable_key' => $request->stripe_publishable_key,
                'secret_key' => $request->stripe_secret_key,
            ];
        } elseif ($request->gateway_name == 'razorpay') {
            $credentials = [
                'key_id' => $request->razorpay_key_id,
                'key_secret' => $request->razorpay_key_secret,
            ];
        }

        $gateway->credentials_json = $credentials;
        $gateway->status = $request->status;
        $gateway->save();

        $notify[] = ['success', ucfirst($request->gateway_name) . ' settings updated successfully'];
        return back()->withNotify($notify);
    }

    public function generateLink(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|size:3',
            'gateway' => 'required|in:stripe,razorpay',
            'description' => 'required|string|max:255',
        ]);

        $gateway = UserPaymentGateway::where('user_id', auth()->id())
            ->where('gateway_name', $request->gateway)
            ->where('status', 1)
            ->first();

        if (!$gateway) {
            return response()->json(['error' => 'Payment gateway not configured or disabled'], 400);
        }

        $service = new \App\Lib\Payment\PaymentLinkService();
        $link = null;

        try {
            if ($request->gateway == 'stripe') {
                $credentials = $gateway->credentials_json;
                $successUrl = route('user.home');
                $cancelUrl = route('user.home');

                $link = $service->generateStripeLink(
                    $credentials['secret_key'],
                    $request->amount,
                    $request->currency,
                    $request->description,
                    $successUrl,
                    $cancelUrl
                );
            } elseif ($request->gateway == 'razorpay') {
                $credentials = $gateway->credentials_json;
                $callbackUrl = route('user.home');

                $link = $service->generateRazorpayLink(
                    $credentials['key_id'],
                    $credentials['key_secret'],
                    $request->amount,
                    $request->currency,
                    $request->description,
                    $callbackUrl
                );
            }

            if (isset($link['success']) && !$link['success']) {
                throw new \Exception($link['message'] ?? 'Failed to generate link');
            }

            return response()->json(['success' => true, 'link' => $link['url']]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
