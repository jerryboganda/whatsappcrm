<?php $__env->startSection('app-content'); ?>
    <?php echo $__env->yieldPushContent('fbComment'); ?>
 


    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    <?php echo $__env->make('Template::partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php if(!request()->routeIs(['home', 'user.*'])): ?>
        <?php echo $__env->make('Template::partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <main class="frontend">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    <?php echo $__env->make('Template::partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/layouts/frontend.blade.php ENDPATH**/ ?>