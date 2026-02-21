@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row mb-none-30">
        <div class="col-xl-4 col-lg-5 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="">
                            <img src="{{ getImage(getFilePath('contactProfile') . '/' . @$order->contact->image, null, true) }}"
                                alt="@lang('profile-image')" class="b-radius--10 user-profile-img">
                        </div>
                        <div class="mt-15">
                            <h4 class="">{{ @$order->contact->firstname }} {{ @$order->contact->lastname }}</h4>
                            <span class="text--small">@lang('Order ID'): <strong>#{{ $order->id }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card b-radius--10 overflow-hidden box--shadow1 mt-30">
                <div class="card-body">
                    <h5 class="mb-20 text-muted">@lang('Contact Information')</h5>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Mobile')
                            <span class="fw-bold">{{ @$order->contact->mobile }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('City')
                            <span class="fw-bold">{{ @$order->contact->city }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7 mb-30">
            <div class="card b-radius--10 overflow-hidden box--shadow1">
                <div class="card-body">
                    <h5 class="card-title border-bottom pb-2">@lang('Order Details')</h5>
                    <div class="table-responsive--md  table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Product Name')</th>
                                    <th>@lang('Quantity')</th>
                                    <th>@lang('Price')</th>
                                    <th>@lang('Total')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->products_json ?? [] as $product)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ @$product['name'] }}</span>
                                        </td>
                                        <td>{{ @$product['quantity'] }}</td>
                                        <td>{{ $order->currency }} {{ getAmount(@$product['item_price']) }}</td>
                                        <td>{{ $order->currency }}
                                            {{ getAmount(@$product['item_price'] * @$product['quantity']) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-end fw-bold">@lang('Total Amount')</td>
                                    <td class="fw-bold">{{ $order->currency }} {{ getAmount($order->amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">@lang('Status'):
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
                        </span>
                        <button class="btn btn--base btn--sm statusBtn" data-id="{{ $order->id }}"
                            data-status="{{ $order->status }}">
                            <i class="las la-edit"></i> @lang('Update Status')
                        </button>
                    </div>
                </div>
            </div>
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