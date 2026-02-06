<!doctype html>
<html lang="<?php echo e(config('app.locale')); ?>" itemscope itemtype="http://schema.org/WebPage">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?php echo e(gs()->siteName(__($pageTitle))); ?></title>

    <meta name="P-A-ID" content="<?php echo e(config('app.PUSHER_APP_KEY')); ?>">
    <meta name="P-CLUSTER" content="<?php echo e(config('app.PUSHER_APP_CLUSTER')); ?>">
    <meta name="APP-DOMAIN" content="<?php echo e(route('home')); ?>">

    <?php echo $__env->make('partials.seo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <link href="<?php echo e(asset('assets/global/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/all.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>">

    <?php echo $__env->yieldPushContent('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/custom-animation.css')); ?>?v=1">

    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>?v=1">
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/main.css')); ?>">

    <?php echo $__env->yieldPushContent('style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e(gs('base_color')); ?>">
</head>
<?php echo loadExtension('google-analytics') ?>

<body>
    <div class="preloader">
        <span class="loader"></span>
    </div>
    <div class="body-overlay"></div>

    <div class="sidebar-overlay"></div>

    <?php echo $__env->yieldContent('app-content'); ?>

    <?php echo $__env->make('Template::partials.cookie', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script src="<?php echo e(asset('assets/global/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/main.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <script src="<?php echo e(asset('assets/global/js/global.js')); ?>"></script>
    <?php echo loadExtension('tawk-chat') ?>

    <?php echo $__env->make('partials.notify', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(gs('pn')): ?>
        <?php echo $__env->make('partials.push_script', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldPushContent('script'); ?>

</body>
<script>
    (function($) {
        "use strict";

        $('.policy').on('click', function() {
            $.get('<?php echo e(route('cookie.accept')); ?>', function(response) {
                $('.cookies-card').addClass('d-none');
            });
        });

        // event when change lang
        $(".langSel").on("click", function() {
            let lang = $(this).data('value');
            window.location.href = "<?php echo e(route('home')); ?>/change/" + lang;
        });

        //show cookie card
        setTimeout(function() {
            $('.cookies-card').removeClass('hide');
        }, 2000);
    })(jQuery);
</script>
</body>

</html>
<?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/layouts/app.blade.php ENDPATH**/ ?>