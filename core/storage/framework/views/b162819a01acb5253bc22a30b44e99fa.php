<?php
    $footerContent = @getContent('footer.content', true)->data_values;
    $policies = @getContent('policy_pages.element', orderById: true);
    $socialIcons = @getContent('social_icon.element', orderById: true);
    $contactContent = @getContent('contact.content', true)->data_values;
?>

<footer class="footer-area">
    <div class="shape-bg two"></div>
    <div class="shape-bg three"></div>
    <div class="shape-bg four"></div>
    <div class="pt-100">
        <div class="container">
            <div class="footer-item__logo wow animationfadeUp" data-wow-delay="0.2s">
                <a href="<?php echo e(route('home')); ?>"> <img src="<?php echo e(siteLogo('dark')); ?>" alt="img"></a>
            </div>
            <div class="row gy-5 justify-content-between">
                <div class="col-xl-4 col-sm-7 wow animationfadeUp" data-wow-delay="0.2s">
                    <div class="footer-item">
                        <p class="footer-item__desc"><?php echo e(__(@$footerContent->description)); ?></p>
                        <div class="search-wrapper">
                            <p class="search-wrapper__title"><?php echo e(__(@$footerContent->subscribe_title)); ?></p>
                            <form class="search-form subscribe-form no-submit-loader mt-0">
                                <input type="email" class="form--control" placeholder="<?php echo app('translator')->get('Enter your email'); ?>" required>
                                <button class="btn--base btn" type="submit">
                                    <?php echo app('translator')->get('Submit'); ?>
                                </button>
                            </form>
                            <p class="search-wrapper__text"><?php echo e(__(@$footerContent->subscribe_subtitle)); ?></p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-5 col-6 wow animationfadeUp" data-wow-delay="0.4s">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Quick Links'); ?> </h5>
                        <ul class="footer-menu">
                            <li class="footer-menu__item">
                                <a href="<?php echo e(route('home')); ?>" class="footer-menu__link"><?php echo app('translator')->get('Home'); ?></a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="<?php echo e(route('blogs')); ?>" class="footer-menu__link"><?php echo app('translator')->get('Blog'); ?></a>
                            </li>
                            <li class="footer-menu__item">
                                <a href="<?php echo e(route('contact')); ?>" class="footer-menu__link"><?php echo app('translator')->get('Contact'); ?></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-2 col-sm-7 col-6 wow animationfadeUp" data-wow-delay="0.6s">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Policy Page'); ?></h5>
                        <ul class="footer-menu">
                            <?php $__currentLoopData = $policies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-menu__item">
                                    <a href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>"
                                        class="footer-menu__link"><?php echo e(__(@$policy->data_values->title)); ?>

                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="footer-menu__item">
                                <a href="<?php echo e(route('cookie.policy')); ?>" class="footer-menu__link">
                                    <?php echo app('translator')->get('Cookie Policy'); ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-5 wow animationfadeUp" data-wow-delay="0.8s">
                    <div class="footer-item">
                        <h5 class="footer-item__title"><?php echo app('translator')->get('Contact Info'); ?></h5>
                        <ul class="footer-contact-menu">
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <a
                                        href="mailto:<?php echo e(@$contactContent->contact_email); ?>"><?php echo e(@$contactContent->contact_email); ?></a>
                                </div>
                            </li>
                            <li class="footer-contact-menu__item">
                                <div class="footer-contact-menu__item-icon">
                                    <i class="las la-phone"></i>
                                </div>
                                <div class="footer-contact-menu__item-content">
                                    <a
                                        href="tel:<?php echo e(@$contactContent->contact_number); ?>"><?php echo e(@$contactContent->contact_number); ?></a>
                                </div>
                            </li>
                        </ul>
                        <div class="share-btn-wrapper">
                            <h5 class="title">
                                <span class="icon">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16.707 9.80175L7.95698 19.1768C7.86426 19.2757 7.74186 19.3418 7.60827 19.3651C7.47467 19.3884 7.33712 19.3676 7.21638 19.3059C7.09564 19.2441 6.99825 19.1448 6.93892 19.0229C6.87958 18.9009 6.86152 18.763 6.88745 18.6299L8.03276 12.901L3.53042 11.2103C3.43373 11.1742 3.3475 11.1146 3.27944 11.037C3.21138 10.9594 3.16361 10.8661 3.1404 10.7655C3.11718 10.6649 3.11925 10.5601 3.14641 10.4605C3.17357 10.3609 3.22498 10.2696 3.29605 10.1947L12.046 0.819721C12.1388 0.720764 12.2612 0.654652 12.3948 0.631359C12.5284 0.608067 12.6659 0.628858 12.7867 0.690597C12.9074 0.752335 13.0048 0.851671 13.0641 0.973613C13.1234 1.09555 13.1415 1.23349 13.1156 1.3666L11.9671 7.10175L16.4695 8.79003C16.5655 8.82645 16.651 8.88594 16.7185 8.96326C16.7861 9.04058 16.8335 9.13334 16.8567 9.23334C16.8798 9.33335 16.878 9.43753 16.8514 9.53666C16.8247 9.6358 16.7741 9.72684 16.7039 9.80175H16.707Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <?php echo app('translator')->get('Share and Earn!'); ?>
                            </h5>
                            <a href="<?php echo e(route('user.referral.index')); ?>" class="btn--base btn btn--sm w-100">
                                <span class="btn-icon"> <i class="fas fa-share-alt"></i> </span>
                                <?php echo app('translator')->get('Get Referral Link'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bottom-footer wow animationfadeUp" data-wow-delay="0.4s">
                <ul class="social-list">
                    <?php $__currentLoopData = $socialIcons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialIcon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="social-list__item">
                            <a target="_blank" href="<?php echo e(@$socialIcon->data_values->url); ?>"
                                class="social-list__link flex-center">
                                <?php echo $socialIcon->data_values->social_icon ?>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <div class="bottom-footer-text wow animationfadeUp" data-wow-delay="0.6s">
                    &copy; <?php echo app('translator')->get('Copyright'); ?>
                    <?php echo e(date('Y')); ?> <?php echo app('translator')->get('. All rights reserved.'); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        (function($) {
            let form = $('.subscribe-form');
            let isSubmitting = false;
            form.on('submit', function(e) {
                e.preventDefault();

                if (isSubmitting) return;

                let email = form.find('input').val();
                let token = '<?php echo e(csrf_token()); ?>';
                let url = "<?php echo e(route('subscribe')); ?>"

                let data = {
                    email: email,
                    _token: token
                }

                isSubmitting = true;
                $.post(url, data, function(response) {
                    if (response.success) {
                        notify('success', response.message);
                        $(form).trigger('reset');
                    } else {
                        notify('error', response.message);
                    }
                }).always(function() {
                    isSubmitting = false;
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>