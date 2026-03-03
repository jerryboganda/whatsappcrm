<?php
    $user = auth()->user();
    $mobileNumber = $user->hasAgentPermission('view contact mobile')
        ? $conversation->contact->mobileNumber
        : showMobileNumber($conversation->contact->mobileNumber);
    $firstName = $user->hasAgentPermission('view contact name') ? $conversation->contact->firstname : '***';
    $lastName = $user->hasAgentPermission('view contact name') ? $conversation->contact->lastname : '***';
?>
<div class="body-right__top-btn">
    <span class="close-icon-two d-md-none">
        <i class="fas fa-times"></i>
    </span>
    <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'edit contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'edit contact']); ?>
        <a href="<?php echo e(route('user.contact.edit', @$conversation->contact->id)); ?>" class="text--info">
            <i class="las la-pen"></i>
            <?php echo app('translator')->get('Edit'); ?>
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
    <?php if($conversation->contact->is_blocked): ?>
        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'unblock contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'unblock contact']); ?>
            <button type="button" class="text--success confirmationBtn"
                data-action="<?php echo e(route('user.contact.unblock', $conversation->contact->id)); ?>?status=unblock"
                data-question="<?php if(@$conversation->contact?->blockedBy->is_agent): ?> <?php echo app('translator')->get('This contact was blocked by '); ?> <?php echo e(@$conversation->contact?->blockedBy?->username); ?>. <?php endif; ?> <?php echo app('translator')->get('Are you sure to unblock this contact?'); ?>">
                <i class="las la-check-circle"></i>
                <?php echo app('translator')->get('Unblock'); ?>
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
    <?php else: ?>
        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'block contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'block contact']); ?>
            <button type="button" class="text--danger confirmationBtn"
                data-action="<?php echo e(route('user.contact.block', $conversation->contact->id)); ?>?status=block"
                data-question="<?php echo app('translator')->get('Are you sure to block this contact?'); ?>">
                <i class="las la-ban"></i>
                <?php echo app('translator')->get('Block'); ?>
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
    <?php endif; ?>
