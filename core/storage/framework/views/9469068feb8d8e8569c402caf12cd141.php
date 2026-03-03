<div class="table-filter">
    <div class=" dropdown">
        <button class="btn btn-outline--secondary w-100  dropdown-toggle" type="button" data-bs-toggle="dropdown"
            data-bs-auto-close="outside">
            <span class="icon">
                <i class="las la-sort"></i>
            </span>
            <?php echo app('translator')->get('Filter'); ?>
        </button>
        <div class="dropdown-menu dropdown-menu-filter-box">
            <?php if(!$filterBoxLocation): ?>
                <?php
                    $request = request();
                ?>
                <form action="" id="filter-form">
                    <?php if (isset($component)) { $__componentOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.other.order_by','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.other.order_by'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d)): ?>
<?php $attributes = $__attributesOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d; ?>
<?php unset($__attributesOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d)): ?>
<?php $component = $__componentOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d; ?>
<?php unset($__componentOriginalca2d703a0aa389ba3ca7f4fe25aa0f6d); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginalf8b341359be844fa9261d788d750c77d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8b341359be844fa9261d788d750c77d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.other.per_page_record','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.other.per_page_record'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8b341359be844fa9261d788d750c77d)): ?>
<?php $attributes = $__attributesOriginalf8b341359be844fa9261d788d750c77d; ?>
<?php unset($__attributesOriginalf8b341359be844fa9261d788d750c77d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8b341359be844fa9261d788d750c77d)): ?>
<?php $component = $__componentOriginalf8b341359be844fa9261d788d750c77d; ?>
<?php unset($__componentOriginalf8b341359be844fa9261d788d750c77d); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal03bfe64b476d61f3ab8da4a85401039e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal03bfe64b476d61f3ab8da4a85401039e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.other.filter_dropdown_btn','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.other.filter_dropdown_btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal03bfe64b476d61f3ab8da4a85401039e)): ?>
<?php $attributes = $__attributesOriginal03bfe64b476d61f3ab8da4a85401039e; ?>
<?php unset($__attributesOriginal03bfe64b476d61f3ab8da4a85401039e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal03bfe64b476d61f3ab8da4a85401039e)): ?>
<?php $component = $__componentOriginal03bfe64b476d61f3ab8da4a85401039e; ?>
<?php unset($__componentOriginal03bfe64b476d61f3ab8da4a85401039e); ?>
<?php endif; ?>
                </form>
            <?php else: ?>
                <?php echo $__env->make("admin.$filterBoxLocation", array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/table/filter_box.blade.php ENDPATH**/ ?>