<aside class="dashboard__sidebar  sidebar-menu">
    <div class="dashboard__sidebar-area">
        <div class="dashboard__sidebar-header">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="dashboard__sidebar-logo">
                <img class="img-fluid light-show" src="<?php echo e(siteLogo()); ?>">
                <img class="img-fluid dark-show" src="<?php echo e(siteLogo('dark')); ?>">
            </a>
            <span class="sidebar-menu__close header-dropdown__icon">
                <i class="las la-angle-double-left"></i>
            </span>
        </div>
        <?php
            $routeCount = 0;
        ?>
        <div class="dashboard__sidebar-inner">
            <ul class="dashboard-nav ps-0">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $allPermissions = collect($menu)->pluck('permission')->filter()->toArray();
                    ?>
                    <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => array_merge(...$allPermissions)]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(array_merge(...$allPermissions))]); ?>
                        <li class="dashboard-nav__title">
                            <span class="dashboard-nav__title-text"><?php echo e(__(str_replace('_', ' ', $k))); ?></span>
                        </li>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(@$parentMenu->submenu): ?>
                            <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => @$parentMenu->permission]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(@$parentMenu->permission)]); ?>
                                <li class="dashboard-nav__items has-dropdown">
                                    <a href="javascript:void(0)"
                                        class="dashboard-nav__link <?php echo e(menuActive(@$parentMenu->menu_active ?? @$parentMenu->route_name)); ?>">
                                        <span class="dashboard-nav__link-icon">
                                            <i class="<?php echo e($parentMenu->icon); ?>"></i>
                                        </span>
                                        <span class="dashboard-nav__link-text">
                                            <?php echo e(__($parentMenu->title)); ?>

                                            <?php $__currentLoopData = @$parentMenu->counters ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $counter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($$counter > 0): ?>
                                                    <span class="nav-badge text--warning fs-16">
                                                        <i class="fa-solid fa-triangle-exclamation"></i>
                                                    </span>
                                                    <?php break; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </span>
                                    </a>
                                    <ul class="dashboard-nav sidebar-submenu">
                                        <?php $__currentLoopData = $parentMenu->submenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => @$subMenu->permission]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(@$subMenu->permission)]); ?>
                                                <li class="dashboard-nav__items">
                                                    <a href="<?php echo e(route($subMenu->route_name)); ?>"
                                                        class="dashboard-nav__link <?php echo e(menuActive(@$subMenu->menu_active ?? @$subMenu->route_name)); ?>">
                                                        <span class="dashboard-nav__link-icon"><i
                                                                class="las la-dot-circle"></i></span>
                                                        <span class="dashboard-nav__link-text">
                                                            <?php echo e(__($subMenu->title)); ?>

                                                            <?php $counter = @$subMenu->counter; ?>
                                                            <?php if(@$$counter): ?>
                                                                <span class="nav-badge bg--dark text--white">
                                                                    <?php echo e(@$$counter); ?>

                                                                </span>
                                                            <?php endif; ?>
                                                        </span>
                                                    </a>
                                                </li>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => @$parentMenu->permission]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(@$parentMenu->permission)]); ?>
                                <li class="dashboard-nav__items">
                                    <a href="<?php echo e(route($parentMenu->route_name)); ?>"
                                        class="dashboard-nav__link <?php echo e(menuActive(@$parentMenu->menu_active ?? @$parentMenu->route_name)); ?>">
                                        <span class="dashboard-nav__link-icon">
                                            <i class="<?php echo e($parentMenu->icon); ?>"></i>
                                        </span>
                                        <span class="dashboard-nav__link-text"><?php echo e(__($parentMenu->title)); ?></span>
                                    </a>
                                </li>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</aside>
<?php /**PATH /var/www/html/core/resources/views/admin/partials/sidenav.blade.php ENDPATH**/ ?>