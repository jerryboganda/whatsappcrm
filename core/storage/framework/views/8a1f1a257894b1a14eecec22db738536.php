<?php $__env->startSection('panel'); ?>
    <div class="row responsive-row">
        <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'answer tickets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'answer tickets']); ?>
            <div class="col-12">
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                    <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'd-flex justify-content-between']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'd-flex justify-content-between']); ?>
                        <div>
                            <?php echo $ticket->statusBadge; ?>
                            [<?php echo app('translator')->get('Ticket#'); ?><?php echo e($ticket->ticket); ?>] <?php echo e($ticket->subject); ?>

                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $attributes = $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $component = $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal82a520cb144a92d0fb68c226771dfec2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82a520cb144a92d0fb68c226771dfec2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <form action="<?php echo e(route('admin.ticket.reply', $ticket->id)); ?>" enctype="multipart/form-data"
                            method="post">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" required id="inputMessage" placeholder="<?php echo app('translator')->get('Enter reply here'); ?>"></textarea>
                            </div>
                            <div class="form-group">
                                <div class="d-flex gap-2 flex-wrap mb-2 flex-between align-items-start">
                                    <span class="text--info fs-14">
                                        <?php echo app('translator')->get('You can upload up to 5 files with a maximum size of '); ?> <?php echo e(convertToReadableSize(ini_get('upload_max_filesize'))); ?>.
                                        <?php echo app('translator')->get('Supported file formats include .jpg, .jpeg, .png, .pdf, .doc, and .docx.'); ?>
                                    </span>
                                    <div class="d-flex gap-2  flex-wrap">
                                        <button type="button"
                                            class="btn  btn--secondary btn-large addAttachment flex-fill">
                                            <i class="fas fa-plus"></i>
                                            <?php echo app('translator')->get('Add Attachment'); ?>
                                        </button>
                                        <button class="btn btn--primary btn-large flex-fill" type="submit"
                                            name="replayTicket" value="1"><i class="la la-fw la-lg la-reply"></i>
                                            <?php echo app('translator')->get('Reply'); ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="row fileUploadsContainer">
                                </div>
                            </div>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $attributes = $__attributesOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $component = $__componentOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__componentOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
            </div>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12">
                <?php if($message->admin_id == 0): ?>
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => ['class' => 'border--warning']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'border--warning']); ?>
                        <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'd-flex justify-content-between gap-2 flex-wrap align-items-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'd-flex justify-content-between gap-2 flex-wrap align-items-center']); ?>
                            <div>
                                <?php if($ticket->user_id != null): ?>
                                    <h4 class="card-title">
                                        <a
                                            href="<?php echo e(route('admin.users.detail', $ticket->user_id)); ?>"><?php echo e($ticket->name); ?></a>
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </h4>
                                <?php else: ?>
                                    <h4 class="card-title"><?php echo e($ticket->name); ?></h4>
                                <?php endif; ?>
                                <small class="text--info">
                                    <?php echo app('translator')->get('Posted on'); ?> <?php echo e(showDateTime($message->created_at, 'l, dS F Y @ h:i a')); ?>

                                </small>
                            </div>
                            <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'close tickets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'close tickets']); ?>
                                <button class="btn btn--danger  confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to delete this message?'); ?>"
                                    data-action="<?php echo e(route('admin.ticket.delete', $message->id)); ?>">
                                    <i class="la la-trash"></i>
                                    <?php echo app('translator')->get('Delete'); ?>
                                </button>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $attributes = $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $component = $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal82a520cb144a92d0fb68c226771dfec2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82a520cb144a92d0fb68c226771dfec2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <p><?php echo e($message->message); ?></p>
                            <?php if($message->attachments->count() > 0): ?>
                                <div class="my-3">
                                    <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('admin.ticket.download', encrypt($image->id))); ?>"
                                            class="fw-semibold">
                                            <i class="las la-file"></i> <?php echo app('translator')->get('Attachment'); ?>
                                            <?php echo e(++$k); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $attributes = $__attributesOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $component = $__componentOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__componentOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                <?php else: ?>
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                        <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'd-flex justify-content-between gap-2 flex-wrap align-items-center']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'd-flex justify-content-between gap-2 flex-wrap align-items-center']); ?>
                            <div>
                                <h4 class="card-title">
                                    <?php echo e(@$message->admin->name); ?> -
                                    <span class="text-muted"><?php echo app('translator')->get('Staff'); ?></span>
                                </h4>
                                <small class="text--info">
                                    <?php echo app('translator')->get('Posted on'); ?> <?php echo e(showDateTime($message->created_at, 'l, dS F Y @ h:i a')); ?>

                                </small>
                            </div>
                            <button class="btn btn--danger  confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure to delete this message?'); ?>"
                                data-action="<?php echo e(route('admin.ticket.delete', $message->id)); ?>">
                                <i class="la la-trash"></i>
                                <?php echo app('translator')->get('Delete'); ?>
                            </button>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $attributes = $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $component = $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginal82a520cb144a92d0fb68c226771dfec2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82a520cb144a92d0fb68c226771dfec2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                            <p><?php echo e($message->message); ?></p>
                            <?php if($message->attachments->count() > 0): ?>
                                <div class="my-3">
                                    <?php $__currentLoopData = $message->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('admin.ticket.download', encrypt($image->id))); ?>"
                                            class="fw-semibold">
                                            <i class="las la-file"></i> <?php echo app('translator')->get('Attachment'); ?>
                                            <?php echo e(++$k); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $attributes = $__attributesOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $component = $__componentOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__componentOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php $component->withAttributes([]); ?>
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

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <div class="d-flex gap-2 flex-wrap">
        <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'close tickets']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'close tickets']); ?>
            <?php if($ticket->status != Status::TICKET_CLOSE): ?>
                <button class="btn btn--danger confirmationBtn " type="button" data-question="<?php echo app('translator')->get('Are you want to close this support ticket?'); ?>"
                    data-action="<?php echo e(route('admin.ticket.close', $ticket->id)); ?>">
                    <i class="la la-times"></i> <?php echo app('translator')->get('Close Ticket'); ?>
                </button>
            <?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginalc4d8d95c188d79b991fa2fe282f00172 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc4d8d95c188d79b991fa2fe282f00172 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.back_btn','data' => ['route' => ''.e(route('admin.ticket.index')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('back_btn'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => ''.e(route('admin.ticket.index')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc4d8d95c188d79b991fa2fe282f00172)): ?>
