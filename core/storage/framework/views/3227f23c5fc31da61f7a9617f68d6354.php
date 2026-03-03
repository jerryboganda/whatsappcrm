<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-12">
            <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => ['class' => 'table-has-filter']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'table-has-filter']); ?>
                <?php if (isset($component)) { $__componentOriginal82a520cb144a92d0fb68c226771dfec2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82a520cb144a92d0fb68c226771dfec2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.body','data' => ['paddingZero' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['paddingZero' => true]); ?>
                    <?php if (isset($component)) { $__componentOriginal461e4ac3a9de43e934a2cb2cfdbe0e04 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal461e4ac3a9de43e934a2cb2cfdbe0e04 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.layout','data' => ['searchPlaceholder' => 'Search here...','filterBoxLocation' => 'support.filter_form']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['searchPlaceholder' => 'Search here...','filterBoxLocation' => 'support.filter_form']); ?>
                        <?php if (isset($component)) { $__componentOriginal722fc7edbde74caa9ff525bc9925b331 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal722fc7edbde74caa9ff525bc9925b331 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <?php if (isset($component)) { $__componentOriginal344b831e266bcf29cb71c71c2b1836d8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal344b831e266bcf29cb71c71c2b1836d8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <tr>
                                    <th><?php echo app('translator')->get('Submitted By'); ?></th>
                                    <th><?php echo app('translator')->get('Subject'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Priority'); ?></th>
                                    <th><?php echo app('translator')->get('Last Reply'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal344b831e266bcf29cb71c71c2b1836d8)): ?>
<?php $attributes = $__attributesOriginal344b831e266bcf29cb71c71c2b1836d8; ?>
<?php unset($__attributesOriginal344b831e266bcf29cb71c71c2b1836d8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal344b831e266bcf29cb71c71c2b1836d8)): ?>
<?php $component = $__componentOriginal344b831e266bcf29cb71c71c2b1836d8; ?>
<?php unset($__componentOriginal344b831e266bcf29cb71c71c2b1836d8); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginal82bf14a097ac19d287efa51303ee5eb9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82bf14a097ac19d287efa51303ee5eb9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <?php if($ticket->user_id): ?>
                                                <?php if (isset($component)) { $__componentOriginal2e35eccef784dc5d824a24bbcbdc77f7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2e35eccef784dc5d824a24bbcbdc77f7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.other.user_info','data' => ['user' => $ticket->user]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.other.user_info'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($ticket->user)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2e35eccef784dc5d824a24bbcbdc77f7)): ?>
<?php $attributes = $__attributesOriginal2e35eccef784dc5d824a24bbcbdc77f7; ?>
<?php unset($__attributesOriginal2e35eccef784dc5d824a24bbcbdc77f7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2e35eccef784dc5d824a24bbcbdc77f7)): ?>
<?php $component = $__componentOriginal2e35eccef784dc5d824a24bbcbdc77f7; ?>
<?php unset($__componentOriginal2e35eccef784dc5d824a24bbcbdc77f7); ?>
<?php endif; ?>
                                            <?php else: ?>
                                                <div
                                                    class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
                                                    <span class="table-thumb">
                                                        <img src="<?php echo e(siteFavicon()); ?>" alt="user">
                                                    </span>
                                                    <span><?php echo e($ticket->name); ?></span>
                                                </div>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.ticket.view', $ticket->id)); ?>" class="fw-smibold">
                                                [<?php echo app('translator')->get('Ticket'); ?>#<?php echo e($ticket->ticket); ?>]
                                                <?php echo e(strLimit($ticket->subject, 30)); ?>

                                            </a>
                                        </td>
                                        <td>
                                            <?php echo $ticket->statusBadge; ?>
                                        </td>
                                        <td>
                                            <?php echo $ticket->priorityBadge; ?>
                                        </td>
                                        <td>
                                            <div>
                                                <span class="d-block">
                                                    <?php echo e(diffForHumans($ticket->last_reply)); ?>

                                                </span>
                                                <small><?php echo e(showDateTime($ticket->last_reply)); ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.ticket.view', $ticket->id)); ?>"
                                                class="btn  btn-outline--primary">
                                                <i class="las la-info-circle"></i> <?php echo app('translator')->get('Details'); ?>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php if (isset($component)) { $__componentOriginala33aabd5eea3ecdc22aa829fe4dc5451 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala33aabd5eea3ecdc22aa829fe4dc5451 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.empty_message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.empty_message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala33aabd5eea3ecdc22aa829fe4dc5451)): ?>
<?php $attributes = $__attributesOriginala33aabd5eea3ecdc22aa829fe4dc5451; ?>
<?php unset($__attributesOriginala33aabd5eea3ecdc22aa829fe4dc5451); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala33aabd5eea3ecdc22aa829fe4dc5451)): ?>
<?php $component = $__componentOriginala33aabd5eea3ecdc22aa829fe4dc5451; ?>
<?php unset($__componentOriginala33aabd5eea3ecdc22aa829fe4dc5451); ?>
<?php endif; ?>
                                <?php endif; ?>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82bf14a097ac19d287efa51303ee5eb9)): ?>
<?php $attributes = $__attributesOriginal82bf14a097ac19d287efa51303ee5eb9; ?>
<?php unset($__attributesOriginal82bf14a097ac19d287efa51303ee5eb9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82bf14a097ac19d287efa51303ee5eb9)): ?>
<?php $component = $__componentOriginal82bf14a097ac19d287efa51303ee5eb9; ?>
<?php unset($__componentOriginal82bf14a097ac19d287efa51303ee5eb9); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal722fc7edbde74caa9ff525bc9925b331)): ?>
<?php $attributes = $__attributesOriginal722fc7edbde74caa9ff525bc9925b331; ?>
<?php unset($__attributesOriginal722fc7edbde74caa9ff525bc9925b331); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal722fc7edbde74caa9ff525bc9925b331)): ?>
<?php $component = $__componentOriginal722fc7edbde74caa9ff525bc9925b331; ?>
<?php unset($__componentOriginal722fc7edbde74caa9ff525bc9925b331); ?>
<?php endif; ?>
                        <?php if($tickets->hasPages()): ?>
                            <?php if (isset($component)) { $__componentOriginal68b8578f4731ed8618940abb62c65128 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal68b8578f4731ed8618940abb62c65128 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.table.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.table.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                                <?php echo e(paginateLinks($tickets)); ?>

                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal68b8578f4731ed8618940abb62c65128)): ?>
<?php $attributes = $__attributesOriginal68b8578f4731ed8618940abb62c65128; ?>
<?php unset($__attributesOriginal68b8578f4731ed8618940abb62c65128); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal68b8578f4731ed8618940abb62c65128)): ?>
<?php $component = $__componentOriginal68b8578f4731ed8618940abb62c65128; ?>
<?php unset($__componentOriginal68b8578f4731ed8618940abb62c65128); ?>
<?php endif; ?>
                        <?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal461e4ac3a9de43e934a2cb2cfdbe0e04)): ?>
<?php $attributes = $__attributesOriginal461e4ac3a9de43e934a2cb2cfdbe0e04; ?>
<?php unset($__attributesOriginal461e4ac3a9de43e934a2cb2cfdbe0e04); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal461e4ac3a9de43e934a2cb2cfdbe0e04)): ?>
<?php $component = $__componentOriginal461e4ac3a9de43e934a2cb2cfdbe0e04; ?>
<?php unset($__componentOriginal461e4ac3a9de43e934a2cb2cfdbe0e04); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $attributes = $__attributesOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $component = $__componentOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__componentOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/admin/support/tickets.blade.php ENDPATH**/ ?>