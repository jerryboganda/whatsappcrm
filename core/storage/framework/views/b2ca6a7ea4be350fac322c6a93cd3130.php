<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Organize and manage your contact list for easily manage your contacts.'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.contactlist.list')); ?>" class="btn btn--dark"><i class="las la-undo"></i>
                        <?php echo app('translator')->get('Back'); ?></a>
                    <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'add contact to list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'add contact to list']); ?>
                        <button class="btn btn--base add-btn"><i class="las la-plus"></i> <?php echo app('translator')->get('Add Contact'); ?></button>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" placeholder="<?php echo app('translator')->get('Search here'); ?> ..." name="search"
                            value="<?php echo e(request()->search); ?>">
                        <span class="search-form__icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--md">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Mobile Number'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $listContact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div
                                        class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
                                        <div class="table-thumb d-none d-lg-block">
                                            <img src="<?php echo e(@$listContact->contact?->image_src); ?>" alt="image">
                                        </div>
                                        <?php echo e(__(@$listContact->contact?->fullName)); ?>

                                    </div>
                                </td>
                                <td>+<?php echo e(@$listContact->contact?->mobileNumber); ?></td>
                                <td>
                                    <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'remove contact from list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'remove contact from list']); ?>
                                        <button type="button" class="action-btn delete-btn confirmationBtn"
                                            data-question="<?php echo app('translator')->get('Are you sure to remove this contact from list?'); ?>"
                                            data-action="<?php echo e(route('user.contactlist.contact.remove', $listContact->id)); ?>"
                                            data-bs-toggle="tooltip" data-bs-title="<?php echo app('translator')->get('Delete'); ?>">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks($contacts)); ?>

        </div>
    </div>
    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isFrontend' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>

    <div class="modal fade custom--modal add-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Add Contact to List'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('user.contactlist.contact.add', $contactList->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3 selection-contact">
                            <label class="label-two"><?php echo app('translator')->get('Select Contact'); ?></label>
                            <select name="contacts[]" class="form--control contacts select2" multiple required></select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100"><i class="lab la-telegram"></i>
                                <?php echo app('translator')->get('Submit'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startPush('style-lib'); ?>
        <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('script-lib'); ?>
        <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('script'); ?>
        <script>
            "use strict";
            (function($) {

                const $modal = $('.add-modal');

                $('.add-btn').on('click', function() {
                    $modal.find('form').trigger('reset');
                    $modal.modal('show');
                });

                $modal.on('shown.bs.modal', function() {
                    $('.contacts').select2({
                        ajax: {
                            url: "<?php echo e(route('user.contact.search')); ?>",
                            type: "get",
                            dataType: 'json',
                            delay: 1000,
                            data: function(params) {
                                return {
                                    search: params.term,
                                    page: params.page,
                                    contactListId: "<?php echo e($contactList->id); ?>"
                                };
                            },
                            processResults: function(response, params) {
                                params.page = params.page || 1;
                                return {
                                    results: $.map(response.data.contacts.data, function(item) {
                                        return {
                                            text: '+' + item.mobile_code + item.mobile,
                                            id: item.id
                                        };
                                    }),
                                    pagination: {
                                        more: response.more
                                    }
                                };
                            },
                            cache: false
                        },
                        allowClear: true,
                        // minimumInputLength: 1,
                        width: "100%",
                        dropdownParent: $('.selection-contact')
                    });
                });

            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('style'); ?>
        <style>
            .select2+.select2-container .select2-selection.select2-selection--multiple {
                background: hsl(var(--section-bg));
                border-radius: 8px !important;
            }


            .add-modal .select2+.select2-container.select2-container--open .select2-selection__rendered,
            .add-modal .select2+.select2-container.select2-container--focus .select2-selection.select2-selection--multiple,
            .add-modal .select2+.select2-container.select2-container--open .select2-selection.select2-selection--multiple {
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

            .add-modal .select2+.select2-container .select2-selection--multiple .select2-selection__rendered {
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

            .add-modal .select2-search__field:focus {
                border-color: transparent !important;
            }

            .select2-selection--multiple .select2-search__field {
                background-color: transparent !important;
            }

            .select2+.select2-container:has(.select2-selection.select2-selection--multiple) {
                height: auto;
            }
        </style>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact_list/view_list.blade.php ENDPATH**/ ?>