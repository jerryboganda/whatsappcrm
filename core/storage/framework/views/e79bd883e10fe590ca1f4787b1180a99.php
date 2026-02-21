
<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Manage your incoming WhatsApp orders'); ?></p>
            </div>
        </div>
        <div class="dashboard-container__body">

            <div class="row align-items-center mb-30 justify-content-end">
                <div class="col-md-6">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control form--control"
                                value="<?php echo e(request()->search); ?>" placeholder="<?php echo app('translator')->get('Search by Order ID, Name, Mobile'); ?>">
                            <select name="status" class="form-control form--control input-group-text">
                                <option value=""><?php echo app('translator')->get('All Status'); ?></option>
                                <option value="pending" <?php if(request()->status == 'pending'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Pending'); ?></option>
                                <option value="paid" <?php if(request()->status == 'paid'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Paid'); ?></option>
                                <option value="shipped" <?php if(request()->status == 'shipped'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Shipped'); ?></option>
                                <option value="completed" <?php if(request()->status == 'completed'): echo 'selected'; endif; ?>><?php echo app('translator')->get('Completed'); ?>
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
                            <th><?php echo app('translator')->get('Order ID'); ?></th>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                            <th><?php echo app('translator')->get('Contact'); ?></th>
                            <th><?php echo app('translator')->get('Products'); ?></th>
                            <th><?php echo app('translator')->get('Amount'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>#<?php echo e($order->id); ?></td>
                                <td>
                                    <?php echo e(showDateTime($order->created_at)); ?><br><?php echo e(diffForHumans($order->created_at)); ?>

                                </td>
                                <td>
                                    <?php echo e(@$order->contact->firstname); ?> <br>
                                    <small><?php echo e(@$order->contact->mobile); ?></small>
                                </td>
                                <td>
                                    <?php echo e(count($order->products_json ?? [])); ?> <?php echo app('translator')->get('Items'); ?>
                                </td>
                                <td>
                                    <?php echo e($order->currency); ?> <?php echo e(getAmount($order->amount)); ?>

                                </td>
                                <td>
                                    <?php if($order->status == 'pending'): ?>
                                        <span class="badge badge--warning"><?php echo app('translator')->get('Pending'); ?></span>
                                    <?php elseif($order->status == 'paid'): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Paid'); ?></span>
                                    <?php elseif($order->status == 'shipped'): ?>
                                        <span class="badge badge--primary"><?php echo app('translator')->get('Shipped'); ?></span>
                                    <?php elseif($order->status == 'completed'): ?>
                                        <span class="badge badge--dark"><?php echo app('translator')->get('Completed'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--secondary"><?php echo e($order->status); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('user.orders.details', $order->id)); ?>"
                                        class="btn btn--primary btn--sm btn-shadow me-2">
                                        <i class="las la-desktop"></i> <?php echo app('translator')->get('Details'); ?>
                                    </a>
                                    <button class="btn btn--base btn-shadow btn--sm statusBtn" data-id="<?php echo e($order->id); ?>"
                                        data-status="<?php echo e($order->status); ?>">
                                        <i class="las la-edit"></i> <?php echo app('translator')->get('Update Status'); ?>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks(@$orders)); ?>

        </div>
    </div>

    
    <div id="statusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Update Order Status'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('user.orders.status')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="id">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Status'); ?></label>
                            <select name="status" class="form-control form--control">
                                <option value="pending"><?php echo app('translator')->get('Pending'); ?></option>
                                <option value="paid"><?php echo app('translator')->get('Paid'); ?></option>
                                <option value="shipped"><?php echo app('translator')->get('Shipped'); ?></option>
                                <option value="completed"><?php echo app('translator')->get('Completed'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--base"><?php echo app('translator')->get('Update'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/orders/index.blade.php ENDPATH**/ ?>