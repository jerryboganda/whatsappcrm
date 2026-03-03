<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['permission']));

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

foreach (array_filter((['permission']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if($permission): ?>
    <?php if(is_array($permission)): ?>
        <?php if($admin->hasAnyPermission($permission)): ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    <?php else: ?>
        <?php if($admin->can($permission)): ?>
            <?php echo e($slot); ?>

        <?php endif; ?>
    <?php endif; ?>
<?php else: ?>
    <?php echo e($slot); ?>

<?php endif; ?><?php /**PATH /var/www/html/core/resources/views/components/admin/permission_check.blade.php ENDPATH**/ ?>