<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url', 'variant', 'title', 'value', 'icon', 'isFooter' => false, 'currency' => true]));

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

foreach (array_filter((['url', 'variant', 'title', 'value', 'icon', 'isFooter' => false, 'currency' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="widget widget-four widget--<?php echo e($variant); ?> h-100">
    <a href="<?php echo e($url); ?>" class="widget-card-link"></a>
    <div class="widget-inner widget-four-shape overflow-hidden position-relative">
        <div class="mb-3 d-flex align-items-center gap-2">
            <span class="widget-icon">
                <i class="<?php echo e($icon); ?>"></i>
            </span>
            <p class="widget-title">
                <?php echo e(__($title)); ?>

            </p>
        </div>
        <h6 class="widget-amount">
            <?php if($currency): ?>
                <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($value, currencyFormat: false)); ?>

                <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
            <?php else: ?>
                <span><?php echo e($value); ?></span>
            <?php endif; ?>
        </h6>
    </div>
    <?php if($isFooter): ?>
        <div class="widget-footer footer-bg-default">
            <span class="widget-footer__text"><?php echo app('translator')->get('View'); ?> </span>
            <span class="widget-footer__icon"><i class="far fa-arrow-alt-circle-right"></i></span>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/widget/four.blade.php ENDPATH**/ ?>