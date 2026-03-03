<?php $__env->startSection('content'); ?>
    <section class="py-100 policy-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php echo $policy->data_values->details ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .policy-content p,.policy-content li {
            color: hsl(var(--body-color)/0.7);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/policy.blade.php ENDPATH**/ ?>