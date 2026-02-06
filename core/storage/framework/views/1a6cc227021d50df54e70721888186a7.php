<?php $__env->startSection('content'); ?>
    <div class="error-content__footer">
        <p class="error-content__message">
            <span class="title"><?php echo app('translator')->get('Page not found'); ?></span>
            <span class="text">
                <?php echo app('translator')->get('The page you are looking for may not exist, or an error has occurred. It might also be temporarily unavailable.'); ?>
            </span>
        </p>
        <a href="<?php echo e(route('home')); ?>" class="btn btn-outline--primary error-btn">
            <span class="btn--icon"><i class="fa-solid fa-house"></i></span>
            <span class="text"><?php echo app('translator')->get('Back to Home'); ?></span>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/errors/404.blade.php ENDPATH**/ ?>