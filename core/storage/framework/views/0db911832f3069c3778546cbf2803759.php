<?php $__env->startSection('content'); ?>
    <div class="verification-section banner-bg">
        <div class="container">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <div class="card custom--card">
                        <div class="card-header">
                            <h5 class="card-title"><?php echo e(__($pageTitle)); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <p><?php echo app('translator')->get('To recover your account please provide your email or username to find your account.'); ?></p>
                            </div>
                            <form method="POST" action="<?php echo e(route('user.password.email')); ?>" class="verify-gcaptcha">
                                <?php echo csrf_field(); ?>
                                <div class="form-group">
                                    <label class="form-label"><?php echo app('translator')->get('Email or Username'); ?></label>
                                    <input type="text" class="form--control" name="value" value="<?php echo e(old('value')); ?>"
                                        required autofocus="off">
                                </div>
                                <?php if (isset($component)) { $__componentOriginalff0a9fdc5428085522b49c68070c11d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff0a9fdc5428085522b49c68070c11d6 = $attributes; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Captcha::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $attributes = $__attributesOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $component = $__componentOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__componentOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
                                <div class="form-group">
                                    <button type="submit" class="btn btn--base w-100 btn-shadow">
                                        <i class="fa fa-paper-plane"></i> <?php echo app('translator')->get('Submit'); ?>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/auth/passwords/email.blade.php ENDPATH**/ ?>