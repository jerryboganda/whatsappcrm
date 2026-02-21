<?php
    $authContent = @getContent('auth.content', true)->data_values;
?>

<?php $__env->startSection('content'); ?>
    <section class="account mb-100 section-shape banner-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="account-inner">
                        <div class="row">
                            <div class="col-lg-6  d-lg-block d-none">
                                <div class="account-thumb">
                                    <img src="<?php echo e(frontendImage('auth', @$authContent->login_image)); ?>" alt="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="account-form">
                                    <div class="account-form__content mb-4">
                                        <h3 class="account-form__title mb-2"><?php echo e(__(@$authContent->login_title)); ?></h3>
                                        <p class="account-form__desc"><?php echo e(__(@$authContent->login_subtitle)); ?></p>
                                    </div>
                                    <form action="<?php echo e(route('user.login')); ?>" method="POST" class="verify-gcaptcha">
                                        <?php echo csrf_field(); ?>
                                        <div class="row gy-2">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Username'); ?></label>
                                                    <input type="text" class="form--control" name="username"
                                                        placeholder="<?php echo app('translator')->get('Enter your username or email'); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label><?php echo app('translator')->get('Password'); ?></label>
                                                    <div class="position-relative">
                                                        <input type="password" class="form-control form--control"
                                                            name="password" placeholder="<?php echo app('translator')->get('Enter your password'); ?>" required>
                                                        <span
                                                            class="password-show-hide fas toggle-password fa-eye-slash"></span>
                                                    </div>
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
                                            <div class="col-sm-12">
                                                <div class="d-flex flex-wrap justify-content-between form-group">
                                                    <div class="form--check">
                                                        <input class="form-check-input" type="checkbox" id="remember"
                                                            <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                        <label class="form-check-label"
                                                            for="remember"><?php echo app('translator')->get('Keep me logged in'); ?></label>
                                                    </div>
                                                    <p class="forgot-password">
                                                        <a href="<?php echo e(route('user.password.request')); ?>"
                                                            class="forgot-password__link text--base"><?php echo app('translator')->get('Forgot Your Password?'); ?>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <button type="submit"
                                                    class="btn btn--base w-100"><?php echo app('translator')->get('Sign In'); ?></button>
                                            </div>
                                            <?php echo $__env->make($activeTemplate . 'partials.social_login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            <div class="col-sm-12">
                                                <div class="have-account">
                                                    <p class="have-account__text"><?php echo app('translator')->get('Don\'t Have An Account?'); ?> <a
                                                            href="<?php echo e(route('user.register')); ?>"
                                                            class="have-account__link text--base"><?php echo app('translator')->get('Register here'); ?></a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/auth/login.blade.php ENDPATH**/ ?>