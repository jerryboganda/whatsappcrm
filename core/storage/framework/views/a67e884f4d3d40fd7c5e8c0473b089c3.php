<div class="profile-page-wrapper">
    <span class="sidebar-menu__close d-md-none d-block"><i class="fas fa-times"></i></span>
    <ul class="profile-list">
        <?php if(isParentUser()): ?>
            <li>
                <a href="<?php echo e(route('user.whatsapp.account.index')); ?>"
                    class="profile-list__link <?php echo e(menuActive('user.whatsapp.account.*')); ?>">
                    <span class="profile-list__icon"> <i class="fa-brands fa-whatsapp"></i> </span><?php echo app('translator')->get('WhatsApp Accounts'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.whatsapp.webhook.config')); ?>"
                    class="profile-list__link <?php echo e(menuActive('user.whatsapp.webhook.config')); ?>">
                    <span class="profile-list__icon"> <i class="fa-brands fa-whatsapp"></i> </span><?php echo app('translator')->get('Webhook Setup'); ?>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('user.subscription.index')); ?>"
                    class="profile-list__link <?php echo e(menuActive('user.subscription.index')); ?>">
                    <span class="profile-list__icon"> <i class="fa-solid fa-dollar-sign"></i></span> <?php echo app('translator')->get('Subscription'); ?>
                </a>
            </li>
        <?php endif; ?>
        <li>
            <a href="<?php echo e(route('user.profile.setting')); ?>"
                class="profile-list__link <?php echo e(menuActive('user.profile.setting')); ?>">
                <span class="profile-list__icon"> <i class="fas fa-user"></i> </span> <?php echo app('translator')->get('My Profile'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('user.twofactor')); ?>" class="profile-list__link <?php echo e(menuActive('user.twofactor')); ?>">
                <span class="profile-list__icon"> <i class="fa-solid fa-shield-halved"></i> </span> <?php echo app('translator')->get('2FA Setting'); ?>
            </a>
        </li>
        <li>
            <a href="<?php echo e(route('user.change.password')); ?>"
                class="profile-list__link <?php echo e(menuActive('user.change.password')); ?>">
                <span class="profile-list__icon"> <i class="fas fa-key"></i> </span> <?php echo app('translator')->get('Change Password'); ?>
            </a>
        </li>
    </ul>
</div>
<div class="d-md-none d-flex justify-content-end">
    <span class="profile-bar-icon"> <i class="fa-solid fa-list"></i> </span>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/profile_tab.blade.php ENDPATH**/ ?>