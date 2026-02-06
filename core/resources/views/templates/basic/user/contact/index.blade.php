@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title">{{ __(@$pageTitle) }}</h5>
                <p class="container-top__desc">@lang('Organize and manage your contact with effortless ease.')</p>
            </div>
            <x-permission_check permission="add contact">
                <div class="container-top__right">
                    <div class="btn--group">
                        <a href="{{ route('user.contact.create') }}" class="btn btn--base btn-shadow">
                            <i class="las la-plus"></i> @lang('Add New')
                        </a>
                        <button type="button" class="btn btn--info btn-shadow importBtn">
                            <i class="las la-upload"></i>
                            @lang('Import Contacts')
                        </button>
                        <button type="button" class="btn btn--primary btn-shadow importGroupBtn">
                            <i class="las la-paste"></i>
                            @lang('Import from Group')
                        </button>
                    </div>
                </div>
            </x-permission_check>
        </div>
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" name="search" placeholder="@lang('Search here...')"
                            value="{{ request()->search }}" autocomplete="off">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
                <div class="body-top__right">
                    <form class="select-group filter-form">
                        <select class="form-select form--control select2" name="tag_id">
                            <option selected value="">@lang('Filter Tag')</option>
                            @foreach ($contactTags as $tag)
                                <option value="{{ $tag->id }}" @selected(request()->tag_id == $tag->id)>
                                    {{ __(@$tag->name) }}
                                </option>
                            @endforeach
                        </select>
                        <select class="form-select form--control select2" name="paginate">
                            <option value="20" @selected(request()->paginate == 20)>@lang('20 Per Page')</option>
                            <option value="50" @selected(request()->paginate == 50)>@lang('50 Per Page')</option>
                            <option value="100" @selected(request()->paginate == 100)>@lang('100 Per Page')</option>
                            <option value="1000" @selected(request()->paginate == 1000)>@lang('All Contacts')</option>
                        </select>
                    </form>
                    <button type="button" class="btn btn--danger d-none" id="bulkDeleteBtn">
                        <i class="las la-trash"></i> @lang('Delete Selected')
                    </button>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--md">
                    <thead>
                        <tr>
                            <th>
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input checkAll">
                                </div>
                            </th>
                            <th>@lang('Name')</th>
                            <th>@lang('Mobile')</th>
                            <th>@lang('Tags')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contacts as $contact)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input contactCheck" value="{{ $contact->id }}">
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
                                        @include('Template::user.contact.thumb')
                                        {{ __(@$contact->fullName) }}
                                    </div>
                                </td>
                                <td>+{{ @$contact->mobileNumber }}</td>
                                <td>
                                    <ul class="tag-list">
                                        @forelse ($contact->tags->take(3) as $tag)
                                            <li>
                                                <a href="{{ appendQuery('tag_id', $tag->id) }}"
                                                    class="tag-list__link">{{ __(@$tag->name) }}</a>
                                            </li>
                                        @empty
                                            <li>
                                                <span class="text-muted">@lang('N/A')</span>
                                            </li>
                                        @endforelse
                                        @if ($contact->tags->count() > 3)
                                            <li>
                                                <button type="button" data-tags="{{ $contact->tags }}"
                                                    class="more_tags_btn text--base">@lang('See More...')
                                                </button>
                                            </li>
                                        @endif
                                    </ul>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <x-permission_check permission="edit contact">
                                            <a href="{{ route('user.contact.edit', $contact->id) }}"
                                                class="action-btn text--base" data-bs-toggle="tooltip"
                                                data-bs-title="@lang('Edit')">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                        </x-permission_check>
                                        <x-permission_check permission="send message">
                                            <a href="{{ route('user.inbox.list') }}?contact_id={{ $contact->id }}"
                                                class="action-btn text--info" data-bs-toggle="tooltip"
                                                data-bs-title="@lang('Send Message')"><i class="fa-solid fa-paper-plane"></i>
                                            </a>
                                        </x-permission_check>
                                        <x-permission_check permission="delete contact">
                                            <button type="button" class="action-btn confirmationBtn text--danger"
                                                data-bs-toggle="tooltip" data-question="@lang('Are you sure to remove this contact?')"
                                                data-action="{{ route('user.contact.delete', @$contact->id) }}"
                                                data-bs-title="@lang('Delete')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </x-permission_check>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('Template::partials.empty_message')
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ paginateLinks(@$contacts) }}
        </div>
        
        <form action="{{ route('user.contact.delete.all') }}" method="POST" id="finalBulkDeleteForm">
            @csrf
            <input type="hidden" name="ids" id="finalBulkDeleteIds">
        </form>
    </div>

    <div class="modal custom--modal fade importModal progressModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div id="import-progress" class="progress  h-1 w-full d-none">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated h-full w-0"></div>
                </div>
                <div class="modal-header">
                    <div class="modal-header__left">
                        <h5 class="title">@lang('Import Contacts')</h5>
                        <p class="text">@lang('Select your file to import contacts')</p>
                    </div>
                    <div class="modal-header__right">
                        <div class="btn--group">
                            <button class="btn--white btn" data-bs-dismiss="modal"
                                aria-label="Close">@lang('Cancel Import')</button>
                            <button class="btn--base btn btn-shadow" form="import-form">@lang('Import Contacts')</button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="csv-form-wrapper">
                        <div class="csv-form-wrapper__left">
                            <div class="thumb-form-wrapper">
                                <form action="{{ route('user.contact.import') }}" method="POST" id="import-form"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="label-two">
                                            @lang('Contact List')
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="@lang('By specifying a contact list, all imported contacts will be added to the selected list. If left global, the contacts will not be added to any contact list.')">
                                                <i class="las la-question-circle"></i>
                                            </span>
                                        </label>
                                        <select class="form--control select2" name="contact_list_id"
                                            data-minimum-results-for-search="-1">
                                            <option value="0"> @lang('Global') </option>
                                            @foreach ($contactLists as $list)
                                                <option value="{{ $list->id }}"> {{ __(@$list->name) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="thumb-form">
                                        <input type="file" class="form--control drag-drop" name="file"
                                            accept=".csv,xlsx">
                                        <label for="file">
                                            <span class="thumb-form__icon">
                                                <i class="las la-cloud-upload-alt"></i>
                                            </span>
                                            <p class="thumb-form__text file-name text-center">
                                                <span class="">
                                                    <span
                                                        class="cursor-pointer text-decoration-underline text--info">@lang('Click to Upload')</span>
                                                    @lang('or drag and drop here')
                                                </span>
                                                <span class="text-muted fs-14">
                                                    @lang('Supported Files:')
                                                    <b>@lang('.csv'), @lang('.xlsx')</b>
                                                    @lang('& Maximum file size') <b>2</b>@lang('MB')
                                                </span>
                                            </p>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="csv-form-wrapper__right">
                            <div class="instruction-wrapper">
                                <p class="title">@lang('Steps to Import Your Contacts')</p>
                                <ol class="instruction-list">
                                    <li class="instruction-list__item">@lang('Download the sample template to ensure the correct format.')</li>
                                    <li class="instruction-list__item">@lang('Fill in the required customer details: firstname, lastname, mobile_code, and mobile number.')</li>
                                    <li class="instruction-list__item">@lang('Save the completed file in either .csv or .xlsx format.')</li>
                                    <li class="instruction-list__item">@lang('Upload the file by selecting it manually or dragging and dropping it into the upload area.')</li>
                                </ol>
                                <div class="download-btn">
                                    <a href="{{ route('user.contact.csv.download') }}" class="btn--white btn btn--sm">
                                        <i class="la la-download"></i> @lang('Download Sample File')
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Import Modal -->
    <div class="modal custom--modal fade importGroupModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header__left">
                        <h5 class="title">@lang('Import from Group')</h5>
                        <p class="text">@lang('Paste the entire group participant list here')</p>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('user.contact.import.group') }}" method="POST" id="import-group-form">
                    @csrf
                    <div class="modal-body">
                            <label class="label-two">@lang('Paste Extracted Contacts')</label>
                            <textarea name="paste_text" id="pasteTextArea" class="form--control" rows="6" placeholder="@lang('Click the button below to paste from clipboard, or paste manually here...')"></textarea>
                            <button type="button" class="btn btn--info btn--sm mt-2" id="pasteFromClipboardBtn">
                                <i class="las la-clipboard"></i> @lang('Paste from Clipboard')
                            </button>
                            
                            <div class="mt-4 p-3 rounded" style="background: linear-gradient(135deg, #25D366 0%, #128C7E 100%);">
                                <h6 class="text-white fw-bold mb-2"><i class="lab la-whatsapp"></i> @lang('Step 1: Get the Extractor Button')</h6>
                                <p class="text-white fs-13 mb-3">@lang('Drag this button to your browser\'s Bookmarks Bar:')</p>
                                
                                <a href="javascript:(function(){var s=document.createElement('script');s.src='{{ asset('assets/global/js/whatsapp-extractor.js') }}?v={{ time() }}';document.body.appendChild(s);})();" 
                                   class="btn btn--white btn--lg" 
                                   style="cursor:grab; font-weight:bold; box-shadow: 0 4px 15px rgba(0,0,0,0.2);"
                                   onclick="event.preventDefault(); alert('Drag this button to your Bookmarks Bar! Don\'t click it here.');">
                                    <i class="las la-magic"></i> Extract WhatsApp Contacts
                                </a>
                                
                                <div class="mt-3 text-white-50 fs-12">
                                    <p class="mb-1"><strong>@lang('Step 2'):</strong> @lang('Open WhatsApp Web → Open a Group → Click the group name to open Info')</p>
                                    <p class="mb-1"><strong>@lang('Step 3'):</strong> @lang('Click your new bookmark button')</p>
                                    <p class="mb-0"><strong>@lang('Step 4'):</strong> @lang('Come back here and click "Paste from Clipboard"')</p>
                                </div>
                            </div>
                        <div class="row">
                             <div class="col-md-6 form-group">
                                <label class="label-two">@lang('Name Prefix (Optional)')</label>
                                <input type="text" name="name_prefix" class="form--control" placeholder="@lang('e.g. Crypto Group')">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="label-two">@lang('Contact List (Optional)')</label>
                                <select class="form--control select2" name="contact_list_id" style="width: 100%">
                                    <option value=""> @lang('Select List') </option>
                                    @foreach ($contactLists as $list)
                                        <option value="{{ $list->id }}"> {{ __(@$list->name) }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--white" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn--base">@lang('Import Now')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal tags-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Contact Tags')</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="tag-list contact-tags">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal isFrontend="true" />
@endsection

@push('style-lib')
    <link rel="stylesheet" href="{{ asset('assets/global/css/select2.min.css') }}">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            const $modal = $('.importModal');
            const $groupModal = $('.importGroupModal');
            const $form = $('#import-form');
            const $groupForm = $('#import-group-form');
            const $drop = $('.thumb-form');
            const $input = $drop.find('input[type="file"]');
            const $progress = $('#import-progress');
            const $bar = $progress.find('.progress-bar');

            $('.importBtn').on('click', () => $modal.modal('show'));
            $('.importGroupBtn').on('click', () => $groupModal.modal('show'));

            $('.filter-form select').on('change', function() {
                $(this).closest('form').submit();
            });

            $form.on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                $progress.removeClass('d-none');
                $bar.css('width', '0%');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percent = (e.loaded / e.total) * 100;
                                $bar.css('width', percent + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(res) {
                        $progress.addClass('d-none');
                        $bar.css('width', '0%');

                        if (res.status === 'success') {
                            notify('success', res.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            notify('error', res.message || "Something went wrong");
                        }
                    },
                    error: function(xhr) {
                        $progress.addClass('d-none');
                        $bar.css('width', '0%');

                        let errorMessage = "Something went wrong";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else {
                            console.error('Unexpected response:', xhr.responseText);
                        }
                        notify('error', errorMessage);
                    }
                });
            });


            $(document).on('dragover dragenter drop', e => e.preventDefault());

            $drop.on('dragover', () => $drop.addClass('drag-over'))
                .on('dragleave drop', () => $drop.removeClass('drag-over'));

            $drop.on('drop', e => {
                const files = e.originalEvent.dataTransfer.files;
                if (files.length) {
                    $input[0].files = files;
                    $('.file-name').text($input[0].files[0].name);
                }
            });

            $input.on('change', () => {
                $('.file-name').text($input[0].files[0].name);
            })

            $('.more_tags_btn').on('click', function() {
                const contactTags = $(this).data('tags');
                $('.contact-tags').html('');
                contactTags.forEach(tag => {
                    $('.contact-tags').append(`
                    <li>
                        <a href = "?tag_id=${tag.id}" class = "tag-list__link">${tag.name}</a>
                    </li>`);
                });
                $('.tags-modal').modal('show');
            });
            
            // Paste from Clipboard button handler
            $('#pasteFromClipboardBtn').on('click', async function() {
                try {
                    const text = await navigator.clipboard.readText();
                    if (text && text.trim()) {
                        $('#pasteTextArea').val(text);
                        notify('success', 'Contacts pasted successfully!');
                    } else {
                        notify('warning', 'Clipboard is empty. Run the extractor on WhatsApp Web first.');
                    }
                } catch (err) {
                    notify('error', 'Could not access clipboard. Please paste manually (Ctrl+V).');
                    console.error('Clipboard error:', err);
                }
            });

            // Bulk Delete Logic
            $(document).on('click', '.checkAll', function() {
                if($(this).is(':checked')) {
                    $('.contactCheck').prop('checked', true);
                } else {
                    $('.contactCheck').prop('checked', false);
                }
                toggleDeleteBtn();
            });

            $(document).on('change', '.contactCheck', function() {
                toggleDeleteBtn();
                if($('.contactCheck:checked').length == $('.contactCheck').length) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
            });

            function toggleDeleteBtn() {
                if($('.contactCheck:checked').length > 0) {
                    $('#bulkDeleteBtn').removeClass('d-none');
                } else {
                    $('#bulkDeleteBtn').addClass('d-none');
                }
            }

            $('#bulkDeleteBtn').on('click', function() {
                var ids = [];
                $('.contactCheck:checked').each(function() {
                    ids.push($(this).val());
                });

                if(ids.length > 0) {
                    var modal = $('#bulkDeleteModal');
                    modal.find('.count').text(ids.length);
                    // Store as JSON string to avoid max_input_vars limit with 1000+ items
                    $('#finalBulkDeleteIds').val(JSON.stringify(ids));
                    modal.modal('show');
                }
            });

            $(document).on('click', '#confirmDeleteBtn', function() {
                // Fail-safe: Ensure input is populated
                var val = $('#finalBulkDeleteIds').val();
                if (!val || val === '[]') {
                    var ids = [];
                    $('.contactCheck:checked').each(function() {
                        ids.push($(this).val());
                    });
                    $('#finalBulkDeleteIds').val(JSON.stringify(ids));
                }

                $('#finalBulkDeleteForm').submit();
            });
            
            // Re-render checkAll logic on pagination (handled by standard page reload, so fine)
            
        })(jQuery);
    </script>
    
    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                <div class="modal-body text-center p-4">
                    <i class="las la-exclamation-circle text-danger display-1 mb-3"></i>
                    <h4 class="text--secondary mb-2">@lang('Are you sure?')</h4>
                    <p class="text--secondary mb-4">@lang('You are about to delete') <span class="count fw-bold"></span> @lang('contacts. This action cannot be undone.')</p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="button" class="btn btn--danger" id="confirmDeleteBtn">@lang('Yes, Delete')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
