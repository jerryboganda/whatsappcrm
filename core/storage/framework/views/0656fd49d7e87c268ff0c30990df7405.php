<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Quickly add new contacts by completing the simple form below.'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a class="btn btn--dark btn-shadow" href="<?php echo e(route('user.contact.list')); ?>"><i class="las la-list"></i>
                        <?php echo app('translator')->get('Contact List'); ?>
                    </a>
                    <button class="btn btn--base btn-shadow" form="information-form" type="submit">
                        <i class="lab la-telegram"></i> <?php echo app('translator')->get('Save Contact'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="information-wrapper">
                <div class="row">
                    <div class="col-xxl-8">
                        <form id="information-form" action="<?php echo e(route('user.contact.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="row gy-2">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('First Name'); ?></label>
                                        <input class="form--control form-two" name="firstname" type="text"
                                            value="<?php echo e(old('firstname')); ?>" placeholder="<?php echo app('translator')->get('Enter firstname'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Last Name'); ?></label>
                                        <input class="form--control form-two" name="lastname" type="text"
                                            value="<?php echo e(old('lastname')); ?>" placeholder="<?php echo app('translator')->get('Enter lastname'); ?>" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Country'); ?></label>
                                        <select class="form--control select2  img-select2 form-two" name="mobile_code">
                                            <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option
                                                    data-src="<?php echo e(asset('assets/images/country/' . strtolower($key) . '.svg')); ?>"
                                                    value="<?php echo e($country->dial_code); ?>" <?php if(old('mobile_code')): echo 'selected'; endif; ?>>
                                                    <?php echo e(__($country->country)); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Mobile'); ?></label>
                                        <div class="input-group">
                                            <span class="input-group-text mobile-code">
                                            </span>
                                            <input class="form-control form--control form-two" name="mobile" type="number"
                                                value="<?php echo e(old('mobile')); ?>" value="<?php echo e(old('mobile')); ?>" required
                                                placeholder="<?php echo app('translator')->get('Enter mobile number'); ?>">
                                        </div>
                                        <span class="contact-exists-error d-none"></span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label class="label-two"><?php echo app('translator')->get('Contact Tags'); ?></label>
                                            <button class="add-btn fs-14 text-decoration-underline"
                                                data-title="<?php echo app('translator')->get('Create New Tag'); ?>"
                                                data-route="<?php echo e(route('user.contacttag.save')); ?>" type="button">
                                                <?php echo app('translator')->get('Add New'); ?>
                                            </button>
                                        </div>
                                        <select class="form--control select2 form-two contact-tag" name="tags[]"
                                            data-minimum-results-for-search="-1" data-placeholder="<?php echo app('translator')->get('Choose contact tag'); ?>"
                                            multiple>
                                            <?php $__currentLoopData = $contactTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($tag->id); ?>" <?php if(in_array($tag->id, old('tags', []))): echo 'selected'; endif; ?>>
                                                    <?php echo e(__(@$tag->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between">
                                            <label class="label-two"><?php echo app('translator')->get('Contact Lists'); ?></label>
                                            <button class="add-btn fs-14 text-decoration-underline"
                                                data-title="<?php echo app('translator')->get('Create New Contact List'); ?>"
                                                data-route="<?php echo e(route('user.contactlist.save')); ?>"
                                                type="button"><?php echo app('translator')->get('Add New'); ?>
                                            </button>
                                        </div>
                                        <select class="form--control select2 form-two contact-list" name="lists[]"
                                            data-minimum-results-for-search="-1" data-placeholder="<?php echo app('translator')->get('Choose contact list'); ?>"
                                            multiple>
                                            <?php $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list->id); ?>" <?php if(in_array($list->id, old('lists', []))): echo 'selected'; endif; ?>>
                                                    <?php echo e(__(@$list->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="d-flex justify-content-between mb-1 flex-wrap gap-2">
                                        <label class="label-two d-inline-flex align-items-center">
                                            <?php echo app('translator')->get('Custom Attributes'); ?>
                                            <i class="las la-info-circle text--info ms-1" data-bs-toggle="tooltip"
                                                title="<?php echo app('translator')->get('Custom attributes are dynamic fields that let you store personalized or extra information'); ?>.">
                                            </i>
                                        </label>
                                        <button class="fs-14 text-decoration-underline add-custom-attribute" type="button">
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
                                                        <input class="form--control form-two"
                                                            name="custom_attributes[name][]" type="text"
                                                            value="<?php echo e($customAttribute['name'][$i]); ?>"
                                                            placeholder="<?php echo app('translator')->get('Field Name'); ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input class="form--control form-two"
                                                            name="custom_attributes[value][]" type="text"
                                                            value="<?php echo e($customAttribute['value'][$i]); ?>"
                                                            placeholder="<?php echo app('translator')->get('Field Value'); ?>">
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-center">
                                                        <button class="btn btn--danger remove-attribute w-100"
                                                            type="button">
                                                            <i class="las la-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        <?php else: ?>
                                            <div class="row custom-attribute-wrapper g-2 align-items-center mb-2">
                                                <div class="col-md-5">
                                                    <input class="form--control form-two" name="custom_attributes[name][]"
                                                        type="text" placeholder="<?php echo app('translator')->get('Field Name'); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <input class="form--control form-two"
                                                        name="custom_attributes[value][]" type="text"
                                                        placeholder="<?php echo app('translator')->get('Field Value'); ?>">
                                                </div>
                                                <div class="col-md-1 d-flex align-items-center">
                                                    <button class="btn btn--danger remove-attribute w-100" type="button">
                                                        <i class="las la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal add-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <form class="no-submit-loader" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label class="label-two"><?php echo app('translator')->get('Name'); ?></label>
                            <input class="form--control form-two" name="name" type="text" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn--base w-100" type="submit">
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
    <link href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            const $modal = $('.add-modal');


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
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact/create.blade.php ENDPATH**/ ?>