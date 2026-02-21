<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['isFrontend' => false]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['isFrontend' => false]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div id="confirmationModal" class="modal fade <?php if($isFrontend): ?> custom--modal  <?php endif; ?>" tabindex="-1" role="dialog"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body  <?php if(!$isFrontend): ?> py-4 px-5 <?php endif; ?>">
                    <div class="text-center mb-4">
                        <h1 class=" text--warning mb-0">
                            <span class="icon">
                                <i class="la la-warning"></i>
                            </span>
                        </h1>
                        <h4 class="mb-2"><?php echo app('translator')->get('Please Confirm!'); ?></h4>
                        <p class="question"></p>
                    </div>
                    <div class="d-flex gap-3 flex-wrap pt-2 pb-3">
                        <div class="flex-fill">
                            <button type="button"
                                class="btn w-100 <?php if(!$isFrontend): ?> btn--danger btn-large <?php else: ?> btn-outline--danger <?php endif; ?> "
                                data-bs-dismiss="modal">
                                <i class="fa-regular fa-circle-xmark"></i> <?php echo app('translator')->get('No'); ?>
                            </button>
                        </div>
                        <div class="flex-fill">
                            <button type="submit"
                                class="btn w-100 btn-large <?php if($isFrontend): ?> btn-outline--base <?php else: ?> btn--primary <?php endif; ?>">
                                <i class="fa-regular fa-check-circle"></i> <?php echo app('translator')->get('Yes'); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $(document).on('click', '.confirmationBtn', function() {
                var modal = $('#confirmationModal');
                let data = $(this).data();
                modal.find('.question').text(`${data.question}`);
                modal.find('form').attr('action', `${data.action}`);
                modal.modal('show');
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/components/confirmation-modal.blade.php ENDPATH**/ ?>