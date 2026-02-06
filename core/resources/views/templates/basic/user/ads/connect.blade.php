@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('user.ads.store_account') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Account Name')</label>
                            <input type="text" name="name" class="form-control" required placeholder="My Agency Account">
                        </div>
                        <div class="form-group">
                            <label>@lang('Ad Account ID')</label>
                            <input type="text" name="account_id" class="form-control" required placeholder="act_123456789">
                            <small class="text-muted">Find this in your Facebook Ads Manager URL (&act=...)</small>
                        </div>
                        <div class="form-group">
                            <label>@lang('Access Token')</label>
                            <textarea name="access_token" class="form-control" rows="4" required
                                placeholder="EAA..."></textarea>
                            <small class="text-muted">Generate a System User Token with 'ads_management' permission in
                                Business Settings.</small>
                        </div>
                        <button type="submit" class="btn btn--primary w-100 h-45">@lang('Connect Account')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection