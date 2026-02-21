
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Account'); ?></th>
                                    <th><?php echo app('translator')->get('Budget'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Meta Campaign ID'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td data-label="<?php echo app('translator')->get('Name'); ?>">
                                            <span class="fw-bold"><?php echo e(__($ad->name)); ?></span>
                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Account'); ?>">
                                            <?php echo e(__($ad->account->name)); ?>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Budget'); ?>">
                                            <?php echo e(showAmount($ad->budget)); ?>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Status'); ?>">
                                            <?php if($ad->status == 'ACTIVE'): ?>
                                                <span class="badge badge--success"><?php echo app('translator')->get('Active'); ?></span>
                                            <?php elseif($ad->status == 'PAUSED'): ?>
                                                <span class="badge badge--warning"><?php echo app('translator')->get('Paused'); ?></span>
                                            <?php else: ?>
                                                <span class="badge badge--dark"><?php echo e($ad->status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Meta Campaign ID'); ?>">
                                            <?php echo e($ad->campaign_id); ?>

                                        </td>
                                        <td data-label="<?php echo app('translator')->get('Action'); ?>">
                                            <a href="https://adsmanager.facebook.com/adsmanager/manage/campaigns?act=<?php echo e($ad->account->account_id); ?>"
                                                target="_blank" class="btn btn-sm btn--primary">
                                                <i class="las la-external-link-alt"></i> <?php echo app('translator')->get('View in Meta'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($ads->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($ads)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <a href="<?php echo e(route('user.ads.connect')); ?>" class="btn btn-outline--info btn--sm h-45 me-2">
        <i class="las la-plug"></i> <?php echo app('translator')->get('Connect Account'); ?>
    </a>
    <a href="<?php echo e(route('user.ads.create')); ?>" class="btn btn-sm btn--primary h-45">
        <i class="las la-plus"></i> <?php echo app('translator')->get('Create Ad'); ?>
    </a>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/ads/index.blade.php ENDPATH**/ ?>