<?php
    $request = request();
?>
<div class="form-group">
    <label class="form-label"><?php echo app('translator')->get('Record to Display'); ?></label>
    <select class="form-select select2" name="paginate" data-minimum-results-for-search="-1">
        <option value="20" <?php if($request->paginate == 20): echo 'selected'; endif; ?>><?php echo app('translator')->get('20'); ?> <?php echo app('translator')->get('Items'); ?></option>
        <option value="40" <?php if($request->paginate == 40): echo 'selected'; endif; ?>><?php echo app('translator')->get('40'); ?> <?php echo app('translator')->get('Items'); ?></option>
        <option value="60" <?php if($request->paginate == 60): echo 'selected'; endif; ?>><?php echo app('translator')->get('60'); ?> <?php echo app('translator')->get('Items'); ?></option>
        <option value="80" <?php if($request->paginate == 80): echo 'selected'; endif; ?>><?php echo app('translator')->get('80'); ?> <?php echo app('translator')->get('Items'); ?></option>
        <option value="100" <?php if($request->paginate == 100): echo 'selected'; endif; ?>><?php echo app('translator')->get('100'); ?> <?php echo app('translator')->get('Items'); ?></option>
    </select>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/other/per_page_record.blade.php ENDPATH**/ ?>