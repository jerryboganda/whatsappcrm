<div class="header-search">
    <div class="search-card">
        <div class="search-card__body">
            <label class="search-card__label flex-align">
                <span class="search-card__icon">
                    <?php if (isset($component)) { $__componentOriginal8c3d41c031364cbeac534fc11a7a2738 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8c3d41c031364cbeac534fc11a7a2738 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.svg.search','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.svg.search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8c3d41c031364cbeac534fc11a7a2738)): ?>
<?php $attributes = $__attributesOriginal8c3d41c031364cbeac534fc11a7a2738; ?>
<?php unset($__attributesOriginal8c3d41c031364cbeac534fc11a7a2738); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8c3d41c031364cbeac534fc11a7a2738)): ?>
<?php $component = $__componentOriginal8c3d41c031364cbeac534fc11a7a2738; ?>
<?php unset($__componentOriginal8c3d41c031364cbeac534fc11a7a2738); ?>
<?php endif; ?>
                </span>
                <input type="search" class="form--control border-0 outline-0 " placeholder="<?php echo app('translator')->get('Search'); ?>...."
                    autocomplete="false">
            </label>
            <?php
                $count = 0;
            ?>
            <ul class="search-card__list">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $showParent =
                                empty($parentMenu->permission) ||
                                count(array_intersect($parentMenu->permission, $permissions)) > 0;
                        ?>

                        <?php if($showParent): ?>
                            <?php if(@$parentMenu->submenu): ?>
                                <?php $__currentLoopData = @$parentMenu->submenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $showSub =
                                            empty($subMenu->permission) ||
                                            count(array_intersect($subMenu->permission, $permissions)) > 0;
                                    ?>

                                    <?php if($showSub): ?>
                                        <li class="search-card__item" data-keyword='<?php echo json_encode($subMenu->keyword, 15, 512) ?>'>
                                            <a href="<?php echo e(route($subMenu->route_name)); ?>" class="search-card__link">
                                                <div class="search-card__text">
                                                    <span class="title"><?php echo e(__($subMenu->title)); ?></span>
                                                    <span class="subtitle"><?php echo e(__($parentMenu->title)); ?></span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <li class="search-card__item" data-keyword='<?php echo json_encode(@$parentMenu->keyword ?? [], 15, 512) ?>'>
                                    <a href="<?php echo e(route($parentMenu->route_name)); ?>" class="search-card__link">
                                        <div class="search-card__text">
                                            <span class="title"><?php echo e(__($parentMenu->title)); ?></span>
                                            <span class="subtitle"><?php echo e(__(ucwords(str_replace('_', ' ', $k)))); ?></span>
                                        </div>
                                    </a>
                                </li>

                                <?php if($parentMenu->title == 'Manage Sections'): ?>
                                    <?php $__currentLoopData = getPageSections(true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s => $secs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $count++; ?>
                                        <li class="search-card__item" data-keyword='<?php echo json_encode(@$parentMenu->keyword ?? [], 15, 512) ?>'>
                                            <a href="<?php echo e(route('admin.frontend.sections', $s)); ?>"
                                                class="search-card__link">
                                                <div class="search-card__text">
                                                    <span class="title"><?php echo e(__($secs['name'])); ?></span>
                                                    <span class="subtitle"><?php echo app('translator')->get('Manage Frontend'); ?></span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="search-empty-message text-center p-5 d-none">
                <img src="<?php echo e(asset('assets/images/empty_box.png')); ?>" class="empty-message">
                <span class="d-block"><?php echo app('translator')->get('No result found'); ?></span>
            </div>
        </div>
        <div class="search-card__footer">
            <span class="instruction">
                <span class="instruction__icon">
                    <i class="fa-solid fa-arrow-right-to-bracket"></i>
                </span>
                <span class="instruction__text"><?php echo app('translator')->get('to select'); ?></span>
            </span>
            <span class="instruction">
                <span class="instruction__icon">
                    <i class="fa-solid fa-arrow-up"></i>
                </span>
                <span class="instruction__icon">
                    <i class="fa-solid fa-arrow-down"></i>
                </span>
                <span class="instruction__text"><?php echo app('translator')->get('to navigate'); ?></span>
            </span>
            <span class="instruction">
                <span class="instruction__icon esc-text fw-bold">
                    <?php echo app('translator')->get('ESC'); ?>
                </span>
                <span class="instruction__text"><?php echo app('translator')->get('to close'); ?></span>
            </span>
        </div>
    </div>
</div><?php /**PATH /var/www/html/core/resources/views/components/admin/other/header_search.blade.php ENDPATH**/ ?>