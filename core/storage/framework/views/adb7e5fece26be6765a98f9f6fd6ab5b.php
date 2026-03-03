<?php
    $user = auth()->user();
    $whatsapp = @$user->currentWhatsapp();
?>

<?php $__currentLoopData = $messages->getCollection()->sortBy('ordering'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('Template::user.inbox.single_message', ['message' => $message], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/messages.blade.php ENDPATH**/ ?>