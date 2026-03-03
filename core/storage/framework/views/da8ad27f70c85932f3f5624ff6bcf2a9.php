<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Configure your payment gateway credentials to generate payment links'); ?>
                </p>
            </div>
        </div>
        <div class="dashboard-container__body dis-block">
            <div class="row gy-4">
                
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg--primary text-white">
                            <h5 class="card-title m-0 p-2 text-white"><?php echo app('translator')->get('Stripe Configuration'); ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('user.payment.config.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="gateway_name" value="stripe">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Enable Stripe'); ?></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            <?php if(@$stripe->status): echo 'checked'; endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Publishable Key'); ?></label>
                                    <input type="text" class="form--control" name="stripe_publishable_key"
                                        value="<?php echo e(@$stripe->credentials_json['publishable_key']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Secret Key'); ?></label>
                                    <input type="text" class="form--control" name="stripe_secret_key"
                                        value="<?php echo e(@$stripe->credentials_json['secret_key']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Save Stripe Settings'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg--warning text-white">
                            <h5 class="card-title m-0 p-2 text-white"><?php echo app('translator')->get('Razorpay Configuration'); ?></h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('user.payment.config.store')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="gateway_name" value="razorpay">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Enable Razorpay'); ?></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" value="1"
                                            <?php if(@$razorpay->status): echo 'checked'; endif; ?>>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Key ID'); ?></label>
                                    <input type="text" class="form--control" name="razorpay_key_id"
                                        value="<?php echo e(@$razorpay->credentials_json['key_id']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Key Secret'); ?></label>
                                    <input type="text" class="form--control" name="razorpay_key_secret"
                                        value="<?php echo e(@$razorpay->credentials_json['key_secret']); ?>" required>
                                </div>
                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Save Razorpay Settings'); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/payment/config.blade.php ENDPATH**/ ?>