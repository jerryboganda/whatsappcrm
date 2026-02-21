<?php
    $whatsappAccounts = App\Models\WhatsappAccount::where('user_id', getParentUser()->id)->get();
    $defaultAccount = $whatsappAccounts->where('is_default', Status::YES)->first();
?>

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['isHide' => false]));

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

foreach (array_filter((['isHide' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(!$isHide || $whatsappAccounts->count() > 1): ?>
    <select class="form--control select2 form-two" required name="whatsapp_account_id">
        <?php $__currentLoopData = $whatsappAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $whatsappAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($whatsappAccount->id); ?>" <?php if($whatsappAccount->id == old('whatsapp_account_id', request()->whatsapp_account_id ?? $defaultAccount->id)): echo 'selected'; endif; ?>>
                <?php echo e(__($whatsappAccount->business_name)); ?> (<?php echo e($whatsappAccount->phone_number); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
<?php endif; ?>
<?php /**PATH /var/www/html/core/resources/views/components/whatsapp_account.blade.php ENDPATH**/ ?>