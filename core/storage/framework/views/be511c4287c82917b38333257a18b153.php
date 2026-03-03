<?php $__env->startSection('content'); ?>
    <main class="account">
        <span class="account__overlay bg-img dark-bg"
            data-background-image="<?php echo e(asset('assets/admin/images/login-dark.png')); ?>"></span>
        <span class="account__overlay bg-img light-bg"
            data-background-image="<?php echo e(asset('assets/admin/images/login-bg.png')); ?>"></span>
        <div class="account__card">
            <div class="account__logo">
                <img src="<?php echo e(siteLogo()); ?>" class="light-show" alt="brand-thumb">
                <img src="<?php echo e(siteLogo('dark')); ?>" class="dark-show" alt="brand-thumb">
            </div>
            <h2 class="account__title"><?php echo app('translator')->get('Welcome Back'); ?> 👋</h2>
            <p class="account__desc"><?php echo app('translator')->get('Please enter your credentials to proceed to the next step.'); ?></p>
            <form action="<?php echo e(route('admin.login')); ?>" method="POST" class="account__form verify-gcaptcha">
                <?php echo csrf_field(); ?>
                <div class="form-group">
                    <label class="form--label"><?php echo app('translator')->get('Username'); ?></label>
                    <input type="text" class="form--control h-48" value="<?php echo e(old('username')); ?>" name="username" required>
                </div>
                <div class="form-group">
                    <label  class="form--label"><?php echo app('translator')->get('Password'); ?></label>
                    <div class="position-relative">
                        <input id="password" name="password" required type="password" class="form--control h-48">
                        <span class="password-show-hide fas toggle-password fa-eye-slash" id="#password"></span>
                    </div>
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
<?php $component->withAttributes(['isAdmin' => true]); ?>
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
                    <button type="submit" class="btn btn--primary w-100  h-48 mb-2 fs-16">
                        <i class="fa-solid fa-arrow-right-to-bracket"></i> <?php echo app('translator')->get('Login'); ?>
                    </button>
                    <a href="<?php echo e(route('admin.password.reset')); ?>" class="forgot-password">
                        <?php echo app('translator')->get('Forgot your password'); ?>?
                    </a>
                </div>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>