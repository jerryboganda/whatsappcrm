@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title">{{ __(@$pageTitle) }}</h5>
                <p class="container-top__desc">@lang('Configure your payment gateway credentials to generate payment links')
                </p>
            </div>
        </div>
        <div class="dashboard-container__body dis-block">
            <div class="row gy-4">
                {{-- Stripe --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg--primary text-white">
                            <h5 class="card-title m-0 p-2 text-white">@lang('Stripe Configuration')</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.payment.config.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="gateway_name" value="stripe">
                                <div class="form-group">
                                    <label>@lang('Enable Stripe')</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @checked(@$stripe->status)>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Publishable Key')</label>
                                    <input type="text" class="form--control" name="stripe_publishable_key"
                                        value="{{ @$stripe->credentials_json['publishable_key'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Secret Key')</label>
                                    <input type="text" class="form--control" name="stripe_secret_key"
                                        value="{{ @$stripe->credentials_json['secret_key'] }}" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Save Stripe Settings')</button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Razorpay --}}
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg--warning text-white">
                            <h5 class="card-title m-0 p-2 text-white">@lang('Razorpay Configuration')</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('user.payment.config.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="gateway_name" value="razorpay">
                                <div class="form-group">
                                    <label>@lang('Enable Razorpay')</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            @checked(@$razorpay->status)>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Key ID')</label>
                                    <input type="text" class="form--control" name="razorpay_key_id"
                                        value="{{ @$razorpay->credentials_json['key_id'] }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Key Secret')</label>
                                    <input type="text" class="form--control" name="razorpay_key_secret"
                                        value="{{ @$razorpay->credentials_json['key_secret'] }}" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100">@lang('Save Razorpay Settings')</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection