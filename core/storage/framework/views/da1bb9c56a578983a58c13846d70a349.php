<?php
    $customCaptcha = loadCustomCaptcha();
    $googleCaptcha = loadReCaptcha();
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['isAdmin' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['isAdmin' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if($googleCaptcha): ?>
    <div class="mb-3">
        <?php echo $googleCaptcha ?>
    </div>
<?php endif; ?>

<?php if($customCaptcha): ?>
    <?php if($isAdmin): ?>
        <div class="form-group custom-captcha">
            <?php echo $customCaptcha ?>
        </div>
        <div class="form-group">
            <label for="password" class="form--label"><?php echo app('translator')->get('Captcha'); ?></label>
            <div class="position-relative">
                <input id="captcha" name="captcha" required type="captcha" class="form--control h-48">
                <span class="password-show-hide fas toggle-password fa-eye-slash" id="#password"></span>
            </div>
        </div>
    <?php else: ?>
        <div class="form-group">
            <div class="mb-2">
                <?php echo $customCaptcha ?>
            </div>
            <div>
                <label class="form-label"><?php echo app('translator')->get('Captcha'); ?></label>
                <input type="text" placeholder="<?php echo app('translator')->get('Enter the captcha'); ?>" name="captcha" class="form-control form--control" required>
            </div>
        </div>
    <?php endif; ?>

<?php endif; ?>
<?php if($googleCaptcha): ?>
    <?php $__env->startPush('script'); ?>
        <script>
            (function($) {
                "use strict"
                $('.verify-gcaptcha').on('submit', function() {
                    var response = grecaptcha.getResponse();
                    if (response.length == 0) {
                        document.getElementById('g-recaptcha-error').innerHTML =
                            '<span class="text--danger"><?php echo app('translator')->get('Captcha field is required.'); ?></span>';
                        return false;
                    }
                    return true;
                });

                window.verifyCaptcha = () => {
                    document.getElementById('g-recaptcha-error').innerHTML = '';
                }
            })(jQuery);
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/core/resources/views/partials/captcha.blade.php ENDPATH**/ ?>