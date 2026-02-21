<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Manage your campaigns and explore performance stats right here'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.campaign.create')); ?>" class="btn btn--base btn-shadow">
                        <i class="las la-plus"></i>
                        <?php echo app('translator')->get('Add New'); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" placeholder="<?php echo app('translator')->get('Search here'); ?>..." name="search"
                            autocomplete="off" value="<?php echo e(request()->search); ?>">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
                <div class="body-top__right">
                    <form class="select-group filter-form">
                        <select class="form-select form--control select2" name="status">
                            <option selected value=""><?php echo app('translator')->get('Filter Campaign Status'); ?></option>
                            <option value="<?php echo e(Status::CAMPAIGN_INIT); ?>" <?php if(request()->status == (string) Status::CAMPAIGN_INIT): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Init'); ?>
                            </option>
                            <option value="<?php echo e(Status::CAMPAIGN_COMPLETED); ?>" <?php if(request()->status == Status::CAMPAIGN_COMPLETED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Completed'); ?>
                            </option>
                            <option value="<?php echo e(Status::CAMPAIGN_RUNNING); ?>" <?php if(request()->status == Status::CAMPAIGN_RUNNING): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Running'); ?>
                            </option>
                            <option value="<?php echo e(Status::CAMPAIGN_SCHEDULED); ?>" <?php if(request()->status == Status::CAMPAIGN_SCHEDULED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Scheduled'); ?>
                            </option>
                            <option value="<?php echo e(Status::CAMPAIGN_FAILED); ?>" <?php if(request()->status == Status::CAMPAIGN_FAILED): echo 'selected'; endif; ?>>
                                <?php echo app('translator')->get('Failed'); ?>
                            </option>
                        </select>
                        
                        <select class="form-select form--control select2" name="export">
                            <option selected value=""><?php echo app('translator')->get('Export'); ?></option>
                            <option value="excel">
                                <?php echo app('translator')->get('Excel'); ?>
                            </option>
                            <option value="csv">
                                <?php echo app('translator')->get('CSV'); ?>
                            </option>
                            <option value="pdf">
                                <?php echo app('translator')->get('PDF'); ?>
                            </option>
                            <option value="print">
                                <?php echo app('translator')->get('Print'); ?>
                            </option>
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
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Title'); ?></th>
                            <th><?php echo app('translator')->get('Message'); ?></th>
                            <th><?php echo app('translator')->get('Sent Message'); ?></th>
                            <th><?php echo app('translator')->get('Success Message'); ?></th>
                            <th><?php echo app('translator')->get('Failed Message'); ?></th>
                            <th><?php echo app('translator')->get('Campaign Date'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaign): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__(@$campaign->title)); ?></td>
                                <td><?php echo e(@$campaign->total_message); ?></td>
                                <td><?php echo e(@$campaign->total_send); ?></td>
                                <td><?php echo e(@$campaign->total_success); ?></td>
                                <td><?php echo e(@$campaign->total_failed); ?></td>
                                <td>
                                    <?php echo e(showDateTime($campaign->send_at)); ?><br><?php echo e(diffForHumans($campaign->send_at)); ?>

                                </td>
                                <td>
                                    <?php echo $campaign->statusBadge ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('user.campaign.report', $campaign->id)); ?>"
                                        class="btn btn--base btn-shadow btn--sm">
                                        <i class=" la la-chart-bar"></i> <?php echo app('translator')->get('View Report'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks(@$campaigns)); ?>

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
        (function($) {
            "use strict";

            $('.filter-form').find('select').on('change', function() {
                $('.filter-form').submit();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/campaign/index.blade.php ENDPATH**/ ?>