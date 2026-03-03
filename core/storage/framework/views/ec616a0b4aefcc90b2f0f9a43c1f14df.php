<?php
    $featurePageContent = @getContent('feature_page.content', true)->data_values;
    $featurePageElements = @getContent('feature_page.element', orderById: true);
?>

<?php $__env->startSection('content'); ?>
    <div class="key-feature-section banner-bg py-100">
        <div class="container">
            <div class="section-heading">
                <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s"><?php echo e(__(@$featurePageContent->heading)); ?></h1>
                <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s"><?php echo e(__(@$featurePageContent->subheading)); ?></p>
            </div>
            <div class="key-feature-container">
                <?php $__currentLoopData = $featurePageElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featurePageElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="key-feature-wrapper wow animationfadeUp" data-wow-delay="0.6s">
                        <div class="key-feature-wrapper__content">
                            <p class="key-feature-wrapper__top">
                                <span class="icon"> <i class="fa-solid fa-inbox"></i> </span>
                                <?php echo e(__(@$featurePageElement->data_values->title)); ?>

                            </p>
                            <h3 class="key-feature-wrapper__title"><?php echo e(__(@$featurePageElement->data_values->heading)); ?></h3>
                            <p class="key-feature-wrapper__desc"><?php echo e(__(@$featurePageElement->data_values->description)); ?></p>
                            <div class="why-choose-us">
                                <?php
                                    echo @$featurePageElement->data_values->benefits;
                                ?>
                            </div>
                        </div>
                        <div class="key-feature-wrapper__thumb">
                            <img src="<?php echo e(frontendImage('feature_page', @$featurePageElement->data_values->image, '635x340')); ?>"
                                alt="img">
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <?php if(@$sections->secs != null): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/features.blade.php ENDPATH**/ ?>