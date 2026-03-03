<?php
    $blogContent = @getContent('blog.content', true)->data_values;
?>


<?php $__env->startSection('content'); ?>
    <section class="blog-section  py-100">
        <div class="container">
            <div class="section-heading">
                <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s"><?php echo e(__(@$blogContent->heading)); ?>

                </h1>
                <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s"><?php echo e(__(@$blogContent->subheading)); ?>

                </p>
            </div>
            <div class="blog-bottom-section">
                <div class="row gy-4 justify-content-center">
                    <?php $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-sm-6 wow animationfadeUp" data-wow-delay="0.6s">
                            <div class="blog-item">
                                <div class="blog-item__thumb">
                                    <a href="<?php echo e(route('blog.details', @$blog->slug)); ?>" class="blog-item__thumb-link">
                                        <img src="<?php echo e(frontendImage('blog', 'thumb_' . @$blog->data_values->image)); ?>"
                                            class="fit-image" alt="image">
                                    </a>
                                </div>
                                <div class="blog-item__content">
                                    <h5 class="blog-item__title">
                                        <a href="<?php echo e(route('blog.details', $blog->slug)); ?>"
                                            class="blog-item__title-link border-effect">
                                            <?php echo e(__(@$blog->data_values->title)); ?> </a>
                                    </h5>
                                    <p class="blog-item__desc"><?php echo strLimit(strip_tags(__(@$blog->data_values->description)), 100) ?></p>
                                    <div class="blog-item__bottom">
                                        <ul class="content-list">
                                            <li class="content-list__item">
                                                <?php echo e(showDateTime(@$blog->created_at, 'd M, Y')); ?>

                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php if($blogs->hasPages()): ?>
                    <div class="dark-pagination">
                        <?php echo e($blogs->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if(@$sections->secs != null): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/blogs.blade.php ENDPATH**/ ?>