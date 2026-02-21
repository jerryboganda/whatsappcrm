<div class="dashboard-header">
    <div class="dashboard-header__inner flex-between">
        <div class="dashboard-header__left">
            <div class="dashboard-body__bar d-lg-none d-block">
                <span class="dashboard-body__bar-icon"><i class="fas fa-bars"></i></span>
            </div>
            <h3 class="title"><?php echo e(__($pageTitle)); ?></h3>
        </div>
        <div class="user-info">
            <div class="user-info__right">
                <div class="user-info__button">
                    <div class="user-info__thumb">
                        <img src="<?php echo e(auth()->user()->imageSrc); ?>" alt="image">
                    </div>
                    <div class="user-info__profile">
                        <p class="user-info__name"> <?php echo e(auth()->user()->fullname); ?> </p>
                        <span class="user-info__desc"> <?php echo e(showEmailAddress(auth()->user()->email)); ?> <span
                                class="icon"><i class="fa-solid fa-caret-down"></i></span> </span>
                    </div>
                </div>
            </div>
            <ul class="user-info-dropdown">
                <li class="user-info-dropdown__item"><a class="user-info-dropdown__link"
                        href="<?php echo e(route('user.profile.setting')); ?>">
                        <span class="icon"><i class="far fa-user"></i></span>
                        <span class="text"><?php echo app('translator')->get('View Profile'); ?></span>
                    </a></li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="<?php echo e(route('user.subscription.index')); ?>">
                        <span class="icon"> <i class="fa-solid fa-dollar-sign"></i> </span>
                        <span class="text"><?php echo app('translator')->get('Subscription Info'); ?></span>
                    </a>
                </li>
                <?php if(isParentUser()): ?>
                    <li class="user-info-dropdown__item">
                        <a class="user-info-dropdown__link" href="<?php echo e(route('user.whatsapp.account.index')); ?>">
                            <span class="icon"> <i class="fa-brands fa-whatsapp"></i> </span>
                            <span class="text"><?php echo app('translator')->get('WhatsApp Account'); ?></span>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="<?php echo e(route('user.notification.setting')); ?>">
                        <span class="icon"> <i class="fa-regular fa-bell-slash"></i></span>
                        <span class="text"><?php echo app('translator')->get('Notification Setting'); ?></span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link" href="<?php echo e(route('user.twofactor')); ?>">
                        <span class="icon"> <i class="fa-solid fa-shield-halved"></i> </span>
                        <span class="text"><?php echo app('translator')->get('2FA Setting'); ?></span>
                    </a>
                </li>
                <li class="user-info-dropdown__item">
                    <a class="user-info-dropdown__link text--danger" href="<?php echo e(route('user.logout')); ?>">
                        <span class="icon text--danger"> <i class="fa-solid fa-arrow-right-from-bracket"></i> </span>
                        <span class="text text--danger"> <?php echo app('translator')->get('Sign Out'); ?> </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="dashboard-header__shape">
        <img src="<?php echo e(getImage($activeTemplateTrue . 'images/ds-1.png')); ?>" alt="">
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/auth_header.blade.php ENDPATH**/ ?>