<?php
    $admin = auth('admin')->user();
?>

<?php if (isset($component)) { $__componentOriginal85e1a028048b26f04997193acb2a7274 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85e1a028048b26f04997193acb2a7274 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.other.header_search','data' => ['menus' => $menus,'permissions' => $permissions]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.other.header_search'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['menus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($menus),'permissions' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($permissions)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85e1a028048b26f04997193acb2a7274)): ?>
<?php $attributes = $__attributesOriginal85e1a028048b26f04997193acb2a7274; ?>
<?php unset($__attributesOriginal85e1a028048b26f04997193acb2a7274); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85e1a028048b26f04997193acb2a7274)): ?>
<?php $component = $__componentOriginal85e1a028048b26f04997193acb2a7274; ?>
<?php unset($__componentOriginal85e1a028048b26f04997193acb2a7274); ?>
<?php endif; ?>

<header class="dashboard__header">
    <div class="dashboard__header-left">
        <span class="breadcrumb-icon navigation-bar"><i class="fa-solid fa-bars"></i></span>
        <div class="header-search__input">
            <label for="desktop-search-input" class="header-search__icon open-search">
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
            </label>
            <label for="desktop-search-input">
                <input type="search" id="desktop-search-input" placeholder="<?php echo app('translator')->get('Search'); ?>...."
                    class="desktop-search header-search-filed open-search" autocomplete="false">
                <span class="search-instruction flex-align gap-2">
                    <span class="instruction__icon esc-text fw-bold"><?php echo app('translator')->get('Ctrl'); ?></span>
                    <span class="instruction__icon esc-text fw-bold"><?php echo app('translator')->get('K'); ?></span>
                </span>
            </label>

        </div>
    </div>
    <div class="dashboard-info flex-align gap-sm-2 gap-1">
        <div class="header-dropdown">
            <a class="header-dropdown__icon" href="<?php echo e(route('home')); ?>" target="_blank" data-bs-toggle="tooltip"
                title="<?php echo app('translator')->get('Go to Website'); ?>">
                <i class="las la-globe"></i>
            </a>
        </div>
        <div class="dashboard-quick-link header-dropdown">
            <button class="header-dropdown__icon dropdown-toggle " data-bs-toggle="dropdown" aria-expanded="false">
                <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Quick Link'); ?>">
                    <i class="las la-link"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <div class="quick-link-list">
                    <a href="<?php echo e(route('admin.deposit.pending')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-money-check-alt"></i>
                        </span>
                        <span class="quick-link-item__name">
                            <?php echo app('translator')->get('Pending Deposit'); ?>
                            <span class=" text--info">(<?php echo e($pendingDepositsCount); ?>)</span>
                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.deposit.pending')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-hand-holding-usd"></i>
                        </span>
                        <span class="quick-link-item__name">
                            <?php echo app('translator')->get('Pending Withdrawals'); ?>
                            <span class="text--info">(<?php echo e($pendingWithdrawCount); ?>)</span>
                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.ticket.pending')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="la la-ticket"></i>
                        </span>
                        <span class="quick-link-item__name">
                            <?php echo app('translator')->get('Pending Ticket'); ?>
                            <span class=" text--info">(<?php echo e($pendingTicketCount); ?>)</span>
                        </span>
                    </a>
                    <a href="<?php echo e(route('admin.setting.general')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-cogs"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('General Setting'); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.setting.system.configuration')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-tools"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('System Configuration'); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.setting.notification.email')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-bell"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('Notification Setting'); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.users.all')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-users"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('All User'); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.users.active')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-user-check"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('Active User'); ?></span>
                    </a>
                    <a href="<?php echo e(route('admin.users.banned')); ?>" class="quick-link-item">
                        <span class="quick-link-item__icon">
                            <i class="las la-user-slash"></i>
                        </span>
                        <span class="quick-link-item__name"><?php echo app('translator')->get('Banned User'); ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="language-dropdown header-dropdown">
            <button class="header-dropdown__icon dropdown-toggle " data-bs-toggle="dropdown">
                <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Language'); ?>">
                    <i class="las la-language"></i>
                </span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <?php
                    $appLocal = strtoupper(config('app.locale')) ?? 'en';
                ?>
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="dropdown-menu__item  align-items-center gap-2 justify-content-between langSel"
                        data-code="<?php echo e($language->code); ?>">
                        <div class=" d-flex flex-wrap align-items-center gap-2">
                            <span class="language-dropdown__icon">
                                <img src="<?php echo e(@$language->image_src); ?>">
                            </span>
                            <?php echo e(ucfirst($language->name)); ?>

                        </div>
                        <?php if($appLocal == strtoupper($language->code)): ?>
                            <span class="text--success">
                                <i class="las la-check-double"></i>
                            </span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="header-dropdown">
            <button class=" dropdown-toggle header-dropdown__icon" type='button' data-bs-toggle="tooltip"
                title="<?php echo app('translator')->get('Theme'); ?>" id="switch-theme">
                <span class=" dark-show">
                    <i class="las la-moon"></i>
                </span>
                <span class=" light-show">
                    <i class="las la-sun"></i>
                </span>
            </button>
        </div>
        <div class="notification header-dropdown">
            <button class="dropdown-toggle header-dropdown__icon" data-bs-toggle="dropdown" aria-expanded="false"
                data-bs-auto-close="outside">
                <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Notification'); ?>">
                    <i class="las la-bell  <?php if($adminNotificationCount): ?> icon-left-right <?php endif; ?>"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end notification__area">
                <div class="notification__header p-3">
                    <h4 class="notification__header-text"><?php echo app('translator')->get('Notifications'); ?></h4>
                    <?php if($adminNotificationCount): ?>
                        <div class="notification__header-info">
                            <span class="notification__header-info-count badge--primary badge">
                                <?php echo e($adminNotificationCount); ?>

                                <?php echo app('translator')->get('New notifications'); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="top-notification__body">
                    <ul class="notification__items">
                        <?php $__empty_1 = true; $__currentLoopData = $adminNotifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <li class="notification__list">
                                <a href="<?php echo e(route('admin.notification.read', $notification->id)); ?>"
                                    class="notification__link px-3">
                                    <div class="notification__list-thumb">
                                        <?php if($notification->user): ?>
                                            <?php if($notification->user->image): ?>
                                                <img class="fit-image"
                                                    src="<?php echo e(getImage(getFilePath('userProfile') . '/' . @$notification->user->image, getFileSize('userProfile'))); ?>">
                                            <?php else: ?>
                                                <span class="name-short-form">
                                                    <?php echo e(__(@$user->full_name_short_form ?? 'N/A')); ?>

                                                </span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <img class="fit-image" src="<?php echo e(siteFavicon()); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="notification__list-content">
                                        <p class="notification__list-title">
                                            <?php if(@$notification->user): ?>
                                                <?php echo e(@$notification->$user->full_name); ?>

                                            <?php else: ?>
                                                <?php echo app('translator')->get('Anonymous'); ?>
                                            <?php endif; ?>
                                        </p>
                                        <p class="notification__list-desc">
                                            <?php echo e(__($notification->title)); ?>

                                        </p>
                                    </div>
                                    <div class="notification__list-status">
                                        <span class="notification__list-time">
                                            <?php echo e(diffForHumans($notification->created_at)); ?>

                                        </span>
                                    </div>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <li class="p-3">
                                <div class="p-5 text-center">
                                    <img src="<?php echo e(asset('assets/images/empty_box.png')); ?>" class="empty-message">
                                    <span class="d-block"><?php echo app('translator')->get('No unread notifications were found'); ?></span>
                                    <span class="d-block fs-13 text-muted"><?php echo app('translator')->get('There is no available data to display here at the moment'); ?></span>
                                </div>
                            <li>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php if($hasNotification): ?>
                    <div class="notification__footer p-3">
                        <a href="<?php echo e(route('admin.notifications')); ?>" class="btn btn--primary btn-large  w-100">
                            <?php echo app('translator')->get('View All Notification'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="dashboard-header-user">
            <button class="header-dropdown__icon" data-bs-toggle="dropdown" aria-expanded="false">
                <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Profile'); ?>">
                    <i class="las la-user"></i>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-end user__area">
                <div class="user__header">
                    <a href="<?php echo e(route('admin.profile')); ?>" class="user__info">
                        <div class="user__thumb">
                            <img src="<?php echo e($admin->image_src); ?>">
                        </div>
                        <div class="user__details">
                            <h6 class="user__name"><?php echo e(@$admin->name); ?></h6>
                            <p class="user__roll"><?php echo app('translator')->get('Admin'); ?></p>
                        </div>
                    </a>
                </div>
                <div class="user__body">
                    <nav class="user__link">
                        <a href="<?php echo e(route('admin.profile')); ?>" class="user__link-item">
                            <span class="user__link-item-icon">
                                <i class="las la-user-alt"></i>
                            </span>
                            <span class="user__link-item-text"><?php echo app('translator')->get('My Profile'); ?></span>
                        </a>
                        <a href="<?php echo e(route('admin.password')); ?>" class="user__link-item">
                            <span class="user__link-item-icon">
                                <i class="las la-lock-open"></i>
                            </span>
                            <span class="user__link-item-text"><?php echo app('translator')->get('Change Passsword'); ?></span>
                        </a>
                    </nav>
                </div>
                <div class="user__footer">
                    <a href="<?php echo e(route('admin.logout')); ?>" class="btn btn--danger ">
                        <span class="btn--icon"><i class="fas fa-sign-out text--danger"></i></span>
                        <?php echo app('translator')->get('Logout'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header><?php /**PATH /var/www/html/core/resources/views/admin/partials/topnav.blade.php ENDPATH**/ ?>