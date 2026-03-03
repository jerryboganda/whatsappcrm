<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Track performance and manage your transactions effortlessly.'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.deposit.index')); ?>" class="btn btn--base btn-shadow"> <i class="las la-plus"></i>
                        <?php echo app('translator')->get('New Deposit'); ?></a>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" name="search" value="<?php echo e(request()->search); ?>"
                            placeholder="<?php echo app('translator')->get('Search transactions...'); ?>" autocomplete="off">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
                <div class="body-top__right">
                    <span class="text"> <?php echo app('translator')->get('Filter by'); ?> : </span>
                    <form class="select-group filter-form">
                        <select class="form-select form--control select2" name="status">
                            <option value=""><?php echo app('translator')->get('Status'); ?></option>
                            <option value="<?php echo e(Status::PAYMENT_PENDING); ?>" <?php if(request()->status == Status::PAYMENT_PENDING): echo 'selected'; endif; ?>><?php echo app('translator')->get('Pending'); ?>
                            </option>
                            <option value="<?php echo e(Status::PAYMENT_SUCCESS); ?>" <?php if(request()->status == Status::PAYMENT_SUCCESS): echo 'selected'; endif; ?>><?php echo app('translator')->get('Success'); ?>
                            </option>
                            <option value="<?php echo e(Status::PAYMENT_REJECT); ?>" <?php if(request()->status == Status::PAYMENT_REJECT): echo 'selected'; endif; ?>><?php echo app('translator')->get('Rejected'); ?>
                            </option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Gateway | Transaction'); ?></th>
                            <th><?php echo app('translator')->get('Initiated'); ?></th>
                            <th><?php echo app('translator')->get('Amount'); ?></th>
                            <th><?php echo app('translator')->get('Conversion'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Details'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div>
                                        <span class="fw-bold">
                                            <span class="text-primary">
                                                <?php if($deposit->method_code < 5000): ?>
                                                    <?php echo e(__(@$deposit->gateway->name)); ?>

                                                <?php else: ?>
                                                    <?php echo app('translator')->get('Google Pay'); ?>
                                                <?php endif; ?>
                                            </span>
                                        </span>
                                        <br>
                                        <small> <?php echo e($deposit->trx); ?> </small>
                                    </div>
                                </td>

                                <td class="text-lg-center">
                                    <?php echo e(showDateTime($deposit->created_at)); ?><br><?php echo e(diffForHumans($deposit->created_at)); ?>

                                </td>
                                <td class="text-lg-center">
                                    <div><?php echo e(showAmount($deposit->amount)); ?> + <span class="text--danger"
                                            data-bs-toggle="tooltip"
                                            title="<?php echo app('translator')->get('Processing Charge'); ?>"><?php echo e(showAmount($deposit->charge)); ?>

                                        </span>
                                        <br>
                                        <strong data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Amount with charge'); ?>">
                                            <?php echo e(showAmount($deposit->amount + $deposit->charge)); ?>

                                        </strong>
                                    </div>
                                </td>
                                <td class="text-lg-center">
                                    <div>
                                        <?php echo e(showAmount(1)); ?> =
                                        <?php echo e(showAmount($deposit->rate, currencyFormat: false)); ?>

                                        <?php echo e(__($deposit->method_currency)); ?>

                                        <br>
                                        <strong><?php echo e(showAmount($deposit->final_amount, currencyFormat: false)); ?>

                                            <?php echo e(__($deposit->method_currency)); ?></strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php echo $deposit->statusBadge ?>
                                </td>
                                <?php
                                    $details = [];
                                    if ($deposit->method_code >= 1000 && $deposit->method_code <= 5000) {
                                        foreach (@$deposit->detail ?? [] as $key => $info) {
                                            $details[] = $info;
                                            if ($info->type == 'file') {
                                                $details[$key]->value = route(
                                                    'user.download.attachment',
                                                    encrypt(getFilePath('verify') . '/' . $info->value),
                                                );
                                            }
                                        }
                                    }
                                ?>
                                <td>
                                    <?php if($deposit->method_code >= 1000 && $deposit->method_code <= 5000): ?>
                                        <a href="javascript:void(0)" class="btn btn--base  detailBtn"
                                            data-info="<?php echo e(json_encode($details)); ?>"
                                            <?php if($deposit->status == Status::PAYMENT_REJECT): ?> data-admin_feedback="<?php echo e($deposit->admin_feedback); ?>" <?php endif; ?>>
                                            <i class="fas fa-desktop"></i>
                                        </a>
                                    <?php else: ?>
                                        <button type="button" class="btn btn--base" data-bs-toggle="tooltip"
                                            title="<?php echo app('translator')->get('Automatically processed'); ?>">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks($deposits)); ?>

        </div>
    </div>
    <!-- APPROVE MODAL -->
    <div id="detailModal" class="modal fade custom--modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Details'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="list-group userData  list-group-flush">
                    </ul>
                    <div class="feedback"></div>
                </div>
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
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');

                var userData = $(this).data('info');
                var html = '';
                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        } else {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span"><a href="${element.value}"><i class="fa-regular fa-file"></i> <?php echo app('translator')->get('Attachment'); ?></a></span>
                            </li>`;
                        }
                    });
                }

                modal.find('.userData').html(html);

                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong><?php echo app('translator')->get('Admin Feedback'); ?></strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }

                modal.find('.feedback').html(adminFeedback);


                modal.modal('show');
            });

            $('.filter-form').find('select').on('change', function() {
                $('.filter-form').submit();
            });

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title], [data-title], [data-bs-title]'))
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/deposit_history.blade.php ENDPATH**/ ?>