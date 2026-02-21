@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.ads.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <!-- Left Side: Campaign Settings -->
                            <div class="col-md-6 border-end">
                                <h5 class="mb-3">@lang('Campaign Settings')</h5>

                                <div class="form-group">
                                    <label>@lang('Select Ad Account')</label>
                                    <select name="ad_account_id" class="form-control" required>
                                        @foreach($adAccounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }} ({{ $account->account_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Campaign Name')</label>
                                    <input type="text" name="campaign_name" class="form-control" required
                                        placeholder="e.g. Summer Sale Promo">
                                </div>

                                <div class="form-group">
                                    <label>@lang('Daily Budget') ({{ $adAccounts->first()->currency ?? 'USD' }})</label>
                                    <input type="number" name="daily_budget" class="form-control" required min="1"
                                        step="0.01">
                                </div>

                                <div class="form-group">
                                    <label>@lang('Facebook Page ID')</label>
                                    <input type="text" name="page_id" class="form-control" required placeholder="1042...">
                                    <small
                                        class="text-muted">@lang('The Page ID to run ads from. Must be connected to this Ad Account')</small>
                                </div>
                            </div>

                            <!-- Right Side: Creative -->
                            <div class="col-md-6">
                                <h5 class="mb-3">@lang('Ad Creative')</h5>

                                <div class="form-group">
                                    <label>@lang('Media Image URL')</label>
                                    <input type="url" name="media_url" class="form-control" required
                                        placeholder="https://...">
                                    <small class="text-muted">@lang('Direct link to image (jpg/png).')</small>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Primary Text')</label>
                                    <textarea name="primary_text" class="form-control" rows="3" required
                                        placeholder="Chat with us on WhatsApp for exclusive deals!"></textarea>
                                </div>

                                <div class="form-group">
                                    <label>@lang('Headline')</label>
                                    <input type="text" name="headline" class="form-control" required
                                        placeholder="Chat on WhatsApp">
                                </div>

                                <div class="alert alert-info py-2">
                                    <small><i class="las la-info-circle"></i> @lang('Call to Action will be set to: ')
                                        <strong>@lang('Send WhatsApp Message')</strong></small>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn--primary h-45 px-5">@lang('Launch Ad') <i
                                        class="las la-rocket ms-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection