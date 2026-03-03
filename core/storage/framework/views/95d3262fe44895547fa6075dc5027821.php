<?php $__env->startSection('content'); ?>
    <div class="error-content__footer">
        <p class="error-content__message">
            <span class="title"><?php echo app('translator')->get('Session expired'); ?></span>
            <span class="text"><?php echo app('translator')->get('Please refresh your browser and try again to continue where you left off.'); ?></span>
        </p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline--primary error-btn">
            <span class="btn--icon"><i class="fa-solid fa-house"></i></span>
            <span class="text"><?php echo app('translator')->get('Back to Home'); ?></span>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/errors/419.blade.php ENDPATH**/ ?>