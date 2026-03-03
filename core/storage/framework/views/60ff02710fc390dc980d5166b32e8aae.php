<?php $__env->startSection('content'); ?>
    <main class="dashboard">
        <?php echo $__env->make('admin.partials.sidenav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <section class="dashboard__area">
            <div class="container-fluid">
                <?php echo $__env->make('admin.partials.topnav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <div class="dashboard__area-header flex-wrap gap-2">
                    <h3 class="page-title"><?php echo e(__($pageTitle)); ?></h3>
                    <div class="breadcrumb-plugins">
                        <?php echo $__env->yieldPushContent('breadcrumb-plugins'); ?>
                    </div>
                </div>
                <div class="dashboard__area-inner p-0">
                    <?php echo $__env->yieldContent('panel'); ?>
                </div>
            </div>
        </section>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/admin/layouts/app.blade.php ENDPATH**/ ?>