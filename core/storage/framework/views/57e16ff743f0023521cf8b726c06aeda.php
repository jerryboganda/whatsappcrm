<?php $__env->startSection('content'); ?>
    <div class="container-fluid p-0">
        <div class="referral-wrapper">
            <div class="row">
                <div class="col-xxl-5 col-lg-8">
                    <div class="referral-wrapper__top">
                        <h5 class="referral-wrapper__title"><?php echo e(__(@$pageTitle)); ?></h5>
                        <p class="referral-wrapper__desc">
                            <?php echo app('translator')->get('Invite your friends to'); ?>
                            <span class="text--bold"> <?php echo e(gs('site_name')); ?> </span>
                            <?php echo app('translator')->get('and earn money for every successful referral.'); ?>
                        </p>
                    </div>
                    <div class="referral-card">
                        <p class="referral-card__title"> <?php echo app('translator')->get('Refer Link'); ?> </p>
                        <div class="form-group">
                            <label class="form--label label-two mb-3"><?php echo app('translator')->get('Share this link to invite others'); ?></label>
                            <input type="text" class="form--control form-two referral-link"
                                value="<?php echo e(route('home', ['reference' => auth()->user()->username])); ?>" readonly>
                        </div>
                        <button class="btn btn--white btn--sm copyBtn">
                            <?php echo app('translator')->get('Copy link'); ?> <span class="btn-icon ms-1"> <i class="far fa-copy"></i> </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <div class="flex-grow-1">
                    <div class="referral-item">
                        <div class="referral-item__top">
                            <h5 class="referral-item__title"><?php echo app('translator')->get('Total Referrals'); ?></h5>
                        </div>
                        <p class="referral-item__desc"><?php echo e($widget['total_referrals']); ?></p>
                        <div class="referral-item__shape">
                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/rf-1.png')); ?>" alt="shape">
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="referral-item">
                        <div class="referral-item__top">
                            <h5 class="referral-item__title"><?php echo app('translator')->get('Successful Referrals'); ?></h5>
                        </div>
                        <p class="referral-item__desc"><?php echo e($widget['successful_referrals']); ?></p>
                        <div class="referral-item__shape">
                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/rf-2.png')); ?>" alt="shape">
                        </div>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="referral-item">
                        <div class="referral-item__top">
                            <h5 class="referral-item__title"><?php echo app('translator')->get('Total Earning'); ?></h5>
                        </div>
                        <p class="referral-item__desc"><?php echo e(showAmount($widget['total_earning'])); ?></p>
                        <div class="referral-item__shape">
                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/rf-3.png')); ?>" alt="shape">
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-table">
                <h5 class="dashboard-table__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Email'); ?></th>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__(@$referral->fullName)); ?></td>
                                <td><?php echo e(showEmailAddress(@$referral->email)); ?></a></td>
                                <td><?php echo e(showDateTime(@$referral->created_at)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(@$referrals->links()); ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.copyBtn').on('click', function() {
                var copyText = $('.referral-link');
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                navigator.clipboard.writeText(copyText.value);
                notify('success', "<?php echo app('translator')->get('Link copied to clipboard'); ?>");
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/referral/history.blade.php ENDPATH**/ ?>