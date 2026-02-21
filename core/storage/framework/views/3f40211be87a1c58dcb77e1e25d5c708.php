<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Organize and manage your contact list for easily manage your contacts.'); ?></p>
            </div>
            <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'add contact list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'add contact list']); ?>
                <div class="container-top__right">
                    <div class="btn--group">
                        <button class="btn btn--base btn-shadow add-btn"><i class="las la-plus"></i>
                            <?php echo app('translator')->get('Add New'); ?></button>
                    </div>
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
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" placeholder="<?php echo app('translator')->get('Search here'); ?>..." name="search"
                            value="<?php echo e(request()->search); ?>">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--md">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Contacts'); ?></th>
                            <th><?php echo app('translator')->get('Created At'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contactList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__(@$contactList->name)); ?></td>
                                <td><?php echo e(@$contactList->contact()->count()); ?>

                                    <?php echo e(str()->plural('contact', @$contactList->contact()->count())); ?></td>
                                <td><?php echo e(showDateTime(@$contactList->created_at)); ?> </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'edit contact list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'edit contact list']); ?>
                                            <button type="button" class="action-btn edit-btn text--base"
                                                data-contact-list='<?php echo json_encode($contactList, 15, 512) ?>' data-bs-toggle="tooltip"
                                                data-bs-title="<?php echo app('translator')->get('Edit'); ?>"> <i class="fas fa-pen"></i>
                                            </button>
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
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'view list contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'view list contact']); ?>
                                            <a class="text--info"
                                                href="<?php echo e(route('user.contactlist.view', $contactList->id)); ?>"
                                                data-bs-toggle="tooltip" data-bs-title="<?php echo app('translator')->get('View'); ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
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
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'delete contact list']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'delete contact list']); ?>
                                            <button type="button" class="action-btn delete-btn confirmationBtn"
                                                data-question="<?php echo app('translator')->get('Are you sure to remove this contact from the contact list?'); ?>"
                                                data-action="<?php echo e(route('user.contactlist.delete', $contactList->id)); ?>"
                                                data-bs-toggle="tooltip" data-bs-title="<?php echo app('translator')->get('Delete'); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
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
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks($contactLists)); ?>

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

    <div class="modal fade custom--modal add-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('New Contact List'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label class="label-two"><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form--control form-two" name="name"
                                placeholder="<?php echo app('translator')->get('Enter list name'); ?>" value="<?php echo e(old('name')); ?>" required>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100"><i class="lab la-telegram"></i>
                                <?php echo app('translator')->get('Submit'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            const $modal = $('.add-modal');

            $('.add-btn').on('click', function() {
                $modal.find('form').trigger('reset');
                $modal.find('form').attr('action', "<?php echo e(route('user.contactlist.save')); ?>");
                $modal.find('.modal-title').text("<?php echo app('translator')->get('New Contact List'); ?>");
                $modal.modal('show');
            });

            $('.edit-btn').on('click', function() {
                let contactList = $(this).data('contact-list');
                let route = "<?php echo e(route('user.contactlist.update', ':id')); ?>";
                $modal.find('form').attr('action', route.replace(':id', contactList.id));
                $modal.find('input[name=name]').val(contactList.name);
                $modal.find('.modal-title').text("<?php echo app('translator')->get('Edit Contact List'); ?>");
                $modal.modal('show');
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact_list/list.blade.php ENDPATH**/ ?>