<?php
    $request = request();
?>

<form action="" id="filter-form" >
    <div class="form-group">
        <label class="form-label"><?php echo app('translator')->get('Priority'); ?></label>
        <select class="form-select select2" name="priority" data-minimum-results-for-search="-1">
            <option value=""><?php echo app('translator')->get('All'); ?></option>
            <option value="<?php echo e(Status::PRIORITY_HIGH); ?>"<?php if($request->priority == Status::PRIORITY_HIGH): echo 'selected'; endif; ?>><?php echo app('translator')->get('High'); ?></option>
            <option value="<?php echo e(Status::PRIORITY_MEDIUM); ?>"<?php if($request->priority == Status::PRIORITY_MEDIUM): echo 'selected'; endif; ?>><?php echo app('translator')->get('Medium'); ?></option>
            <option value="<?php echo e(Status::PRIORITY_LOW); ?>"<?php if($request->priority == Status::PRIORITY_LOW): echo 'selected'; endif; ?>><?php echo app('translator')->get('Low'); ?></option>
        </select>
    </div>
    <?php if($request->routeIs('admin.ticket.index')): ?>
        <div class="form-group">
            <label class="form-label"><?php echo app('translator')->get('Status'); ?></label>
            <select class="form-select select2" name="status" data-minimum-results-for-search="-1">
                <option value=""><?php echo app('translator')->get('All'); ?></option>
                <option value="<?php echo e(Status::TICKET_OPEN); ?>" <?php if(Status::TICKET_OPEN == $request->status && !is_null($request->status)): echo 'selected'; endif; ?>><?php echo app('translator')->get('Open'); ?></option>
                <option value="<?php echo e(Status::TICKET_ANSWER); ?>"<?php if($request->status == Status::TICKET_ANSWER): echo 'selected'; endif; ?>><?php echo app('translator')->get('Answer'); ?></option>
                <option value="<?php echo e(Status::TICKET_REPLY); ?>"<?php if($request->status == Status::TICKET_REPLY): echo 'selected'; endif; ?>><?php echo app('translator')->get('Reply'); ?></option>
                <option value="<?php echo e(Status::TICKET_CLOSE); ?>"<?php if($request->status == Status::TICKET_CLOSE): echo 'selected'; endif; ?>><?php echo app('translator')->get('Close'); ?></option>
            </select>
        </div>
    <?php endif; ?>
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
<?php /**PATH /var/www/html/core/resources/views/admin/support/filter_form.blade.php ENDPATH**/ ?>