<div class="chat-box">
    <div class="chat-box__shape">
        <img src="<?php echo e(getImage($activeTemplateTrue . 'images/chat-bg.png')); ?>" alt="">
    </div>
    <div class="chat-box__header">
        <div class="d-flex align-items-center gap-3">
            <div class="chat-box__item">
                <div class="chat-box__thumb">
                    <img class="avatar contact__profile"
                        src="<?php echo e(getImage($activeTemplateTrue . 'images/ch-1.png', isAvatar: true)); ?>" alt="image">
                </div>
                <div class="chat-box__content">
                    <p class="name contact__name"></p>
                    <p class="text contact__mobile"></p>
                </div>
            </div>
            <div class="chat-box__item">
                <select class="form--control select2 assign-agent" name="assignee_id" style="min-width: 150px;">
                    <option value=""><?php echo app('translator')->get('Unassigned'); ?></option>
                    <?php $__currentLoopData = $agents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($agent->id); ?>">
                            <?php echo e($agent->fullname); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        <div>
            <span class="template_button" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo app('translator')->get('Send message template'); ?>"><i class="las la-envelope-square"></i></span>
        </div>
    </div>
    <div class="msg-body">

    </div>
    <div class="chat-box__footer">
        <div class="block-wrapper d-flex align-items-center justify-content-center mb-3 d-none">
            <div class="blocked-message px-4 py-2 d-inline-flex align-items-center">
                <i class="las la-ban me-2 fs-5"></i>
                <?php if(auth()->guard()->check()): ?>
                    <span><?php echo app('translator')->get('This contact has been blocked'); ?></span>
                <?php else: ?>
                    <span><?php echo app('translator')->get('This contact has been blocked'); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <form class="chat-send-area no-submit-loader" id="message-form">
            <?php echo csrf_field(); ?>
            <div class="btn-group">
                <div class="chat-media">
                    <button class="chat-media__btn" type="button"> <i class="las la-plus"></i> </button>
                    <div class="chat-media__list">
                        <label for="interactive_list" class="media-item interactive_list_btn">
                            <span class="icon">
                                <i class="fa-solid fa-list"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Interactive List'); ?></span>
                            <input hidden class="media-input" name="interactive_list_id" type="number">
                        </label>
                        <label for="cta_url" class="media-item cta-url-btn">
                            <span class="icon">
                                <i class="fa-solid fa-paperclip"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('CTA Url'); ?></span>
                            <input hidden class="media-input" name="cta_url_id" type="number">
                        </label>
                        <label for="audio" class="media-item media_selector"
                            data-media-type="<?php echo e(Status::AUDIO_TYPE_MESSAGE); ?>">
                            <span class="icon">
                                <i class="fas fa-file-audio"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Audio'); ?></span>
                            <input hidden class="media-input" name="audio" type="file" accept="audio/*">
                        </label>
                        <label for="document" class="media-item media_selector"
                            data-media-type="<?php echo e(Status::DOCUMENT_TYPE_MESSAGE); ?>">
                            <span class="icon">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Document'); ?></span>
                            <input hidden class="media-input" name="document" type="file" accept="application/pdf">
                        </label>
                        <label for="video" class="media-item media_selector"
                            data-media-type="<?php echo e(Status::VIDEO_TYPE_MESSAGE); ?>">
                            <span class="icon">
                                <i class="fas fa-video"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Video'); ?></span>
                            <input class="media-input" name="video" type="file" accept="video/*" hidden>
                        </label>
                        <label for="location" class="media-item location-modal-btn">
                            <span class="icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Location'); ?></span>
                        </label>
                        <label class="media-item payment-modal-btn">
                            <span class="icon">
                                <i class="fa-solid fa-credit-card"></i>
                            </span>
                            <span class="title"><?php echo app('translator')->get('Request Payment'); ?></span>
                        </label>
                    </div>
                    <div class="chat-url__list">
                        <?php $__empty_1 = true; $__currentLoopData = $ctaUrls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="url-item select-url" data-id="<?php echo e(@$url->id); ?>" data-name="<?php echo e(@$url->name); ?>"
                                data-bs-toggle="tooltip" data-bs-title="<?php echo e(@$url->cta_url); ?>">
                                <span class="icon">
                                    <i class="fa-solid fa-paperclip"></i>
                                </span>
                                <span class="title"><?php echo e(@$url->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <label class="url-item">
                                <span class="icon">
                                    <i class="fa-solid fa-ban"></i>
                                </span>
                                <span class="title"><?php echo app('translator')->get('No CTA Link'); ?></span>
                            </label>
                        <?php endif; ?>
                    </div>
                    <div class="chat-list__wrapper">
                        <?php $__empty_1 = true; $__currentLoopData = $interactiveLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <label class="url-item select-list" data-id="<?php echo e(@$list->id); ?>" data-name="<?php echo e(@$list->name); ?>"
                                data-bs-toggle="tooltip" data-bs-title="<?php echo e(@$list->button_text); ?>">
                                <span class="icon">
                                    <i class="fa-solid fa-list"></i>
                                </span>
                                <span class="title"><?php echo e(@$list->name); ?></span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <label class="url-item">
                                <span class="icon">
                                    <i class="fa-solid fa-ban"></i>
                                </span>
                                <span class="title"><?php echo app('translator')->get('No Interactive List'); ?></span>
                            </label>
                        <?php endif; ?>
                    </div>
                </div>
                <label for="image" class="btn-item image-upload-btn media_selector"
                    data-media-type="<?php echo e(Status::IMAGE_TYPE_MESSAGE); ?>">
                    <i class="fa-solid fa-image"></i>
                    <input hidden class="image-input" name="image" type="file" accept=".jpg, .jpeg, .png">
                </label>
            </div>

            <div class="image-preview-container"></div>
            <div class="input-area d-flex align-center gap-2">
                <span class="emoji-icon cursor-pointer">
                    <i class="far fa-smile"></i>
                </span>
                <div class="emoji-container"></div>
                <div class="input-group">
                    <textarea name="message" class="form--control message-input"
                        placeholder="<?php echo app('translator')->get('Type your message here'); ?>" autocomplete="off"></textarea>
                </div>
                <button class="chating-btn" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M22 2L15 22L11 13L2 9L22 2Z" stroke="currentColor" stroke-width="1.5"
                            stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M22 2L11 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/message_box.blade.php ENDPATH**/ ?>