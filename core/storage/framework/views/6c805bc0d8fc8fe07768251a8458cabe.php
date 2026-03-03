<?php
    $authContent = @getContent('auth.content', true)->data_values;
?>

<?php $__env->startSection('content'); ?>
    <?php if(gs('registration')): ?>
        <section class="account mb-100 section-shape banner-bg">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-10">
                        <div class="account-inner">
                            <div class="row">
                                <div class="col-lg-6  d-lg-block d-none">
                                    <div class="account-thumb">
                                        <img src="<?php echo e(frontendImage('auth', @$authContent->register_image)); ?>" alt="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="account-form">
                                        <div class="account-form__content mb-4">
                                            <h3 class="account-form__title mb-2" data-highlight="[-1]">
                                                <?php echo e(__(@$authContent->register_title)); ?></h3>
                                            <p class="account-form__desc"><?php echo e(__(@$authContent->register_subtitle)); ?></p>
                                        </div>
                                        <form action="<?php echo e(route('user.register')); ?>" method="POST" class="verify-gcaptcha">
                                            <?php echo csrf_field(); ?>
                                            <div class="row gy-2">
                                                <?php if(session()->get('reference') != null): ?>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <label for="referenceBy"
                                                                class="form-label"><?php echo app('translator')->get('Reference By'); ?></label>
                                                            <input type="text" name="referBy" id="referenceBy"
                                                                class="form--control"
                                                                value="<?php echo e(session()->get('reference')); ?>" readonly>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->get('First Name'); ?></label>
                                                        <input type="text" class="form--control" name="firstname"
                                                            placeholder="<?php echo app('translator')->get('Enter your first name'); ?>" value="<?php echo e(old('firstname')); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->get('Last Name'); ?></label>
                                                        <input type="text" class="form--control" name="lastname"
                                                            placeholder="<?php echo app('translator')->get('Enter your last name'); ?>" value="<?php echo e(old('lastname')); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->get('Your Email'); ?></label>
                                                        <input type="email" class="form--control checkUser" name="email"
                                                            placeholder="<?php echo app('translator')->get('Enter your email'); ?>" value="<?php echo e(old('email')); ?>"
                                                            required>
                                                        <span class="exists-error d-none"></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->get('Password'); ?></label>
                                                        <div class="position-relative">
                                                            <input type="password" class="form-control form--control"
                                                                name="password" placeholder="<?php echo app('translator')->get('Enter your password'); ?>" required>
                                                            <span
                                                                class="password-show-hide fas fa-solid toggle-password fa-eye-slash"></span>
                                                            <?php if (isset($component)) { $__componentOriginal0a4cf56c717a19c59c80d2658da91f8f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a4cf56c717a19c59c80d2658da91f8f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.strong-password','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('strong-password'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a4cf56c717a19c59c80d2658da91f8f)): ?>
<?php $attributes = $__attributesOriginal0a4cf56c717a19c59c80d2658da91f8f; ?>
<?php unset($__attributesOriginal0a4cf56c717a19c59c80d2658da91f8f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a4cf56c717a19c59c80d2658da91f8f)): ?>
<?php $component = $__componentOriginal0a4cf56c717a19c59c80d2658da91f8f; ?>
<?php unset($__componentOriginal0a4cf56c717a19c59c80d2658da91f8f); ?>
<?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label><?php echo app('translator')->get('Confirm Password'); ?></label>
                                                        <div class="position-relative">
                                                            <input type="password" class="form-control form--control"
                                                                name="password_confirmation"
                                                                placeholder="<?php echo app('translator')->get('Confirm your password'); ?>" required>
                                                            <div
                                                                class="password-show-hide fas fa-solid toggle-password fa-eye-slash">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if(gs('agree')): ?>
                                                    <?php
                                                        $policyPages = getContent(
                                                            'policy_pages.element',
                                                            false,
                                                            orderById: true,
                                                        );
                                                    ?>
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <div class="form--check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="agree" id="agree">
                                                                <div class="form-check-label">
                                                                    <label for="agree" <?php if(old('agree')): echo 'checked'; endif; ?>
                                                                        name="agree"> <?php echo app('translator')->get('I agree to the'); ?> </label>
                                                                    <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <a href="<?php echo e(route('policy.pages', $policy->slug)); ?>"
                                                                            target="_blank"><?php echo e(__($policy->data_values->title)); ?></a>
                                                                        <?php if(!$loop->last): ?>
                                                                            ,
                                                                        <?php endif; ?>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
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
                                                    <button type="submit" class="btn btn--base w-100">
                                                        <?php echo app('translator')->get('Create New Account'); ?>
                                                    </button>
                                                </div>
                                                <?php echo $__env->make($activeTemplate . 'partials.social_login', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                                <div class="col-sm-12">
                                                    <div class="have-account">
                                                        <p class="have-account__text">
                                                            <?php echo app('translator')->get('Already Have An Account?'); ?>
                                                            <a href="<?php echo e(route('user.login')); ?>"
                                                                class="have-account__link text--base">
                                                                <?php echo app('translator')->get('Login in here'); ?>
                                                            </a>
                                                        </p>
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
    <?php else: ?>
        <?php echo $__env->make($activeTemplate . 'partials.registration_disabled', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

<?php $__env->stopSection(); ?>

<?php if(gs('registration')): ?>
    <?php $__env->startPush('script'); ?>
        <script>
            "use strict";
            (function($) {

                $('.checkUser').on('focusout', function(e) {
                    var url = "<?php echo e(route('user.checkUser')); ?>";
                    var value = $(this).val();
                    var token = '<?php echo e(csrf_token()); ?>';

                    var data = {
                        email: value,
                        _token: token
                    }

                    $.post(url, data, function(response) {
                        if (response.data == true) {
                            $(".exists-error").html(`
                                <?php echo app('translator')->get('You’re already part of our community!'); ?>
                                <a class="ms-1" href="<?php echo e(route('user.login')); ?>"><?php echo app('translator')->get('Login now'); ?></a>
                            `).removeClass('d-none').addClass("text--danger mt-1 d-block");
                            $(`button[type=submit]`).attr('disabled', true).addClass('disabled');
                        } else {
                            $(".exists-error").empty().addClass('d-none').removeClass(
                                "text--danger mt-1 d-block");
                            $(`button[type=submit]`).attr('disabled', false).removeClass('disabled');
                        }
                    });
                });
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/auth/register.blade.php ENDPATH**/ ?>