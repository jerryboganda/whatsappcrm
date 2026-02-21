@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Broadcast Wizard')</h4>
                </div>
                <div class="card-body">
                    <!-- Wizard Navigation -->
                    <div class="wizard-nav mb-4">
                        <ul class="nav nav-pills nav-fill" id="wizardTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="step1-tab" data-bs-toggle="pill" data-bs-target="#step1"
                                    type="button" role="tab">1. @lang('Audience')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="step2-tab" data-bs-toggle="pill" data-bs-target="#step2"
                                    type="button" role="tab">2. @lang('Message')</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="step3-tab" data-bs-toggle="pill" data-bs-target="#step3"
                                    type="button" role="tab">3. @lang('Schedule')</button>
                            </li>
                        </ul>
                    </div>

                    <form action="{{route('user.campaign.save')}}" method="POST" enctype="multipart/form-data"
                        id="wizardForm">
                        @csrf
                        <div class="tab-content" id="wizardTabContent">

                            <!-- STEP 1: AUDIENCE -->
                            <div class="tab-pane fade show active" id="step1" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Campaign Name') <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" name="title" class="form-control"
                                                placeholder="@lang('Enter Campaign Name')" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <label class="form-label mb-0">@lang('Select Group / Lists')</label>
                                                <a href="{{ route('user.contact.list', ['open_group_import' => 1]) }}" target="_blank"
                                                    class="btn btn--sm btn-info">
                                                    <i class="lab la-whatsapp"></i> @lang('Import from WhatsApp Group')
                                                </a>
                                            </div>
                                            <select class="form-control select2-multi-select" name="contact_lists[]"
                                                multiple>
                                                @foreach($contactLists as $list)
                                                    <option value="{{ $list->id }}">{{ __($list->name) }}
                                                        ({{ $list->contact_count }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('Select Tags')</label>
                                            <select class="form-control select2-multi-select" name="contact_tags[]"
                                                multiple>
                                                @foreach($contactTags as $tag)
                                                    <option value="{{ $tag->id }}">{{ __($tag->name) }}
                                                        ({{ $tag->contacts_count }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="card border-primary">
                                            <div class="card-body">
                                                <h5 class="card-title">@lang('Quick Import (Optional)')</h5>
                                                <p class="card-text text-muted">
                                                    @lang('Paste numbers here to create a temporary list automatically.')
                                                </p>
                                                <textarea class="form-control" name="raw_numbers" rows="5"
                                                    placeholder="+1234567890, +9876543210..."></textarea>
                                                <small class="text-warning"><i class="fas fa-info-circle"></i>
                                                    @lang('This feature will be implemented in backend if requested.')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary next-step">@lang('Next: Message') <i
                                            class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>

                            <!-- STEP 2: MESSAGE -->
                            <div class="tab-pane fade" id="step2" role="tabpanel">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Select WhatsApp Account') <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="whatsapp_account_id" id="whatsapp_account_id"
                                                required>
                                                <option value="" disabled selected>@lang('Select One')</option>
                                                @foreach($whatsappAccounts as $account)
                                                    <option value="{{ $account->id }}">{{ $account->name }}
                                                        ({{ $account->number }})</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">@lang('Select Template') <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-control" name="template_id" id="template_id" required>
                                                <option value="" disabled selected>@lang('Select Account First')</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div id="template-preview" class="border p-3 rounded bg-light display-none">
                                            <h6>@lang('Template Preview')</h6>
                                            <div class="template-content small"></div>
                                        </div>

                                        <!-- Dynamic Variables Info -->
                                        <div class="template-variables mt-3"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-step"><i
                                            class="fas fa-arrow-left"></i> @lang('Previous')</button>
                                    <button type="button" class="btn btn-primary next-step">@lang('Next: Schedule') <i
                                            class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>

                            <!-- STEP 3: SCHEDULE -->
                            <div class="tab-pane fade" id="step3" role="tabpanel">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8">
                                        <div class="form-group">
                                            <label class="form-label">@lang('Scheduling')</label>
                                            <div class="form-check form-switch form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" name="schedule"
                                                    id="schedule_check">
                                                <label class="form-check-label" for="schedule_check">
                                                    @lang('Schedule for later')
                                                </label>
                                            </div>
                                        </div>

                                        <div class="schedule-options display-none">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang('Date & Time') <span
                                                                class="text-danger">*</span></label>
                                                        <input type="datetime-local" name="scheduled_at"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">@lang('Timezone')</label>
                                                        <select name="schedule_timezone" class="form-control select2">
                                                            @foreach(timezone_identifiers_list() as $timezone)
                                                                <option value="{{ $timezone }}" {{ config('app.timezone') == $timezone ? 'selected' : '' }}>
                                                                    {{ $timezone }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-secondary prev-step"><i
                                            class="fas fa-arrow-left"></i> @lang('Previous')</button>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i>
                                        @lang('Launch Campaign')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function ($) {
            "use strict";

            // Wizard Navigation
            $('.next-step').on('click', function () {
                var activeTab = $('.wizard-nav .nav-link.active');
                var nextTab = activeTab.parent().next().find('.nav-link');
                if (nextTab.length && validateStep(activeTab.attr('id'))) {
                    nextTab.tab('show');
                }
            });

            $('.prev-step').on('click', function () {
                var activeTab = $('.wizard-nav .nav-link.active');
                var prevTab = activeTab.parent().prev().find('.nav-link');
                if (prevTab.length) {
                    prevTab.tab('show');
                }
            });

            function validateStep(stepId) {
                // Simple validation demo
                if (stepId == 'step1-tab') {
                    if (!$('input[name="title"]').val()) {
                        notify('error', 'Please enter a campaign name');
                        return false;
                    }
                }
                return true;
            }

            // Schedule Toggle
            $('#schedule_check').on('change', function () {
                if ($(this).is(':checked')) {
                    $('.schedule-options').slideDown();
                } else {
                    $('.schedule-options').slideUp();
                }
            });

            // Template Loading Logic (Simplified from create.blade.php)
            var templates = @json($templates);
            var whatsappAccounts = @json($whatsappAccounts);

            $('#whatsapp_account_id').on('change', function () {
                var accountId = $(this).val();
                var accountTemplates = templates.filter(t => t.whatsapp_account_id == accountId);

                var html = '<option value="" disabled selected>@lang("Select Template")</option>';
                accountTemplates.forEach(function (template) {
                    html += `<option value="${template.id}" data-template='${JSON.stringify(template)}'>${template.name} (${template.language})</option>`;
                });
                $('#template_id').html(html);
            });

            $('#template_id').on('change', function () {
                $('#template-preview').show();
                // In a real implementation, we would render the preview here
            });

            const lastImportedListId = window.localStorage.getItem('groupExtractionLastListId');
            if (lastImportedListId) {
                const $listSelect = $('select[name="contact_lists[]"]');
                if ($listSelect.find(`option[value="${lastImportedListId}"]`).length) {
                    const selected = $listSelect.val() || [];
                    if (!selected.includes(lastImportedListId)) {
                        selected.push(lastImportedListId);
                    }
                    $listSelect.val(selected).trigger('change');
                    notify('success', 'Latest imported WhatsApp group list auto-selected.');
                    window.localStorage.removeItem('groupExtractionLastListId');
                }
            }

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .display-none {
            display: none;
        }

        .wizard-nav .nav-link {
            border-radius: 0;
            background-color: #f8f9fa;
            color: #5e6278;
            padding: 1rem;
        }

        .wizard-nav .nav-link.active {
            background-color: #009ef7;
            color: #fff;
        }

        .wizard-nav .nav-item {
            flex: 1;
            text-align: center;
        }
    </style>
@endpush
