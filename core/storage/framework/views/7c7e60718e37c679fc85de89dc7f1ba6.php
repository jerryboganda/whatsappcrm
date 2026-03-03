<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 ">
                <div class="card-body p-0">
                    <form action="<?php echo e(route('user.dialogflow.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="p-4">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Service Account Credentials (JSON)'); ?></label>
                                <input type="file" name="credentials_file" class="form-control" accept=".json" required>
                                <small
                                    class="text-muted"><?php echo app('translator')->get('Upload the JSON key file from your Google Cloud Service Account.'); ?></small>
                            </div>

                            <div class="form-group">
                                <label><?php echo app('translator')->get('Status'); ?></label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger"
                                    data-bs-toggle="toggle" data-on="<?php echo app('translator')->get('Enable'); ?>" data-off="<?php echo app('translator')->get('Disable'); ?>"
                                    name="status" <?php if(@$config->status): ?> checked <?php endif; ?> value="1">
                            </div>

                            <?php if(@$config): ?>
                                <div class="alert alert-info">
                                    <strong><?php echo app('translator')->get('Current Project ID'); ?>:</strong> <?php echo e($config->project_id); ?>

                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn--primary btn-block w-100"><?php echo app('translator')->get('Save Configuration'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if(@$config): ?>
        <a href="<?php echo e(route('user.dialogflow.delete')); ?>" class="btn btn-sm btn--danger">
            <i class="las la-trash"></i> <?php echo app('translator')->get('Remove Configuration'); ?>
        </a>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/automation/dialogflow.blade.php ENDPATH**/ ?>