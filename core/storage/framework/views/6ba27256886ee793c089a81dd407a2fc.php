<!DOCTYPE html>
<html lang="<?php echo e(config('app.locale')); ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(gs()->siteName($pageTitle ?? '')); ?></title>
    <link rel="shortcut icon" type="image/png" href="<?php echo e(siteFavicon()); ?>">

    <link
        href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@300;400;500;600;700;800;900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <script src="<?php echo e(asset('assets/admin/js/theme.js')); ?>"></script>

    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/all.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('assets/admin/css/main.css')); ?>">
    <?php echo $__env->yieldPushContent('style'); ?>
</head>

<body>
    <div class="sidebar-overlay"></div>
    <?php echo $__env->yieldContent('content'); ?>


    <script src="<?php echo e(asset('assets/global/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>

    <?php echo $__env->make('partials.notify', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <script src="<?php echo e(asset('assets/global/js/global.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/search.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/admin/js/main.js')); ?>"></script>
    <?php echo $__env->yieldPushContent('script'); ?>

    <script>
        (function($) {
            "use strict";
            // event when change lang
            $(".langSel").on("click", function() {
                const code = $(this).data('code')
                window.location.href = "<?php echo e(route('home')); ?>/change/" + code;
            });

            //set some property to the window object for access from a js file
            window.app_config = {
                empty_image_url: "<?php echo e(asset('assets/images/empty_box.png')); ?>",
                empty_title: "<?php echo app('translator')->get('No data found'); ?>",
                empty_message: "<?php echo app('translator')->get('There are no available data to display.'); ?>",
                allow_precision: "<?php echo e(gs('allow_precision')); ?>"
            }
        })(jQuery);
    </script>
</body>

</html>
<?php /**PATH /var/www/html/core/resources/views/admin/layouts/master.blade.php ENDPATH**/ ?>