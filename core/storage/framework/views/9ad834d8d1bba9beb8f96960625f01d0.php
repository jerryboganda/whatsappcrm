<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <form method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="container-top">
                <div class="container-top__left">
                    <h5 class="container-top__title"><?php echo app('translator')->get('Manage Your Account'); ?></h5>
                    <p class="container-top__desc"><?php echo app('translator')->get('Update your account details, preferences, and more'); ?></p>
                </div>
                <div class="container-top__right">
                    <div class="btn--group">
                        <a href="<?php echo e(route('user.home')); ?>" class="btn btn--dark btn-shadow">
                            <i class="las la-tachometer-alt"></i>
                            <?php echo app('translator')->get('Go to Dashboard'); ?>
                        </a>
                        <button type="submit" class="btn btn--base btn-shadow">
                            <i class="lab la-telegram"></i>
                            <?php echo app('translator')->get('Save Changes'); ?>
                        </button>
                    </div>
                </div>
            </div>
            <div class="dashboard-container__body">
                <div class="profile-header">
                    <h5 class="profile-header__title"><?php echo app('translator')->get('Profile Picture'); ?></h5>
                    <div class="profile-header__thumb">
                        <div class="file-upload">
                            <label class="edit" for="profile_image"><i class="las la-plus"></i></label>
                            <input type="file" name="profile_image" class="form--control form-two" id="profile_image"
                                hidden>
                        </div>
                        <div class="thumb">
                            <img class="image-preview" src="<?php echo e(@$user->imageSrc); ?>" alt="profile">
                        </div>
                    </div>
                    <p class="thumb-size"> <?php echo app('translator')->get('Recommended profile image size'); ?> : <span class="number"> <?php echo app('translator')->get('350x300.'); ?></span>
                        <?php echo app('translator')->get('Supported files'); ?> <span class="number"><?php echo app('translator')->get('.jpg'); ?>, <?php echo app('translator')->get('.png'); ?>
                            <?php echo app('translator')->get('.jpeg'); ?></span>
                    </p>
                </div>
                <div class="profile-info">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Firstname'); ?></label>
                                <input type="text" class="form--control form-two" placeholder="<?php echo app('translator')->get('Enter your first name'); ?>"
                                    name="firstname" value="<?php echo e($user->firstname); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Lastname'); ?></label>
                                <input type="text" class="form--control form-two" placeholder="<?php echo app('translator')->get('Enter your last name'); ?>"
                                    name="lastname" value="<?php echo e($user->lastname); ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Email'); ?></label>
                                <input type="email" class="form--control form-two" name="email"
                                    value="<?php echo e($user->email); ?>" readonly required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label> <?php echo app('translator')->get('Mobile'); ?> </label>
                                <div class="input-group select-input">
                                    <select class="form-select form--control form-two select2" name="dial_code" disabled>
                                        <option value="<?php echo e($user->dial_code); ?>"><?php echo e($user->dial_code); ?></option>
                                    </select>
                                    <input type="number" class="form--control form-two form-control" name="mobile"
                                        value="<?php echo e($user->mobile); ?>" readonly required>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('City'); ?></label>
                                <input type="city" class="form--control form-two" name="city"
                                    value="<?php echo e(@$user->city); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('State'); ?></label>
                                <input type="text" class="form--control form-two" name="state"
                                    value="<?php echo e(@$user->state); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label><?php echo app('translator')->get('Zip'); ?></label>
                                <input type="text" class="form--control form-two" name="zip"
                                    value="<?php echo e(@$user->zip); ?>">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label> <?php echo app('translator')->get('Country'); ?> </label>
                                <select class="form-select form--control form-two select2" disabled>
                                    <option value="<?php echo e($user->country_name); ?>"><?php echo e(__(@$user->country_name)); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('topbar_tabs'); ?>
    <?php echo $__env->make('Template::partials.profile_tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        ::placeholder {
            color: hsl(var(--black)/0.5) !important;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('#profile_image').on('change', function() {
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('.image-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/profile_setting.blade.php ENDPATH**/ ?>