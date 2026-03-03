<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['user']));

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

foreach (array_filter((['user']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<?php if($user): ?>
    <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
        <span class="table-thumb d-none d-lg-block">
            <?php if(@$user->image): ?>
                <img src="<?php echo e($user->image_src); ?>" alt="user">
            <?php else: ?>
                <span class="name-short-form">
                    <?php echo e(__(@$user->full_name_short_form ?? 'N/A')); ?>

                </span>
            <?php endif; ?>
        </span>
        <div>
            <strong class="d-block">
                <?php echo e(__(@$user->fullname)); ?>

            </strong>
            <a class="fs-13" href="<?php echo e(route('admin.users.detail', $user->id)); ?>"><?php echo e(@$user->username); ?></a>
        </div>
    </div>
<?php else: ?>
    <span><?php echo app('translator')->get('N/A'); ?></span>
<?php endif; ?>
<?php /**PATH /var/www/html/core/resources/views/components/admin/other/user_info.blade.php ENDPATH**/ ?>