<tr class="text-center empty-message-row">
    <td colspan="100%" class="text-center">
        <div class="py-5">
            <img src="<?php echo e(asset('assets/images/no-data.gif')); ?>" class="empty-message">
            <span class="d-block"><?php echo e(__($emptyMessage)); ?></span>
            <span class="d-block fs-13 text-muted"><?php echo app('translator')->get('There are no available data to display on this table at the moment.'); ?></span>
        </div>
    </td>
</tr>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/empty_message.blade.php ENDPATH**/ ?>