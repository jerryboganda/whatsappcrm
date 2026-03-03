<div class="table-export">
    <div class=" dropdown">
        <button class="btn btn-outline--secondary  dropdown-toggle w-100" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            <span class="icon"> <i class="las  la-download"></i> </span>
            <?php echo app('translator')->get('Export'); ?>
        </button>
        <div class="dropdown-menu">
            <ul class="table-export__list mb-0">
                <li class="table-export__item">
                    <a href="<?php echo e(appendQuery('export', 'excel')); ?>" class="table-export__link">
                        <span class="table-export__icon bg--success">
                            <i class="las la-file-excel"></i>
                        </span>
                        <?php echo app('translator')->get('Excel'); ?>
                    </a>
                </li>
                <li class="table-export__item">
                    <a href="<?php echo e(appendQuery('export', 'csv')); ?>" class="table-export__link">
                        <span class="table-export__icon bg--primary"><i class="las la-file-csv"></i></span>
                        <?php echo app('translator')->get('CSV'); ?>
                    </a>
                </li>
                <li class="table-export__item">
                    <a href="<?php echo e(appendQuery('export', 'pdf')); ?>" class="table-export__link">
                        <span class="table-export__icon bg--info"><i class="las la-file-pdf"></i></span>
                        <?php echo app('translator')->get('PDF'); ?>
                    </a>
                </li>
                <li class="table-export__item">
                    <a target="_blank" href="<?php echo e(appendQuery('export', 'print')); ?>" class="table-export__link">
                        <span class="table-export__icon bg--warning"><i class="las la-print"></i></span>
                        <?php echo app('translator')->get('Print'); ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php $__env->startPush('style'); ?>
    <style>
        .table-export__icon {
            padding: 3px;
            color: #fff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/table/export_btn.blade.php ENDPATH**/ ?>