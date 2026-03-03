<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Update your contact information from the here'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.contact.list')); ?>" class="btn btn--dark btn-shadow"><i class="las la-list"></i>
                        <?php echo app('translator')->get('Contact List'); ?>
                    </a>
                    <button type="submit" form="information-form" class="btn btn--base btn-shadow">
                        <i class="lab la-telegram"></i> <?php echo app('translator')->get('Update'); ?> <?php echo e(__($module ?? "Contact")); ?>

                    </button>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="row">
                <div class="col-xxl-8">
                    <form action="<?php echo e(route('user.contact.update', $contact->id)); ?>" method="POST"
                        enctype="multipart/form-data" id="information-form">
                        <?php echo csrf_field(); ?>
                        <div class="row gy-2">
                            <div class="col-12">
                                <div class="d-flex justify-content-center text-center flex-column align-items-start mb-4">
                                    <div class="profile-header__thumb">
                                        <div class="file-upload">
                                            <label class="edit" for="profile_image"><i class="las la-plus"></i></label>
                                            <input type="file" name="profile_image" class="form-control form--control"
                                                id="profile_image" hidden>
                                        </div>
                                        <div class="thumb">
                                            <img class="image-preview" src="<?php echo e(@$contact->imageSrc); ?>" alt="profile">
                                        </div>
                                    </div>
                                    <p class="thumb-size fs-14">
                                        <?php echo app('translator')->get('Image will be resize'); ?>
                                        <b> <?php echo app('translator')->get('350x300px'); ?> </b>
                                        <?php echo app('translator')->get('& Supported file is'); ?>
                                        <b><?php echo app('translator')->get('.jpg'); ?>, <?php echo app('translator')->get('.jpeg'); ?>, <?php echo app('translator')->get('.png'); ?></b>
                                    </p>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('First Name'); ?></label>
                                    <input type="text" class="form--control form-two" name="firstname"
                                        placeholder="<?php echo app('translator')->get('Enter firstname'); ?>" value="<?php echo e(old('firstname', $contact->firstname)); ?>"
                                        required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Last Name'); ?></label>
                                    <input type="text" class="form--control form-two" name="lastname"
                                        placeholder="<?php echo app('translator')->get('Enter lastname'); ?>" required
                                        value="<?php echo e(old('lastname', $contact->lastname)); ?>">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Country'); ?></label>

                                    <select class="form--control select2 form-two" name="mobile_code">
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($country->dial_code); ?>" <?php if(old('mobile_code', $contact->mobile_code) == $country->dial_code): echo 'selected'; endif; ?>>
                                                <?php echo e(__($country->country)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Mobile'); ?></label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code">
                                        </span>

                                        <input type="number" name="mobile" value="<?php echo e(old('mobile', $contact->mobile)); ?>"
                                            class="form-control form--control form-two" required
                                            placeholder="<?php echo app('translator')->get('Enter mobile number'); ?>">
                                    </div>
                                    <span class="contact-exists-error d-none"></span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="label-two"><?php echo app('translator')->get('Contact Tags'); ?></label>
                                        <button type="button" data-title="<?php echo app('translator')->get('Create New Tag'); ?>"
                                            data-route="<?php echo e(route('user.contacttag.save')); ?>"
                                            class="add-btn fs-14 text-decoration-underline">
                                            <?php echo app('translator')->get('Add New'); ?>
                                        </button>
                                    </div>
                                    <select name="tags[]" class="form--control select2 form-two contact-tag"
                                        data-minimum-results-for-search="-1" data-placeholder="<?php echo app('translator')->get('Choose contact tag'); ?>" multiple>
                                        <?php $__currentLoopData = $contactTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($tag->id); ?>" <?php if(in_array($tag->id, old('tags', $existingTagId))): echo 'selected'; endif; ?>>
                                                <?php echo e(__(@$tag->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="label-two"><?php echo app('translator')->get('Contact Lists'); ?></label>
                                        <button type="button" data-title="<?php echo app('translator')->get('Create New Contact List'); ?>"
                                            class="add-btn fs-14 text-decoration-underline"
                                            data-route="<?php echo e(route('user.contactlist.save')); ?>"><?php echo app('translator')->get('Add New'); ?>
                                        </button>
                                    </div>
                                    <select name="lists[]" class="form--control select2 form-two contact-list"
                                        data-minimum-results-for-search="-1" data-placeholder="<?php echo app('translator')->get('Choose contact list'); ?>" multiple>
                                        <?php $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($list->id); ?>" <?php if(in_array($list->id, old('lists', $existingListId))): echo 'selected'; endif; ?>>
                                                <?php echo e(__(@$list->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="d-flex gap-2 flex-wrap justify-content-between mb-1">
                                    <label class="label-two d-inline-flex align-items-center">
                                        <?php echo app('translator')->get('Custom Attributes'); ?>
                                        <i class="las la-info-circle ms-1 text--info" data-bs-toggle="tooltip"
                                            title="<?php echo app('translator')->get('Custom attributes are dynamic fields that let you store personalized or extra information'); ?>.">
                                        </i>
                                    </label>
                                    <button type="button" class="fs-14 text-decoration-underline add-custom-attribute">
                                        <?php echo app('translator')->get('More Attribute'); ?>
                                    </button>
                                </div>
                                <div class="custom-attributes-wrapper">
                                    <?php if(count(old('custom_attributes', []))): ?>
                                        <?php for($i = 0; $i < count(old('custom_attributes')['name']); $i++): ?>
                                            <div class="row custom-attribute-wrapper g-2 align-items-center mb-2">

                                                <?php
                                                    $customAttribute = old('custom_attributes');
                                                ?>
                                                <div class="col-md-5">
                                                    <input type="text" name="custom_attributes[name][]"
                                                        class="form--control form-two" placeholder="<?php echo app('translator')->get('Field Name'); ?>"
                                                        value="<?php echo e($customAttribute['name'][$i]); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="custom_attributes[value][]"
                                                        class="form--control form-two" placeholder="<?php echo app('translator')->get('Field Value'); ?>"
                                                        value="<?php echo e($customAttribute['value'][$i]); ?>">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button type="button" class="btn btn--danger remove-attribute w-100">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    <?php else: ?>
                                        <?php if($contact->details && count($contact->details) && is_array($contact->details)): ?>
                                            <?php $__currentLoopData = $contact->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="row custom-attribute-wrapper g-2 align-items-center mb-2">
                                                    <div class="col-md-5">
                                                        <input type="text" value="<?php echo e($key); ?>"
                                                            name="custom_attributes[name][]"
                                                            class="form--control form-two"
                                                            placeholder="<?php echo app('translator')->get('Field Name'); ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="text" name="custom_attributes[value][]"
                                                            class="form--control form-two"
                                                            placeholder="<?php echo app('translator')->get('Field Value'); ?>" value="<?php echo e($details); ?>">
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <button type="button"
                                                            class="btn btn--danger remove-attribute w-100">
                                                            <i class="las la-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <div class="row custom-attribute-wrapper g-2 align-items-center mb-2">
                                                <div class="col-md-5">
                                                    <input type="text" name="custom_attributes[name][]"
                                                        class="form--control form-two" placeholder="<?php echo app('translator')->get('Field Name'); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="custom_attributes[value][]"
                                                        class="form--control form-two" placeholder="<?php echo app('translator')->get('Field Value'); ?>">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button type="button" class="btn btn--danger remove-attribute w-100">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal add-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" class="no-submit-loader">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label class="label-two"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form--control form-two" name="name" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">
                                <i class="lab la-telegram"></i> <?php echo app('translator')->get('Submit'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            const $modal = $('.add-modal');

            $('.select2').select2();

            $('select[name=mobile_code]').on('change', function() {
                $('.mobile-code').text("+" + $(this).val());
            }).change();

            $('.add-custom-attribute').on('click', function(e) {
                e.preventDefault();

                let html = `<div class="row custom-attribute-wrapper g-2 align-items-center mb-2">
                        <div class="col-md-5">
                            <input type="text" name="custom_attributes[name][]" class="form--control form-two" placeholder="Filed Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="custom_attributes[value][]" class="form--control form-two" placeholder="Filed Value">
                        </div>
                        <div class="col-md-1 d-flex align-items-center">
                            <button type="button" class="btn btn--danger remove-attribute w-100">
                                <i class="las la-trash"></i>
                            </button>
                        </div>
                    </div>`;

                $('.custom-attributes-wrapper').append(html);
            });

            $('.custom-attributes-wrapper').on('click', '.remove-attribute', function(e) {
                e.preventDefault();
                $(this).parent().parent().remove();
            });

            $('.add-btn').on('click', function() {
                const route = $(this).data('route');
                const title = $(this).data('title');
                $modal.find('form').trigger('reset');
                $modal.find('form').attr('action', route);
                $modal.find('.modal-title').text(title);
                $modal.modal('show');
            });

            $modal.on('submit', "form", function(e) {
                e.preventDefault();
                var $this = $(this);
                var data = $this.serialize();
                $.post($this.attr('action'), data, function(response) {
                    const notifyMessage = response.message || "<?php echo app('translator')->get('Contact List'); ?>";
                    if (response.status == 'success') {
                        const data = response.data;
                        const option =
                            `<option value="${data.data.id}" selected>${data.data.name}</option`;
                        $(`.${data.type}`).append(option).trigger('change');
                        $modal.modal('hide');
                        $this.trigger('reset');
                        notify('success', notifyMessage);
                    } else {
                        notify('error', notifyMessage);
                    }

                })
            });


            $('#profile_image').on('change', function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('.image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .add-btn {
            cursor: pointer;
        }

        .select2+.select2-container .select2-selection.select2-selection--multiple {
            background: hsl(var(--section-bg));
            border-radius: 8px !important;
        }

        .dashboard-container .select2+.select2-container .select2-selection.select2-selection--multiple {
            border: 1px solid #c1c9d033 !important;
        }

        .dashboard-container .select2+.select2-container.select2-container--open .select2-selection__rendered,
        .dashboard-container .select2+.select2-container.select2-container--focus .select2-selection.select2-selection--multiple,
        .dashboard-container .select2+.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
            border: 1px solid hsl(var(--base)) !important;
        }

        .select2+.select2-container .select2-selection--multiple .select2-search.select2-search--inline {
            line-height: 28px;
        }

        .select2+.select2-container .select2-selection--multiple .select2-selection__rendered {
            line-height: 25px;
            box-shadow: unset !important;
            background: transparent !important;
            padding-right: 8px;
        }

        .dashboard-container .select2+.select2-container .select2-selection--multiple .select2-selection__rendered {
            border: 0 !important;
        }

        .select2-container--default .select2-search__field {
            border-radius: 4px;
        }

        .select2-container--open .select2-dropdown {
            border-radius: 4px !important;
        }

        .select2-results__options::-webkit-scrollbar {
            width: 0px;
        }

        .select2-search__field {
            background-color: hsl(var(--section-bg)) !important;
        }

        .select2-selection--multiple .select2-search__field {
            background-color: transparent !important;
        }

        .select2+.select2-container:has(.select2-selection.select2-selection--multiple) {
            height: auto;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact/edit.blade.php ENDPATH**/ ?>