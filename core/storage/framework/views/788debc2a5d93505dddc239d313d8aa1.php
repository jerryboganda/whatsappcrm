<div class="table-header">
    <div class="table-search">
        <input form="filter-form" type="search" name="search" placeholder="<?php echo e($searchPlaceholder); ?>"
            value="<?php echo e(request()->search ?? ''); ?>" class="form-control form--control-sm">
        <button form="filter-form" type="submit" class="search-btn"> <i class="las la-search"></i> </button>
    </div>
    <div class="table-right">
        <?php if($renderExportButton): ?>
            <?php if (isset($component)) { $__componentOriginal5eefab7a903dec0617a50f42c7b1721b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5eefab7a903dec0617a50f42c7b1721b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.export_btn','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.export_btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5eefab7a903dec0617a50f42c7b1721b)): ?>
<?php $attributes = $__attributesOriginal5eefab7a903dec0617a50f42c7b1721b; ?>
<?php unset($__attributesOriginal5eefab7a903dec0617a50f42c7b1721b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5eefab7a903dec0617a50f42c7b1721b)): ?>
<?php $component = $__componentOriginal5eefab7a903dec0617a50f42c7b1721b; ?>
<?php unset($__componentOriginal5eefab7a903dec0617a50f42c7b1721b); ?>
<?php endif; ?>
        <?php endif; ?>
        <?php if($renderFilterOption): ?>
            <?php if (isset($component)) { $__componentOriginalda3e5cc80ce6c68f3c280b7cccc20298 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalda3e5cc80ce6c68f3c280b7cccc20298 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.filter_box','data' => ['filterBoxLocation' => $filterBoxLocation]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.filter_box'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['filterBoxLocation' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($filterBoxLocation)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalda3e5cc80ce6c68f3c280b7cccc20298)): ?>
<?php $attributes = $__attributesOriginalda3e5cc80ce6c68f3c280b7cccc20298; ?>
<?php unset($__attributesOriginalda3e5cc80ce6c68f3c280b7cccc20298); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalda3e5cc80ce6c68f3c280b7cccc20298)): ?>
<?php $component = $__componentOriginalda3e5cc80ce6c68f3c280b7cccc20298; ?>
<?php unset($__componentOriginalda3e5cc80ce6c68f3c280b7cccc20298); ?>
<?php endif; ?>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/table/filter.blade.php ENDPATH**/ ?>