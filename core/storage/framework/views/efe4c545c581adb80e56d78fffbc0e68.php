<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'renderTableFilter' => true,
    'renderExportButton' => true,
    'renderFilterOption' => true,
    'filterBoxLocation' => null,
    'searchPlaceholder' => 'Search here',
]));

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

foreach (array_filter(([
    'renderTableFilter' => true,
    'renderExportButton' => true,
    'renderFilterOption' => true,
    'filterBoxLocation' => null,
    'searchPlaceholder' => 'Search here',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="table-layout">
    <?php if($renderTableFilter): ?>
        <?php if (isset($component)) { $__componentOriginal0dfb0934d55b76629ed164356f26e874 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0dfb0934d55b76629ed164356f26e874 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.filter','data' => ['renderExportButton' => $renderExportButton,'renderFilterOption' => $renderFilterOption,'searchPlaceholder' => $searchPlaceholder,'filterBoxLocation' => $filterBoxLocation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.filter'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['renderExportButton' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($renderExportButton),'renderFilterOption' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($renderFilterOption),'searchPlaceholder' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($searchPlaceholder),'filterBoxLocation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterBoxLocation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0dfb0934d55b76629ed164356f26e874)): ?>
<?php $attributes = $__attributesOriginal0dfb0934d55b76629ed164356f26e874; ?>
<?php unset($__attributesOriginal0dfb0934d55b76629ed164356f26e874); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0dfb0934d55b76629ed164356f26e874)): ?>
<?php $component = $__componentOriginal0dfb0934d55b76629ed164356f26e874; ?>
<?php unset($__componentOriginal0dfb0934d55b76629ed164356f26e874); ?>
<?php endif; ?>
    <?php endif; ?>
    <?php echo e($slot); ?>

</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/table/layout.blade.php ENDPATH**/ ?>