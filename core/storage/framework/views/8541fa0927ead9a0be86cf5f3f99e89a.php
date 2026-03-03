<div class="form-group">
    <label class="form-label"><?php echo app('translator')->get('Order By'); ?></label>
    <select class="form-select select2" name="order_by" data-minimum-results-for-search="-1">
        <option value="desc"><?php echo app('translator')->get('Latest'); ?></option>
        <option value="asc" <?php if(request()->order_by == 'asc'): echo 'selected'; endif; ?>> <?php echo app('translator')->get('Oldest'); ?></option>
    </select>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/other/order_by.blade.php ENDPATH**/ ?>