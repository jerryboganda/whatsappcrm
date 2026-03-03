<?php
    $featureContent = @getContent('feature.content', true)->data_values;
    $featureElements = @getContent('feature.element', orderById: true);
?>
<div class="feature-section pb-100">
    <div class="container">
        <div class="section-heading">
            <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s"> <?php echo e(__(@$featureContent->heading)); ?> </h1>
            <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s"> <?php echo e(__(@$featureContent->subheading)); ?> </p>
        </div>
        <div class="row gy-4 justify-content-center">
            <?php $__currentLoopData = $featureElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $featureElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-lg-4 col-sm-6 wow animationfadeUp" data-wow-delay="0.6s">
                    <div class="feature-item">
                        <div class="feature-item__icon">
                            <?php echo @$featureElement->data_values->feature_icon; ?>
                        </div>
                        <h5 class="feature-item__title"> <?php echo e(__(@$featureElement->data_values->title)); ?> </h5>
                        <p class="feature-item__desc"><?php echo e(__(@$featureElement->data_values->description)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/sections/feature.blade.php ENDPATH**/ ?>