 <?php
     $baseText = $message->message ?? '';
     $escapedText = e($baseText);

     $messageText = preg_replace_callback(
         '/([a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,})|((https?:\/\/|www\.)[^\s@]+|[a-z0-9\-]+\.[a-z]{2,}(\/[^\s@]*)?)/i',
         function ($matches) {
             if (!empty($matches[1])) {
                 $email = $matches[1];
                 return '<a href="mailto:' . $email . '">' . $email . '</a>';
             }
             $url = $matches[0];
             $href = preg_match('/^https?:\/\//i', $url) ? $url : 'https://' . $url;
             return '<a href="' . $href . '" target="_blank" rel="noopener noreferrer">' . $url . '</a>';
         },
         $escapedText,
     );

 ?>

 <div class="single-message <?php echo e(@$message->type == Status::MESSAGE_SENT ? 'message--right' : 'message--left'); ?>"
     data-message-id="<?php echo e($message->id); ?>">
     <div class="message-content">
         <?php if($message->template_id): ?>
             <p class="message-text"><i class="las la-envelope-square"></i> <?php echo app('translator')->get('Template Message'); ?></p>
         <?php elseif($message->cta_url_id): ?>
             <?php if($message->ctaUrl): ?>
                 <div class="card custom--card border-0 rounded-0 p-0">
                     <div class="card-header pb-0 rounded-0">
                         <?php if(@$message->ctaUrl->header_format == 'IMAGE'): ?>
                             <img src="<?php echo e(@$message->ctaUrl->header['image']['link']); ?>"
                                 class="card-img-top cta-header-img m-0" alt="header_image">
                         <?php else: ?>
                             <h5 class="card-title text-black"><?php echo e(@$message->ctaUrl->header['text']); ?></h5>
                         <?php endif; ?>
                     </div>
                     <div class="card-body my-2">
                         <p class="card-text"><?php echo e(@$message->ctaUrl->body['text']); ?></p>
                     </div>
                     <div class="card-footer border-bottom border-top-0 p-0 pb-2">
                         <small class="text-start text-muted"><?php echo e(@$message->ctaUrl->footer['text']); ?></small>
                     </div>
                     <a href="<?php echo e(@$message->ctaUrl->cta_url); ?>" target="_blank" class="text-center pt-2">
                         <svg viewBox="0 0 19 18" height="18" width="19" preserveAspectRatio="xMidYMid meet"
                             version="1.1">
                             <path
                                 d="M14,5.41421356 L9.70710678,9.70710678 C9.31658249,10.0976311 8.68341751,10.0976311 8.29289322,9.70710678 C7.90236893,9.31658249 7.90236893,8.68341751 8.29289322,8.29289322 L12.5857864,4 L10,4 C9.44771525,4 9,3.55228475 9,3 C9,2.44771525 9.44771525,2 10,2 L14,2 C15.1045695,2 16,2.8954305 16,4 L16,8 C16,8.55228475 15.5522847,9 15,9 C14.4477153,9 14,8.55228475 14,8 L14,5.41421356 Z M14,12 C14,11.4477153 14.4477153,11 15,11 C15.5522847,11 16,11.4477153 16,12 L16,13 C16,14.6568542 14.6568542,16 13,16 L5,16 C3.34314575,16 2,14.6568542 2,13 L2,5 C2,3.34314575 3.34314575,2 5,2 L6,2 C6.55228475,2 7,2.44771525 7,3 C7,3.55228475 6.55228475,4 6,4 L5,4 C4.44771525,4 4,4.44771525 4,5 L4,13 C4,13.5522847 4.44771525,14 5,14 L13,14 C13.5522847,14 14,13.5522847 14,13 L14,12 Z"
                                 fill="currentColor" fill-rule="nonzero"></path>
                         </svg>
                         <?php echo e(@$message->ctaUrl->action['parameters']['display_text']); ?>

                     </a>
                 </div>
             <?php else: ?>
                 <p class="message-text"><?php echo app('translator')->get('Cta URL Message'); ?></p>
             <?php endif; ?>
         <?php elseif($message->interactive_list_id && $message->message_type == Status::LIST_TYPE_MESSAGE): ?>
             <?php if($message->interactiveList): ?>
                 <div class="card custom--card border-0 rounded-0 p-0">
                     <div class="card-header pb-0 rounded-0">
                         <h6 class="card-title text-black"><?php echo e(@$message->interactiveList->header['text']); ?></h6>
                     </div>
                     <div class="card-body my-2">
                         <p class="card-text"><?php echo e(@$message->interactiveList->body['text']); ?></p>
                     </div>
                     <div class="card-footer border-bottom border-top-0 p-0 pb-2">
                         <small class="text-start text-muted"><?php echo e(@$message->interactiveList->footer['text']); ?></small>
                     </div>
                     <button
                         class="text-center d-flex align-items-center justify-content-center gap-2 pt-2 text--base list-message-btn"
                         data-list="<?php echo e($message->interactiveList); ?>">
                         <i class="las la-list fs-18"></i>
                         <span class="text--base"><?php echo e(@$message->interactiveList->button_text); ?></span>
                     </button>
                 </div>
             <?php else: ?>
                 <p class="message-text"><?php echo app('translator')->get('Interactive List Message'); ?></p>
             <?php endif; ?>
         <?php elseif($message->message_type == Status::BUTTON_TYPE_MESSAGE): ?>
             <?php if(@$message->node && @$message->node->buttons_json): ?>
                 <?php
                     $buttonData = json_decode($message->node->buttons_json, true);
                 ?>
                 <div class="card custom--card border-0 rounded-0 p-0">
                     <div class="card-body my-2">
                         <p class="card-text"><?php echo e(@$buttonData['body']); ?></p>
                     </div>
                     <div class="card-footer border-bottom border-top-0 p-0 pb-2">
                         <small class="text-start text-muted"><?php echo e(@$buttonData['footer']); ?></small>
                     </div>
                     <?php $__currentLoopData = @$buttonData['buttons']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <button
                             class="text-center d-flex align-items-center justify-content-center gap-2 pt-2 text--base
                                <?php if (! ($loop->last)): ?> border-bottom <?php endif; ?> border-top-0">

                             <i class="las la-undo fs-18"></i>
                             <span class="text--base"><?php echo e($item['text']); ?></span>
                         </button>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                 </div>
             <?php else: ?>
                 <p class="message-text"><?php echo app('translator')->get('Reply Button Message'); ?></p>
             <?php endif; ?>
         <?php elseif($message->list_reply && !empty($message->list_reply)): ?>
             <p class="message-text"><?php echo e($message->list_reply['title']); ?></p>
             <p class="message-text"><?php echo e($message->list_reply['description']); ?></p>
         <?php else: ?>
             <?php if($message->media_caption): ?>
                 <p class="message-text"><?php echo nl2br($message->media_caption); ?></p>
             <?php elseif($message->message_type == Status::LOCATION_TYPE_MESSAGE): ?>
                 <?php
                     $latitude = $message->location['latitude'] ?? null;
                     $longitude = $message->location['longitude'] ?? null;
                     $address = $message->location['address'] ?? null;
                     $name = $message->location['name'] ?? 'Location';

                     if ($latitude && $longitude) {
                         $mapsUrl = "https://www.google.com/maps/search/?api=1&query={$latitude},{$longitude}";
                         if ($address) {
                             $mapsUrl .= '&query=' . urlencode($address);
                         }
                     } else {
                         $mapsUrl = '#';
                     }
                 ?>
                 <div class="text-dark">
                     <a href="<?php echo e($mapsUrl); ?>" target="_blank" class="text--primary download-document">
                         <img class="message-image" src="<?php echo e(asset('assets/images/location_preview.png')); ?>"
                             alt="image">
                     </a>
                     <div>
                         <p class="fs-14 fw-bold"><?php echo e($name); ?></p>
                         <p class="fs-12"><?php echo e($address); ?></p>
                     </div>
                 </div>
             <?php else: ?>
                 <p class="message-text"><?php echo nl2br($messageText); ?></p>
             <?php endif; ?>
             <?php if(@$message->media_id): ?>
                 <?php if(@$message->message_type == Status::IMAGE_TYPE_MESSAGE): ?>
                     <a href="<?php echo e(route('user.inbox.media.download', $message->media_id)); ?>">
                         <img class="message-image"
                             src="<?php echo e(getImage(getFilePath('conversation') . '/' . @$message->media_path)); ?>"
                             alt="image">
                     </a>
                 <?php endif; ?>
                 <?php if(@$message->message_type == Status::VIDEO_TYPE_MESSAGE): ?>
                     <div class="text-dark d-flex align-items-center justify-content-between">
                         <a href="<?php echo e(route('user.inbox.media.download', $message->media_id)); ?>"
                             class="text--primary download-document">
                             <img class="message-image" src="<?php echo e(asset('assets/images/video_preview.png')); ?>"
                                 alt="image">
                         </a>
                     </div>
                 <?php endif; ?>
                 <?php if(@$message->message_type == Status::DOCUMENT_TYPE_MESSAGE): ?>
                     <div class="text-dark d-flex justify-content-between flex-column">
                         <a href="<?php echo e(route('user.inbox.media.download', $message->media_id)); ?>"
                             class="text--primary download-document">
                             <img class="message-image" src="<?php echo e(asset('assets/images/document_preview.png')); ?>"
                                 alt="image">
                         </a>
                         <?php echo e(@$message->media_filename ?? 'Document'); ?>

                     </div>
                 <?php endif; ?>
                 <?php if(@$message->message_type == Status::AUDIO_TYPE_MESSAGE): ?>
                     <div class="text-dark d-flex justify-content-between flex-column">
                         <a href="<?php echo e(route('user.inbox.media.download', $message->media_id)); ?>"
                             class="text--primary download-document">
                             <img class="message-image audio-image"
                                 src="<?php echo e(asset('assets/images/audio_preview.png')); ?>" alt="image">
                         </a>
                         <?php echo e(@$message->media_filename ?? 'Audio'); ?>

                     </div>
                 <?php endif; ?>
             <?php endif; ?>
         <?php endif; ?>
         <?php if(auth()->guard()->check()): ?>
             <?php if(
                 @auth()->user()->aiSetting->status &&
                     $message->type == Status::MESSAGE_RECEIVED &&
                     $message->message_type == Status::TEXT_TYPE_MESSAGE &&
                     @auth()->user()->ai_assistance == Status::YES): ?>
                 <div class="ai-translate-button" data-message-text="<?php echo e($message->message); ?>">
                     <span class="text--base" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('Click here for translate text from the AI assistance'); ?>">
                         <i class="las la-language"></i>
                     </span>
                 </div>
                 <div class="ai-response-button" data-customer-message="<?php echo e($message->message); ?>">
                     <span class="text--base" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo app('translator')->get('Click here for generate response from the AI assistance'); ?>">
                         <i class="las la-robot"></i>
                     </span>
                 </div>
             <?php endif; ?>
         <?php endif; ?>
     </div>
     <div class="d-flex align-items-center justify-content-between">
         <span class="message-time"><?php echo e(showDateTime(@$message->created_at, 'h:i A')); ?>

             <?php if(auth()->guard()->check()): ?>
                 <?php if($message->agent): ?>
                     | <span class="message-time">
                         <?php echo app('translator')->get('Sent by'); ?>
                         <?php echo e(@$message->agent->username); ?>

                     </span>
                 <?php endif; ?>
                 <?php if(isParentUser() && $message->ai_reply == Status::YES): ?>
                     | <span class="message-time text--info"><?php echo app('translator')->get('AI Response'); ?></span>
                 <?php endif; ?>
                 <?php if($message->flow_id): ?>
                     | <span class="message-time text--info"><?php echo app('translator')->get('Flow Response'); ?></span>
                 <?php endif; ?>
                 <?php if($message->list_reply && !empty($message->list_reply)): ?>
                     | <span class="message-time text--info"><?php echo app('translator')->get('List Reply'); ?></span>
                 <?php endif; ?>
             <?php endif; ?>
         </span>
         <?php if(@$message->type == Status::MESSAGE_SENT): ?>
             <span class="message-status">
                 <?php echo $message->statusBadge ?>
             </span>
         <?php endif; ?>
     </div>
 </div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/single_message.blade.php ENDPATH**/ ?>