</div>
<div class="profile-details">
    <div class="profile-details__top">
        <div class="profile-thumb">
            <img src="<?php echo e($conversation->contact->image_src); ?>" alt="image">
        </div>
        <p class="profile-name mb-0"><?php echo e(__(@$conversation->contact->fullName)); ?></p>
        <p class="text fs-14">
            <?php if($user->hasAgentPermission('view contact mobile')): ?>
                <a href="tel:<?php echo e(@$conversation->contact->mobileNumber); ?>"
                    class="link">+<?php echo e(@$conversation->contact->mobileNumber); ?></a>
            <?php else: ?>
                <span class="link">+<?php echo e(@$mobileNumber); ?></span>
            <?php endif; ?>
        </p>
    </div>
    <div class="profile-details__tab">
        <ul class="nav nav-pills custom--tab tab-two" id="pills-tabtwo" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="pills-details-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-details" type="button" role="tab" aria-controls="pills-details"
                    aria-selected="true"><?php echo app('translator')->get('Details'); ?></button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="pills-not-tab" data-bs-toggle="pill" data-bs-target="#pills-not"
                    type="button" role="tab" aria-controls="pills-not"
                    aria-selected="false"><?php echo app('translator')->get('Note'); ?></button>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContenttwo">
            <div class="tab-pane fade show active" id="pills-details" role="tabpanel"
                aria-labelledby="pills-details-tab" tabindex="0">
                <div class="details-content">

                    <p class="details-content__text d-flex gap-1 flex-wrap justify-content-between">
                        <span class="title"><?php echo app('translator')->get('First Name'); ?> : </span>
                        <span><?php echo e(__(@$firstName)); ?></span>
                    </p>
                    <p class="details-content__text d-flex gap-1 flex-wrap justify-content-between">
                        <span class="title"><?php echo app('translator')->get('Last Name'); ?> : </span>
                        <span><?php echo e(__(@$lastName)); ?></span>
                    </p>
                    <p class="details-content__text d-flex gap-1 flex-wrap justify-content-between">
                        <span class="title"><?php echo app('translator')->get('Mobile'); ?> : </span>
                        <span><?php echo e(@$mobileNumber); ?></span>
                    </p>
                    <p class="details-content__text d-flex gap-1 flex-wrap justify-content-between">
                        <span class="title"><?php echo app('translator')->get('Crated At'); ?> : </span>
                        <span><?php echo e(showDateTime(@$conversation->contact->created_at, 'd M Y')); ?></span>
                    </p>
                    <p class="details-content__text d-flex gap-1 flex-wrap justify-content-between">
                        <span class="title"><?php echo app('translator')->get('Last Modified'); ?> : </span>
                        <span><?php echo e(showDateTime(@$conversation->contact->updated_at, 'd M Y')); ?></span>
                    </p>
                    <?php $__currentLoopData = $conversation->contact->details ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($value)): ?>
                            <p class="details-content__text">
                                <span class="title"> <?php echo e(__(ucfirst($key))); ?></span>
                                <span><?php echo e(__($value)); ?></span>
                            </p>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <div class="details-content__tag">
                        <p class="tag-title"> <?php echo app('translator')->get('Tags'); ?>: </p>
                        <ul class="tag-list justify-content-start">
                            <?php $__currentLoopData = $conversation->contact->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a target="_blank"
                                        href="<?php echo e(route('user.contact.list')); ?>?tag_id=<?php echo e($tag->id); ?>"
                                        class="tag-list__link"><?php echo e(__(@$tag->name)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="details-content__status statusForm">
                        <form>
                            <?php echo csrf_field(); ?>
                            <p class="status-title"> <?php echo app('translator')->get('Conversation Status'); ?> </p>
                            <select class="form-select  form--control form-two" name="conversation_status">
                                <option value="0"><?php echo app('translator')->get('No Status'); ?></option>
                                <option <?php if($conversation->status == Status::PENDING_CONVERSATION): echo 'selected'; endif; ?> value="<?php echo e(Status::PENDING_CONVERSATION); ?>">
                                    <?php echo app('translator')->get('Pending'); ?>
                                </option>
                                <option <?php if($conversation->status == Status::IMPORTANT_CONVERSATION): echo 'selected'; endif; ?> value="<?php echo e(Status::IMPORTANT_CONVERSATION); ?>">
                                    <?php echo app('translator')->get('Important'); ?>
                                </option>
                                <option <?php if($conversation->status == Status::DONE_CONVERSATION): echo 'selected'; endif; ?> value="<?php echo e(Status::DONE_CONVERSATION); ?>">
                                    <?php echo app('translator')->get('Done'); ?>
                                </option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pills-not" role="tabpanel" aria-labelledby="pills-not-tab" tabindex="0">
                <div class="note-wrapper">
                    <form class="note-wrapper__form">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="conversation_id" value="<?php echo e($conversation->id); ?>">
                        <label for="note" class="form--label"><?php echo app('translator')->get('Add Note'); ?></label>
                        <textarea id="note" class="form--control" name="note" placeholder="<?php echo app('translator')->get('Write a note...'); ?>"></textarea>
                        <div class="note-wrapper__btn">
                            <button class="btn btn--base btn-shadow"><?php echo app('translator')->get('Add'); ?></button>
                        </div>
                    </form>
                    <div class="note-wrapper__output">
                        <?php $__currentLoopData = $conversation->notes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $note): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="output">
                                <div>
                                    <p class="text"> <?php echo e(__(@$note->note)); ?></p>
                                    <span class="date"> <?php echo e(showDateTime(@$note->created_at, 'd M Y')); ?></span>
                                </div>
                                <span class="icon deleteNote" data-id="<?php echo e($note->id); ?>">
                                    <i class="fas fa-trash text--danger"></i>
                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/contact_details.blade.php ENDPATH**/ ?>