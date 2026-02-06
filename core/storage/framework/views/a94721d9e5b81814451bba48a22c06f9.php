<?php
    $bannerContent = @getContent('banner.content',true)->data_values;
?>
<section class="banner-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="banner-content">
                    <h1 class="banner-content__title wow animationfadeUp" data-wow-delay="0.2s"><?php echo e(__(@$bannerContent->heading)); ?></h1>
                    <p class="banner-content__desc wow animationfadeUp" data-wow-delay="0.4s"> <?php echo e(__(@$bannerContent->subheading)); ?> </p>
                    <div class="banner-content__button wow animationfadeUp" data-wow-delay="0.6s">
                        <a href="<?php echo e(@$bannerContent->button_url); ?>" class="btn--base-two btn"> <?php echo e(__(@$bannerContent->button_text)); ?> </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section><?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/sections/banner.blade.php ENDPATH**/ ?>