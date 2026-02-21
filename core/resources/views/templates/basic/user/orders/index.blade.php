@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title">{{ __(@$pageTitle) }}</h5>
                <p class="container-top__desc">@lang('Manage your incoming WhatsApp orders')</p>
            </div>
        </div>
        <div class="dashboard-container__body">

            <div class="row align-items-center mb-30 justify-content-end">
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form--control"
                                value="{{ request()->search }}" placeholder="@lang('Search by Order ID, Name, Mobile')">
                            <select name="status" class="form-control form--control input-group-text">
                                <option value="">@lang('All Status')</option>
                                <option value="pending" @selected(request()->status == 'pending')>@lang('Pending')</option>
                                <option value="paid" @selected(request()->status == 'paid')>@lang('Paid')</option>
                                <option value="shipped" @selected(request()->status == 'shipped')>@lang('Shipped')</option>
                                <option value="completed" @selected(request()->status == 'completed')>@lang('Completed')
                                </option>
                            </select>
                            <button class="btn btn--base" type="submit"><i class="las la-search"></i></button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="dashboard-table">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th>@lang('Order ID')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Contact')</th>
                            <th>@lang('Products')</th>
                            <th>@lang('Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>#{{ $order->id }}</td>
                                <td>
                                    {{ showDateTime($order->created_at) }}<br>{{ diffForHumans($order->created_at) }}
                                </td>
                                <td>
                                    {{ @$order->contact->firstname }} <br>
                                    <small>{{ @$order->contact->mobile }}</small>
                                </td>
                                <td>
                                    {{ count($order->products_json ?? []) }} @lang('Items')
                                </td>
                                <td>
                                    {{ $order->currency }} {{ getAmount($order->amount) }}
                                </td>
                                <td>
                                    @if($order->status == 'pending')
                                        <span class="badge badge--warning">@lang('Pending')</span>
                                    @elseif($order->status == 'paid')
                                        <span class="badge badge--success">@lang('Paid')</span>
                                    @elseif($order->status == 'shipped')
                                        <span class="badge badge--primary">@lang('Shipped')</span>
                                    @elseif($order->status == 'completed')
                                        <span class="badge badge--dark">@lang('Completed')</span>
                                    @else
                                        <span class="badge badge--secondary">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.orders.details', $order->id) }}"
                                        class="btn btn--primary btn--sm btn-shadow me-2">
                                        <i class="las la-desktop"></i> @lang('Details')
                                    </a>
                                    <button class="btn btn--base btn-shadow btn--sm statusBtn" data-id="{{ $order->id }}"
                                        data-status="{{ $order->status }}">
                                        <i class="las la-edit"></i> @lang('Update Status')
                                    </button>
                                </td>
                            </tr>
                        @empty
                            @include('Template::partials.empty_message')
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ paginateLinks(@$orders) }}
        </div>
    </div>

    {{-- Status Modal --}}
    <div id="statusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Update Order Status')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.orders.status') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label>@lang('Status')</label>
                            <select name="status" class="form-control form--control">
                                <option value="pending">@lang('Pending')</option>
                                <option value="paid">@lang('Paid')</option>
                                <option value="shipped">@lang('Shipped')</option>
                                <option value="completed">@lang('Completed')</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";
            $('.statusBtn').on('click', function () {
                var modal = $('#statusModal');
                modal.find('input[name=id]').val($(this).data('id'));
                modal.find('select[name=status]').val($(this).data('status'));
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush