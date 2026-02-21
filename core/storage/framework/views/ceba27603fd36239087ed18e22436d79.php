<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Easily create & manage whatsapp message templates for easy communication.'); ?></p>
            </div>
            <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'add template']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'add template']); ?>
                <div class="container-top__right">
                    <div class="btn--group">
                        <a href="<?php echo e(route('user.template.create.carousel')); ?>" class="btn btn--base btn-shadow">
                            <i class="las la-plus"></i>
                            <?php echo app('translator')->get('Carousel Template'); ?>
                        </a>
                        <a href="<?php echo e(route('user.template.create')); ?>" class="btn btn--base btn-shadow">
                            <i class="las la-plus"></i>
                            <?php echo app('translator')->get('Add New'); ?>
                        </a>
                    </div>
                </div>
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
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search by ID or name...'); ?>"
                            autocomplete="off" value="<?php echo e(request()->search); ?>">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
                <div class="body-top__right">
                    <form class="select-group filter-form">
                        <select class="form-select form--control select2" name="status">
                            <option selected value=""><?php echo app('translator')->get('Filter Status'); ?></option>
                            <option value="<?php echo e(Status::TEMPLATE_PENDING); ?>" <?php if(request()->status == (string) Status::TEMPLATE_PENDING): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Pending'); ?>
                            </option>
                            <option value="<?php echo e(Status::TEMPLATE_APPROVED); ?>" <?php if(request()->status == Status::TEMPLATE_APPROVED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Approved'); ?>
                            </option>
                            <option value="<?php echo e(Status::TEMPLATE_REJECTED); ?>" <?php if(request()->status == Status::TEMPLATE_REJECTED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Rejected'); ?>
                            </option>
                            <option value="<?php echo e(Status::TEMPLATE_DISABLED); ?>" <?php if(request()->status == Status::TEMPLATE_DISABLED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Disabled'); ?>
                            </option>
                        </select>
                        <select class="form-select form--control select2" name="category_id">
                            <option selected value=""><?php echo app('translator')->get('Filter Category'); ?></option>
                            <?php $__currentLoopData = $templateCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $templateCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e(@$templateCategory->id); ?>" <?php if(request()->category_id == $templateCategory->id): echo 'selected'; endif; ?>>
                                    <?php echo e(__(@$templateCategory->label)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php if (isset($component)) { $__componentOriginal78fc733786e0718cdf5e64f6023f5630 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal78fc733786e0718cdf5e64f6023f5630 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.whatsapp_account','data' => ['isHide' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('whatsapp_account'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isHide' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal78fc733786e0718cdf5e64f6023f5630)): ?>
<?php $attributes = $__attributesOriginal78fc733786e0718cdf5e64f6023f5630; ?>
<?php unset($__attributesOriginal78fc733786e0718cdf5e64f6023f5630); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal78fc733786e0718cdf5e64f6023f5630)): ?>
<?php $component = $__componentOriginal78fc733786e0718cdf5e64f6023f5630; ?>
<?php unset($__componentOriginal78fc733786e0718cdf5e64f6023f5630); ?>
<?php endif; ?>
                    </form>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Template ID'); ?></th>
                            <th><?php echo app('translator')->get('Template'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Created Date'); ?></th>
                            <th><?php echo app('translator')->get('Created Date'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $template): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(@$template->whatsapp_template_id); ?></td>
                                <td>
                                    <div class="dashboard-table__info">
                                        <span class="title"><?php echo e($template->name); ?></span>
                                        <br>
                                        <span class="text-muted fs-13"><?php echo e(strLimit($template->body, 40)); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <?php echo $template->verificationStatus() ?>
                                        <?php if($template->status ==  Status::TEMPLATE_PENDING): ?>
                                            <a href="<?php echo e(route('user.template.verification.check', $template->id)); ?>">
                                                <i class="las la-redo-alt"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td><?php echo e(showDateTime(@$template->created_at, 'd M Y')); ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button type="button" class="action-btn text--info copyTemplate"
                                            data-bs-toggle="tooltip" data-bs-title="Copy Template"
                                            data-name="<?php echo e($template->name); ?>">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'delete template']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'delete template']); ?>
                                            <button type="button" class="action-btn text--danger confirmationBtn"
                                                data-bs-toggle="tooltip" data-bs-title="Delete Template"
                                                data-action="<?php echo e(route('user.template.delete', $template->id)); ?>"
                                                data-question="<?php echo app('translator')->get('Are you sure to delete this template?'); ?>">
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
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks(@$templates)); ?>

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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .table tbody tr td:first-child {
            font-weight: unset !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.filter-form').find('select').on('change', function() {
                $('.filter-form').submit();
            });
            $('.copyTemplate').on('click', function() {
                let templateName = $(this).data('name');
                navigator.clipboard.writeText(templateName)
                    .then(() => {
                        notify('success', 'Template name copied to clipboard');
                    })
                    .catch(err => {
                        notify('error', 'Failed to copy template to clipboard');
                    });
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/template/index.blade.php ENDPATH**/ ?>