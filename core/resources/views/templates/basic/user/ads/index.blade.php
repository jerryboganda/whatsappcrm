@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Account')</th>
                                    <th>@lang('Budget')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Meta Campaign ID')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ads as $ad)
                                    <tr>
                                        <td data-label="@lang('Name')">
                                            <span class="fw-bold">{{ __($ad->name) }}</span>
                                        </td>
                                        <td data-label="@lang('Account')">
                                            {{ __($ad->account->name) }}
                                        </td>
                                        <td data-label="@lang('Budget')">
                                            {{ showAmount($ad->budget) }}
                                        </td>
                                        <td data-label="@lang('Status')">
                                            @if($ad->status == 'ACTIVE')
                                                <span class="badge badge--success">@lang('Active')</span>
                                            @elseif($ad->status == 'PAUSED')
                                                <span class="badge badge--warning">@lang('Paused')</span>
                                            @else
                                                <span class="badge badge--dark">{{ $ad->status }}</span>
                                            @endif
                                        </td>
                                        <td data-label="@lang('Meta Campaign ID')">
                                            {{ $ad->campaign_id }}
                                        </td>
                                        <td data-label="@lang('Action')">
                                            <a href="https://adsmanager.facebook.com/adsmanager/manage/campaigns?act={{ $ad->account->account_id }}"
                                                target="_blank" class="btn btn-sm btn--primary">
                                                <i class="las la-external-link-alt"></i> @lang('View in Meta')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
                @if($ads->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($ads) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('user.ads.connect') }}" class="btn btn-outline--info btn--sm h-45 me-2">
        <i class="las la-plug"></i> @lang('Connect Account')
    </a>
    <a href="{{ route('user.ads.create') }}" class="btn btn-sm btn--primary h-45">
        <i class="las la-plus"></i> @lang('Create Ad')
    </a>
@endpush