<?php $attributes = $__attributesOriginalc4d8d95c188d79b991fa2fe282f00172; ?>
<?php unset($__attributesOriginalc4d8d95c188d79b991fa2fe282f00172); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc4d8d95c188d79b991fa2fe282f00172)): ?>
<?php $component = $__componentOriginalc4d8d95c188d79b991fa2fe282f00172; ?>
<?php unset($__componentOriginalc4d8d95c188d79b991fa2fe282f00172); ?>
<?php endif; ?>
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            $('.delete-message').on('click', function(e) {
                $('.message_id').val($(this).data('id'));
            })
            var fileAdded = 0;
            $('.addAttachment').on('click', function() {
                fileAdded++;
                if (fileAdded == 5) {
                    $(this).attr('disabled', true)
                }
                $(".fileUploadsContainer").append(`
                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 removeFileInput">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="file" name="attachments[]" class="form-control" accept=".jpeg,.jpg,.png,.pdf,.doc,.docx" required>
                            <button type="button" class="input-group-text removeFile bg--danger border--danger text-white"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                </div>
                `)
            });
            $(document).on('click', '.removeFile', function() {
                $('.addAttachment').removeAttr('disabled', true)
                fileAdded--;
                $(this).closest('.removeFileInput').remove();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/admin/support/reply.blade.php ENDPATH**/ ?>