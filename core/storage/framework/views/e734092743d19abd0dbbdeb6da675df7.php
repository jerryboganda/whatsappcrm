<?php $__empty_1 = true; $__currentLoopData = $conversations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conversation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $unreadMessage = $conversation->unseenMessages->count();
        $lastMessage = @$conversation->lastMessage;
    ?>

    <a class="chat-list__item <?php echo e($activeConversationId == $conversation->id ? 'active' : ''); ?>"
        data-id="<?php echo e($conversation->id); ?>">
        <?php echo $__env->make('Template::user.contact.thumb', ['contact' => @$conversation->contact], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="chat-list__content">
            <div class="left">
                <p class="name"><?php echo e(__(@$conversation->contact->fullName)); ?></p>
                <div class="last-message">
                    <?php if(@$lastMessage->media_id): ?>
                        <p class="text text-muted">
                            <?php if($lastMessage->message_type == Status::VIDEO_TYPE_MESSAGE): ?>
                                <i class="las la-video"></i> <?php echo app('translator')->get('Video'); ?>
                            <?php elseif(@$lastMessage->message_type == Status::DOCUMENT_TYPE_MESSAGE): ?>
                                <i class="las la-file"></i> <?php echo app('translator')->get('Document'); ?>
                            <?php elseif(@$lastMessage->message_type == Status::AUDIO_TYPE_MESSAGE): ?>
                                <i class="las la-microphone"></i> <?php echo app('translator')->get('Audio'); ?>
                            <?php else: ?>
                                <i class="las la-image"></i> <?php echo app('translator')->get('Photo'); ?>
                            <?php endif; ?>
                        </p>
                    <?php elseif(@$lastMessage->template): ?>
                        <p class="last-message-text text <?php if($unreadMessage > 0): ?> text--bold <?php endif; ?>">
                            <?php echo app('translator')->get('Template Message'); ?>
                        </p>
                    <?php elseif(@$lastMessage->ctaUrl): ?>
                        <p class="text text-muted">
                            <i class="fa-solid fa-paperclip"></i> <?php echo app('translator')->get('Cta URL'); ?>
                        </p>
                    <?php elseif(@$lastMessage->list_reply && !empty(@$lastMessage->list_reply)): ?>
                        <p class="text text-muted"><i class="las la-undo"></i> <?php echo e(strLimit(@$lastMessage->list_reply['title'], 15)); ?></p>
                    <?php elseif(@$lastMessage->interactiveList): ?>
                        <p class="text text-muted">
                            <i class="fa-solid fa-list"></i> <?php echo app('translator')->get('Interactive List'); ?>
                        </p>
                    <?php elseif(@$lastMessage->message_type == Status::BUTTON_TYPE_MESSAGE): ?>
                        <p class="text text-muted">
                            <i class="las la-undo"></i> <?php echo app('translator')->get('Reply Button'); ?>
                        </p>
                    <?php else: ?>
                        <?php if(@$lastMessage->message_type == Status::LOCATION_TYPE_MESSAGE): ?>
                            <p class="text text-muted">
                                <i class="las la-map-marker-alt"></i> <?php echo app('translator')->get('Location'); ?>
                            </p>
                        <?php else: ?>
                            <p class="last-message-text text <?php if($unreadMessage > 0): ?> text--bold <?php endif; ?>">
                                <?php echo e(strLimit(@$lastMessage->message, 15)); ?>

                            </p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="right">
                <?php if(@$conversation->last_message_at): ?>
                    <p class="time last-message-at"><?php echo e(showDateTime(@$conversation->last_message_at)); ?></p>
                <?php endif; ?>
                <div class="unseen-message">
                    <?php if($unreadMessage > 0): ?>
                        <?php if($unreadMessage < 10): ?>
                            <span class="number"><?php echo e($unreadMessage); ?></span>
                        <?php else: ?>
                            <span class="number">9+</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <div class="empty-message text-center">
        <img src="<?php echo e(asset('assets/images/empty-con.png')); ?>" alt="empty">
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/conversation_list.blade.php ENDPATH**/ ?>