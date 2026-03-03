<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['widget']));

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

foreach (array_filter((['widget']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => route('admin.report.transaction'),'variant' => 'primary','title' => 'Total Transaction','value' => $widget['total_trx'],'icon' => 'la la-exchange-alt']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.report.transaction')),'variant' => 'primary','title' => 'Total Transaction','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['total_trx']),'icon' => 'la la-exchange-alt']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php
            $trxPlusLink = route('admin.report.transaction') . '?trx_type=' . urlencode(' + ');
        ?>
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => $trxPlusLink,'variant' => 'success','title' => 'Total Plus Transaction','value' => $widget['total_trx_plus'],'icon' => 'las la-plus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($trxPlusLink),'variant' => 'success','title' => 'Total Plus Transaction','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['total_trx_plus']),'icon' => 'las la-plus']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => route('admin.report.transaction') . '?trx_type=-','variant' => 'warning','title' => 'Total Minus Transaction','value' => $widget['total_trx_minus'],'icon' => 'las la-minus-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.report.transaction') . '?trx_type=-'),'variant' => 'warning','title' => 'Total Minus Transaction','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['total_trx_minus']),'icon' => 'las la-minus-circle']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => route('admin.report.transaction'),'variant' => 'primary','title' => 'Total Transaction Count','value' => $widget['total_trx_count'],'icon' => 'la la-exchange-alt','currency' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.report.transaction')),'variant' => 'primary','title' => 'Total Transaction Count','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['total_trx_count']),'icon' => 'la la-exchange-alt','currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/widget/group/dashboard/trx.blade.php ENDPATH**/ ?>