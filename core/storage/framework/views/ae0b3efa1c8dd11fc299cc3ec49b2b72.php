<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">

        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc">
                    <?php echo app('translator')->get('On this page you’ll able to change access token for the WhatsApp Business Account. Make sure you have taken the access token from your'); ?>
                    <a target="_blank" href="https://developers.facebook.com/apps/">
                        <i class="la la-external-link"></i> <?php echo app('translator')->get('Meta Dashboard'); ?>
                    </a>
                </p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.whatsapp.account.index')); ?>" class="btn btn--dark"><i class="las la-undo"></i>
                        <?php echo app('translator')->get('Back'); ?></a>
                    <button type="submit" form="whatsapp-meta-form" class="btn btn--base btn-shadow">
                        <i class="lab la-telegram"></i>
                        <?php echo app('translator')->get('Update Token'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <form id="whatsapp-meta-form" method="POST"
                action="<?php echo e(route('user.whatsapp.account.setting.confirm', @$whatsappAccount->id)); ?>">
                <?php echo csrf_field(); ?>
                <div class="row gy-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('Business Name'); ?></label>
                            <input type="text" class="form--control form-two" name="business_name"
                                placeholder="<?php echo app('translator')->get('Enter your business name'); ?>"
                                value="<?php echo e(@$whatsappAccount->business_name); ?>" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('WhatsApp Number'); ?></label>
                            <input type="text" class="form--control form-two" name="whatsapp_number"
                                placeholder="<?php echo app('translator')->get('Enter your WhatsApp number with country code'); ?>"
                                value="<?php echo e(@$whatsappAccount->phone_number); ?>" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('WhatsApp Business Account ID'); ?></label>
                            <input type="text" class="form--control form-two" name="whatsapp_business_account_id"
                                placeholder="<?php echo app('translator')->get('Enter business account ID'); ?>"
                                value="<?php echo e(@$whatsappAccount->whatsapp_business_account_id); ?>" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="label-two"><?php echo app('translator')->get('WhatsApp Phone Number ID'); ?></label>
                            <input type="text" class="form--control form-two" name="phone_number_id"
                                placeholder="<?php echo app('translator')->get('Enter phone number ID'); ?>"
                                value="<?php echo e(@$whatsappAccount->phone_number_id); ?>" readonly required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="label-two">
                                <?php echo app('translator')->get('Meta Access Token'); ?>
                            </label>
                            <i class="fas fa-info-circle text--info ms-1" data-toggle="tooltip" data-placement="top"
                                title="<?php echo app('translator')->get('If you change the access token, the current token will be expired.'); ?>">
                            </i>
                            <input type="text" class="form--control form-two" name="meta_access_token"
                                placeholder="<?php echo app('translator')->get('Enter your access token'); ?>" value="<?php echo e(@$whatsappAccount->access_token); ?>"
                                required>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row pt-4 mt-4 border-top">
                <div class="col-12">
                    <h5 class="mb-3"><?php echo app('translator')->get('Commerce Settings'); ?></h5>
                    <form action="<?php echo e(route('user.whatsapp.account.setting.commerce', $whatsappAccount->id)); ?>"
                        method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="row gy-4">
                            <div class="col-md-6">
                                <div
                                    class="form-group d-flex align-items-center justify-content-between border p-3 rounded">
                                    <label class="label-two mb-0"><?php echo app('translator')->get('Enable Cart'); ?></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_cart_enabled" value="1"
                                            <?php if($whatsappAccount->is_cart_enabled ?? true): echo 'checked'; endif; ?>>
                                    </div>
                                </div>
                                <small
                                    class="text-muted"><?php echo app('translator')->get('Allow customers to add items to a cart and send it to you.'); ?></small>
                            </div>
                            <div class="col-md-6">
                                <div
                                    class="form-group d-flex align-items-center justify-content-between border p-3 rounded">
                                    <label class="label-two mb-0"><?php echo app('translator')->get('Catalog Visible'); ?></label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="is_catalog_visible" value="1"
                                            <?php if($whatsappAccount->is_catalog_visible ?? true): echo 'checked'; endif; ?>>
                                    </div>
                                </div>
                                <small class="text-muted"><?php echo app('translator')->get('Show your catalog icon in the chat view.'); ?></small>
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn--base btn-shadow w-100"><?php echo app('translator')->get('Update Commerce Settings'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('topbar_tabs'); ?>
    <?php echo $__env->make('Template::partials.profile_tab', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/whatsapp/setting_waba_account.blade.php ENDPATH**/ ?>