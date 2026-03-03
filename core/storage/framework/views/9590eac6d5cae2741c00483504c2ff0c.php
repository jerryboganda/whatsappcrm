<?php
    $url = urlencode(url()->current());
    $title = urlencode($blog->data_values->title);
?>

<?php $__env->startSection('content'); ?>
    <section class="blog-detials py-100 ">
        <div class="container">
            <div class="row gy-5 justify-content-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="blog-details">
                        <div class="blog-details__thumb">
                            <img src="<?php echo e(frontendImage('blog', @$blog->data_values->image)); ?>" class="fit-image"
                                alt="">
                        </div>
                        <div class="blog-details__content">
                            <div class="blog-details__top">
                                <h3 class="blog-details__title"> <?php echo e(__(@$blog->data_values->title)); ?> </h3>
                                <ul class="content-list">
                                    <li class="content-list__item"> <?php echo e(showDateTime($blog->created_at, 'd M, Y')); ?> </li>
                                </ul>
                            </div>
                            <div class="content-item">
                                <?php echo @$blog->data_values->description ?>
                            </div>
                            <div class="fb-comments" data-href="<?php echo e(url()->current()); ?>" data-numposts="5"></div>
                            <div class="blog-details__share ">
                                <h5 class="social-share__title mb-4"> <?php echo app('translator')->get('Share this Blog'); ?> </h5>
                                <ul class="social-list">
                                    <li class="social-list__item">
                                        <a target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e($url); ?>"
                                            class="social-list__link flex-center"><i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a target="_blank"
                                            href="https://twitter.com/intent/tweet?url=<?php echo e($url); ?>&text=<?php echo e($title); ?>"
                                            class="social-list__link flex-center active"> <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a target="_blank"
                                            href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo e($url); ?>"
                                            class="social-list__link flex-center"> <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li class="social-list__item">
                                        <a target="_blank"
                                            href="https://pinterest.com/pin/create/button/?url=<?php echo e($url); ?>&description=<?php echo e($title); ?>"
                                            class="social-list__link flex-center"> <i class="fab fa-pinterest"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="blog-bottom-section pb-100 mb-100">
        <div class="container">
            <h4 class="title"> <?php echo app('translator')->get('More Blogs'); ?> </h4>
            <div class="blog-wrapper">
                <div class="blog-slider">
                    <?php $__currentLoopData = $allBlogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blog-item">
                            <div class="blog-item__thumb">
                                <a href="<?php echo e(route('blog.details', $blogElement->slug)); ?>" class="blog-item__thumb-link">
                                    <img src="<?php echo e(frontendImage('blog', 'thumb_' . $blogElement->data_values->image)); ?>"
                                        class="fit-image" alt="">
                                </a>
                            </div>
                            <div class="blog-item__content">
                                <h5 class="blog-item__title">
                                    <a href="<?php echo e(route('blog.details', $blogElement->slug)); ?>"
                                        class="blog-item__title-link border-effect"><?php echo e(__(@$blogElement->data_values->title)); ?></a>
                                </h5>
                                <p class="blog-item__desc"> <?php echo strLimit(strip_tags(__(@$blogElement->data_values->description)), 100) ?> </p>
                                <div class="blog-item__bottom">
                                    <ul class="content-list">
                                        <li class="content-list__item">
                                            <?php echo e(showDateTime($blogElement->created_at, 'd M, Y')); ?>

                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('fbComment'); ?>
    <?php echo loadExtension('fb-comment') ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .content-item p {
            color: hsl(var(--body-color)/0.8);
        }
    </style>
<?php $__env->stopPush(); ?>


<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/blog_details.blade.php ENDPATH**/ ?>