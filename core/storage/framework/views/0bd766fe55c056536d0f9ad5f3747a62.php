<script src="<?php echo e(asset('assets/global/js/whatsapp_floater.js')); ?>"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        "use strict";
        whatsAppSetup({
            mobile: "<?php echo e($floater->dial_code . $floater->mobile); ?>",
            message: <?php echo json_encode($floater->message, 15, 512) ?>,
            color: "#<?php echo e($floater->color_code); ?>"
        });
    });
</script>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/floater/floater_script.blade.php ENDPATH**/ ?>