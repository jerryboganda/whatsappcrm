<?php
    $isUnread = $message->status != Status::READ;
    $boldClass = $isUnread ? ' text--bold' : '';
?>

<div class="last-message" data-conversation-id="<?php echo e($message->conversation_id); ?>">
    <?php if($message->media_id): ?>
        <?php if($message->message_type === Status::VIDEO_TYPE_MESSAGE): ?>
            <p class="text text-muted<?php echo e($boldClass); ?>">
                <i class="las la-video"></i> <?php echo e(__('Video')); ?>

            </p>
        <?php elseif($message->message_type === Status::DOCUMENT_TYPE_MESSAGE): ?>
            <p class="text text-muted<?php echo e($boldClass); ?>">
                <i class="las la-file"></i> <?php echo e(__('Document')); ?>

            </p>
        <?php elseif($message->message_type === Status::AUDIO_TYPE_MESSAGE): ?>
            <p class="text text-muted<?php echo e($boldClass); ?>">
                <i class="las la-microphone"></i> <?php echo e(__('Audio')); ?>

            </p>
        <?php else: ?>
            <p class="text text-muted<?php echo e($boldClass); ?>">
                <i class="las la-image"></i> <?php echo e(__('Photo')); ?>

            </p>
        <?php endif; ?>
    <?php elseif($message->message_type === Status::URL_TYPE_MESSAGE): ?>
        <p class="text text-muted<?php echo e($boldClass); ?>">
            <i class="fa-solid fa-paperclip"></i> <?php echo e(__('Cta URL')); ?>

        </p>
    <?php elseif($message->list_reply && !empty($message->list_reply)): ?>
        <p class="text text-muted"><i class="las la-undo"></i> <?php echo e($message->list_reply['title']); ?></p>
    <?php elseif($message->message_type === Status::LIST_TYPE_MESSAGE): ?>
        <p class="text text-muted<?php echo e($boldClass); ?>">
            <i class="fa-solid fa-list"></i> <?php echo e(__('Interactive List')); ?>

        </p>
    <?php elseif($message->message_type === Status::BUTTON_TYPE_MESSAGE): ?>
        <p class="text text-muted<?php echo e($boldClass); ?>">
            <i class="las la-undo"></i> <?php echo e(__('Reply Button')); ?>

        </p>
    <?php elseif($message->template): ?>
        <p class="text text-muted<?php echo e($boldClass); ?>">
            <i class="las la-envelope-square"></i> <?php echo e(__('Template Message')); ?>

        </p>
    <?php else: ?>
        <?php
            $shortMessage = strLimit($message->message, 15);
        ?>

        <?php if($message->message_type === Status::LOCATION_TYPE_MESSAGE): ?>
            <p class="text text-muted<?php echo e($boldClass); ?>">
                <i class="fa-solid fa-location-dot"></i> <?php echo e(__('Location')); ?>

            </p>
        <?php else: ?>
            <p class="text<?php echo e($boldClass); ?>"><?php echo e(e($shortMessage)); ?></p>
        <?php endif; ?>
    <?php endif; ?>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/conversation_last_message.blade.php ENDPATH**/ ?>