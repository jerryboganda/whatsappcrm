<?php
    $contactContent = @getContent('contact.content', true)->data_values;
?>

<?php $__env->startSection('content'); ?>
    <div class="contact-section  py-100">
        <div class="container">
            <div class="section-heading">
                <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s">
                    <?php echo e(__(@$contactContent->heading)); ?></h1>
                <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s">
                    <?php echo e(__(@$contactContent->subheading)); ?></p>
            </div>
            <form class="contact-form verify-gcaptcha wow animationfadeUp" data-wow-delay="0.6s" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Your First Name'); ?></label>
                                    <input class="form--control" name="firstname" type="text"
                                        value="<?php echo e(old('firstname')); ?>" placeholder="<?php echo app('translator')->get('Enter your first name'); ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Your Last Name'); ?></label>
                                    <input class="form--control" name="lastname" type="text"
                                        value="<?php echo e(old('lastname')); ?>" placeholder="<?php echo app('translator')->get('Enter your last name'); ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Your Email'); ?></label>
                                    <input class="form--control" name="email" type="email" value="<?php echo e(old('email')); ?>"
                                        placeholder="<?php echo app('translator')->get('Enter your email'); ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 ps-xl-5">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Subject'); ?></label>
                                    <input class="form--control" name="subject" type="text" value="<?php echo e(old('subject')); ?>"
                                        placeholder="<?php echo app('translator')->get('Enter your subject'); ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label><?php echo app('translator')->get('Description'); ?></label>
                                    <textarea class="form--control" name="message" placeholder="<?php echo app('translator')->get('Write your message'); ?>" required><?php echo e(old('message')); ?></textarea>
                                </div>
                            </div>
                            <?php if (isset($component)) { $__componentOriginalff0a9fdc5428085522b49c68070c11d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalff0a9fdc5428085522b49c68070c11d6 = $attributes; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Captcha::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $attributes = $__attributesOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__attributesOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalff0a9fdc5428085522b49c68070c11d6)): ?>
<?php $component = $__componentOriginalff0a9fdc5428085522b49c68070c11d6; ?>
<?php unset($__componentOriginalff0a9fdc5428085522b49c68070c11d6); ?>
<?php endif; ?>
                            <div class="col-sm-12">
                                <button class="btn btn--base btn--lg w-100"><?php echo app('translator')->get('Send Message Now'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-12">
                        <div class="support-wrapper">
                            <div class="support-item">
                                <h3 class="support-item__top">
                                    <?php echo app('translator')->get('24/7'); ?>
                                </h3>
                                <h5 class="support-item__title"><?php echo app('translator')->get('Support Center'); ?></h5>
                                <p class="support-item__desc"><?php echo app('translator')->get('Whether you have a question, need support.'); ?></p>
                            </div>
                            <div class="support-item">
                                <h3 class="support-item__top"><?php echo app('translator')->get('FAQ'); ?></h3>
                                <h5 class="support-item__title"><?php echo app('translator')->get('Read all FAQ'); ?></h5>
                                <p class="support-item__desc"><?php echo app('translator')->get('Find answers to common questions in our FAQ below.'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row gy-4 justify-content-center wow animationfadeUp" data-wow-delay="0.8s">
                <div class="col-lg-4 col-sm-6">
                    <div class="contact-item">
                        <h5 class="contact-item__title"><?php echo e(__(@$contactContent->other_contact_title)); ?></h5>
                        <p class="contact-item__desc"><?php echo e(__(@$contactContent->other_contact_subtitle)); ?></p>
                        <div class="contact-item__bottom">
                            <p class="contact-item__text">
                                <a class="contact-item__link" href="mailto:<?php echo e(@$contactContent->contact_email); ?>">
                                    <span class="contact-item__icon"> <i class="fa-regular fa-envelope"></i></span>
                                    <?php echo e(@$contactContent->contact_email); ?>

                                </a>
                            </p>
                            <p class="contact-item__text">
                                <a class="contact-item__link" href="telto:<?php echo e(@$contactContent->contact_number); ?>">
                                    <span class="contact-item__icon"> <i class="fa-solid fa-phone-volume"></i></span>
                                    <?php echo e(@$contactContent->contact_number); ?>

                                </a>
                            </p>
                        </div>
                        <div class="contact-item__shape">
                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/con-1.png')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="contact-item">
                        <h5 class="contact-item__title"><?php echo e(__(@$contactContent->business_address_title)); ?></h5>
                        <p class="contact-item__desc"><?php echo e(__(@$contactContent->business_address_subtitle)); ?></p>
                        <div class="contact-item__bottom">
                            <p class="contact-item__text">
                                <span class="contact-item__icon"> <i class="fa-solid fa-location-dot"></i> </span>
                                <?php echo e(__(@$contactContent->contact_address)); ?>

                            </p>
                        </div>
                        <div class="contact-item__shape">
                            <img src="<?php echo e(getImage(@$activeTemplateTrue . 'images/con-2.png')); ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6">
                    <div class="contact-item">
                        <h5 class="contact-item__title"><?php echo e(__(@$contactContent->working_hours_title)); ?></h5>
                        <p class="contact-item__desc"><?php echo e(__(@$contactContent->working_hours_subtitle)); ?></p>
                        <div class="contact-item__bottom">
                            <div class="time-wrapper">
                                <span class="title"><?php echo app('translator')->get('Working Days'); ?>: </span>
                                <span class="time"> <?php echo e(__(@$contactContent->working_days)); ?> </span>
                            </div>
                            <div class="time-wrapper">
                                <span class="title"><?php echo app('translator')->get('Working Hours'); ?>: </span>
                                <span class="time"> <?php echo e(__(@$contactContent->working_hours)); ?></span>
                            </div>
                        </div>
                        <div class="contact-item__shape">
                            <img src="<?php echo e(getImage(@$activeTemplateTrue . 'images/con-3.png')); ?>" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if(@$sections->secs != null): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/contact.blade.php ENDPATH**/ ?>