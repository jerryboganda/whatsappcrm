<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url' => '', 'variant', 'title', 'value', 'icon']));

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

foreach (array_filter((['url' => '', 'variant', 'title', 'value', 'icon']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>


<div class="widget-two widget widget--<?php echo e($variant); ?>">
    <a href="<?php echo e($url); ?>" class="widget-card-link"></a>
    <div class="widget-icon">
        <i class="<?php echo e($icon); ?>"></i>
    </div>
    <div class="widget-two__content">
        <p class="widget-title mb-2">
            <?php echo e($title); ?>

        </p>
        <h6 class="widget-amount">
            <?php echo e($value); ?>

        </h6>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/widget/two.blade.php ENDPATH**/ ?>