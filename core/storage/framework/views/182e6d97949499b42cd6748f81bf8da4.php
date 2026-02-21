<?php $__env->startSection('content'); ?>
    <div class="row gy-4">
        <?php $__empty_1 = true; $__currentLoopData = $welcomeMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $welcomeMessage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-xl-6 col-lg-12 col-md-6">
                <div class="chatbot-top-item">
                    <div class="chatbot-top-item__header">
                        <div>
                            <h4 class="title"> <?php echo app('translator')->get('Welcome Message'); ?>👋 -
                                <?php echo e(__($welcomeMessage->whatsappAccount->phone_number)); ?>

                            </h4>
                            <span class="d-block fs-14">
                                <?php echo e(__($welcomeMessage->whatsappAccount->business_name)); ?>

                            </span>
                        </div>
                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'edit welcome message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'edit welcome message']); ?>
                            <div class="form--switch two">
                                <input class="form-check-input status-switch" type="checkbox" role="switch"
                                    <?php if($welcomeMessage->status): echo 'checked'; endif; ?>
                                    data-action="<?php echo e(route('user.automation.welcome.message.status', $welcomeMessage->id)); ?>"
                                    data-message-enable="<?php echo app('translator')->get('Are you sure to enable this welcome message'); ?>" data-message-disable="<?php echo app('translator')->get('Are you sure to disable this welcome message'); ?>" />
                            </div>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                    </div>
                    <p class="chatbot-top-item__desc">
                        <?php echo $welcomeMessage->message ?>
                    </p>
                    <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'edit welcome message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'edit welcome message']); ?>
                        <div class="chatbot-top-item__btn">
                            <button class="btn btn--white btn--sm edit-btn" data-message='<?php echo json_encode($welcomeMessage, 15, 512) ?>'>
                                <i class="la la-pen"></i> <?php echo app('translator')->get('Edit Message'); ?>
                            </button>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="chatbot-top-item text-center py-5">
                    <div class="py-5">
                        <button class="btn btn--base btn-shadow add-btn mb-2" type="button">
                            <i class="las la-plus"></i>
                            <?php echo app('translator')->get('Create First Welcome Message'); ?>
                        </button>
                        <p><?php echo app('translator')->get('Add a engaging welcome message to your WhatsApp Business account to create a great first impression'); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'add welcome message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'add welcome message']); ?>
            <?php if($accounts->count() && $welcomeMessages->count()): ?>
                <div class="col-xl-6 col-lg-12 col-md-6">
                    <div class="chatbot-top-item text-center py-5">
                        <button class="btn btn--base btn-shadow add-btn mb-2" type="button">
                            <i class="las la-plus"></i> <?php echo app('translator')->get('New Welcome Message'); ?>
                        </button>
                        <p><?php echo app('translator')->get('Add a more engaging welcome message to your WhatsApp Business account to create a great first impression'); ?></p>
                    </div>
                </div>
            <?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
    </div>

    <div class="modal fade custom--modal" id="modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Add Welcome Message'); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="icon">
                            <i class="fas fa-times"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="<?php echo e(route('user.automation.welcome.message.store')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('Whatsapp Account'); ?></label>
                            <select name="whatsapp_account_id" class="form-control form-tow select2"
                                data-minimum-results-for-search="-1">
                                <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($account->id); ?>">
                                        <?php echo e(__($account->business_name)); ?>(<?php echo e($account->phone_number); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('Response'); ?></label>
                            <textarea class="form--control form-two" name="message" placeholder="<?php echo app('translator')->get('Enter Response Text'); ?>"></textarea>
                        </div>
                        <div class="form-group d-flex gap-2 flex-wrap">
                            <button type="button" class="btn btn--white " data-bs-dismiss="modal">
                                <i class="la la-times"></i> <?php echo app('translator')->get('Cancel'); ?>
                            </button>
                            <button type="submit" class="btn  btn--base">
                                <i class="la la-telegram"></i> <?php echo app('translator')->get('Save Message'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isFrontend' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            const $modal = $('#modal');
            const $confirmationModal = $('#confirmationModal');

            $('.add-btn').on('click', function() {
                const action = "<?php echo e(route('user.automation.welcome.message.store')); ?>";
                $modal.find('.modal-title').text('Add Your Welcome Message');
                $modal.find('form').trigger('reset');
                $modal.find(`form`).attr('action', action);
                $modal.find('select[name=whatsapp_account_id]').closest('.form-group').removeClass('d-none');
                $modal.modal('show');
            });


            $('.status-switch').on('click', function(e) {
                e.preventDefault();

                const action = $(this).data('action');
                const messageEnable = $(this).data('message-enable');
                const messageDisable = $(this).data('message-disable');

                if (e.target.checked) {
                    $confirmationModal.find(".question").text(messageEnable)
                } else {
                    $confirmationModal.find(".question").text(messageDisable)
                }
                $confirmationModal.find('form').attr('action', action);
                $confirmationModal.modal('show');
            });


            $('.edit-btn').on('click', function() {
                const message = $(this).data('message');
                const action = "<?php echo e(route('user.automation.welcome.message.store', ':id')); ?>";
                $modal.find('.modal-title').text('Edit Welcome Message');
                $modal.find('textarea[name=message]').val(message.message);
                $modal.find('select[name=whatsapp_account_id]').closest('.form-group').addClass('d-none');
                $modal.find(`form`).attr('action', action.replace(":id", message.id));
                $modal.modal('show');
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/automation/welcome_message.blade.php ENDPATH**/ ?>