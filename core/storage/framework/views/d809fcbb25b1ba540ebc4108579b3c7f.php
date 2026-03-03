<?php
    $faqContent  = @getContent('faq.content', true)->data_values;
    $faqElements = @getContent('faq.element', orderById: true)->groupBy('data_values.category');
?>
<div class="faq-section pb-100">
    <div class="container">
        <div class="section-heading">
            <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s"><?php echo e(__(@$faqContent->heading)); ?></h1>
            <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s"><?php echo e(__(@$faqContent->subheading)); ?></p>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="faq-section__top wow animationfadeUp" data-wow-delay="0.6s">
                    <ul class="nav nav-pills custom--tab" id="pills-tab" role="tablist">
                        <?php $__currentLoopData = $faqElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" 
                                    id="pills-<?php echo e(slug($category)); ?>-tab" 
                                    data-bs-toggle="pill"
                                    data-bs-target="#pills-<?php echo e(slug($category)); ?>" 
                                    type="button" role="tab"
                                    aria-controls="pills-<?php echo e(slug($category)); ?>"
                                    aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>">
                                    <?php echo e(ucfirst($category)); ?>

                                </button>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
                <div class="tab-content wow animationfadeUp" data-wow-delay="0.8s" id="pills-tabContent">
                    <?php $__currentLoopData = $faqElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $faqs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="tab-pane fade <?php echo e($loop->first ? 'show active' : ''); ?>" 
                            id="pills-<?php echo e(slug($category)); ?>" 
                            role="tabpanel"
                            aria-labelledby="pills-<?php echo e(slug($category)); ?>-tab">
                            
                            <div class="accordion custom--accordion" id="accordion-<?php echo e(slug($category)); ?>">
                                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-<?php echo e($faq->id); ?>">
                                            <button class="accordion-button <?php echo e($loop->first && $loop->parent->first ? '' : 'collapsed'); ?>" 
                                                type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#collapse-<?php echo e($faq->id); ?>" 
                                                aria-expanded="<?php echo e($loop->first && $loop->parent->first ? 'true' : 'false'); ?>" 
                                                aria-controls="collapse-<?php echo e($faq->id); ?>">
                                                <?php echo e(__($faq->data_values->question)); ?>

                                            </button>
                                        </h2>
                                        <div id="collapse-<?php echo e($faq->id); ?>" class="accordion-collapse collapse <?php echo e($loop->first && $loop->parent->first ? 'show' : ''); ?>" 
                                            aria-labelledby="heading-<?php echo e($faq->id); ?>" 
                                            data-bs-parent="#accordion-<?php echo e(slug($category)); ?>">
                                            <div class="accordion-body">
                                                <p class="text">
                                                    <?php echo e(__($faq->data_values->answer)); ?>

                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/sections/faq.blade.php ENDPATH**/ ?>