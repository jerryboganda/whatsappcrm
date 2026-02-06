<?php
    $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
?>
<?php if($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie')): ?>
    <div class="cookies-card hide">
        <div class="cookies-card__header">
            <div class="cookies-card__icon">
                <i class="las la-cookie-bite"></i>
            </div>
        </div>
        <p class="cookies-card__content">
            <?php echo e(__($cookie->data_values->short_desc)); ?>

        </p>
        <div class="cookies-card__footer">
            <a href="<?php echo e(route('cookie.policy')); ?>" class="cookies-card__btn-outline btn btn-outline--base"><?php echo app('translator')->get('View More'); ?></a>
            <button type="button"  class="cookies-card__btn policy btn btn--base"><?php echo app('translator')->get('Accept All'); ?></button>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/partials/cookie.blade.php ENDPATH**/ ?>