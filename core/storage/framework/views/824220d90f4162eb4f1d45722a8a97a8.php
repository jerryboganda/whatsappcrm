<?php
    $bgClasses = ['bg--success', 'bg--info', 'bg--warning', 'bg--danger'];
    $hash = crc32(@$contact->full_name);
    $bgClass = $bgClasses[$hash % count($bgClasses)];
    $user = auth()->user();
?>

<?php if(@$contact->image && $user->hasAgentPermission('view contact profile')): ?>
    <div class="contact_thumb ">
        <img src="<?php echo e(@$contact->image_src); ?>" alt="Image">
    </div>
<?php else: ?>
    <div class="contact_thumb   <?php echo e($bgClass); ?>">
        <?php echo e(strtoupper(substr(@$contact->firstname ?? '', 0, 1))); ?><?php echo e(strtoupper(substr(@$contact->lastname ?? '', 0, 1))); ?>

    </div>
<?php endif; ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact/thumb.blade.php ENDPATH**/ ?>