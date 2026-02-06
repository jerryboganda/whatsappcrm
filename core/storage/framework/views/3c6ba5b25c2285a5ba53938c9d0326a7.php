<?php $__env->startSection('app-content'); ?>
    <div class="dashboard position-relative">
        <div class="dashboard__inner flex-wrap">
            <?php echo $__env->make('Template::partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <div class="dashboard__right">
                <div class="container-fluid p-0">
                    <?php echo $__env->make('Template::partials.auth_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php echo $__env->yieldPushContent('topbar_tabs'); ?>
                    <div class="dashboard-body">
                        <?php if(request()->routeIs('user.inbox.list')): ?>
                            <div class="text-end d-flex justify-content-end gap-3 align-items-center mb-2">
                                <span class="filter-icon"> <i class="fas fa-stream"></i> </span>
                                <span class="user-icon"><i class="fa-regular fa-circle-user"></i></span>
                            </div>
                        <?php endif; ?>
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/layouts/master.blade.php ENDPATH**/ ?>