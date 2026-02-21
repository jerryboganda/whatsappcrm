<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Connect and configure multiple WhatsApp Business accounts from here'); ?>
                </p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <?php if(gs('whatsapp_embedded_signup')): ?>
                        <button type="button" class="btn btn--base btn-shadow whatsapp-connect" data-bs-toggle="tooltip"
                            title="<?php echo app('translator')->get('Connect your WhatsApp Business account to our platform with embedded signup'); ?>">
                            <i class="lab la-whatsapp"></i>
                            <?php echo app('translator')->get('Connect WhatsApp'); ?>
                        </button>
                    <?php endif; ?>
                    <a href="<?php echo e(route('user.whatsapp.account.add')); ?>" class="btn btn--base btn-shadow">
                        <i class="las la-plus"></i>
                        <?php echo app('translator')->get('Add New'); ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="dashboard-table">
                <div class="dashboard-table__top">
                    <h5 class="dashboard-table__title mb-0"><?php echo app('translator')->get('All Accounts'); ?></h5>
                </div>
                <table class="table table--responsive--lg">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Whatsapp Business Name'); ?></th>
                            <th><?php echo app('translator')->get('Whatsapp Business Number'); ?></th>
                            <th><?php echo app('translator')->get('Verification Status'); ?></th>
                            <th><?php echo app('translator')->get('Is Default Account'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $whatsappAccounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $whatsappAccount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e(__(@$whatsappAccount->business_name)); ?></td>
                                <td><?php echo e(@$whatsappAccount->phone_number); ?></td>
                                <td>
                                    <div>
                                        <?php echo $whatsappAccount->verificationStatusBadge; ?>
                                        <a title="<?php echo app('translator')->get('Get the current verification status of your whatsapp business account from Meta API'); ?>"
                                            href="<?php echo e(route('user.whatsapp.account.verification.check', $whatsappAccount->id)); ?>">
                                            <i class="las la-redo-alt"></i>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <?php if($whatsappAccount->is_default): ?>
                                        <span class="badge badge--success"><?php echo app('translator')->get('Yes'); ?></span>
                                    <?php else: ?>
                                        <span class="badge badge--danger"><?php echo app('translator')->get('No'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btn">
                                        <button class="action-btn__icon p-1">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <ul class="action-dropdown">
                                            <?php if(!$whatsappAccount->is_default): ?>
                                                <li class="action-dropdown__item">
                                                    <a class="action-dropdown__link"
                                                        href="<?php echo e(route('user.whatsapp.account.connect', $whatsappAccount->id)); ?>">
                                                        <span class="text"><i class="las la-check-circle"></i>
                                                            <?php echo app('translator')->get('Make Default Account'); ?>
                                                        </span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <li class="action-dropdown__item">
                                                <a class="action-dropdown__link"
                                                    href="<?php echo e(route('user.whatsapp.account.setting', $whatsappAccount->id)); ?>">
                                                    <span class="text">
                                                        <i class="las la-cog"></i>
                                                        <?php echo app('translator')->get('Change Token'); ?>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks($whatsappAccounts)); ?>

        </div>
    </div>

    <div class="modal fade custom--modal whatsapp-connect-modal" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Enter your desire pin number'); ?></h5>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php echo e(route('user.whatsapp.account.whatsapp.pin')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="form-group mb-3">
                            <label class="label-two"><?php echo app('translator')->get('Pin'); ?></label>
                            <input type="text" class="form--control form-two" name="pin"
                                placeholder="<?php echo app('translator')->get('Enter your pin'); ?>" required>
                        </div>
                        <input type="hidden" class="form--control form-two" name="waba_id">
                        <input type="hidden" class="form--control form-two" name="access_token">
                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100"><i class="lab la-telegram"></i>
                                <?php echo app('translator')->get('Submit'); ?></button>
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

<?php $__env->startPush('script-lib'); ?>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            var wabaId = null;
            var accessToken = null;

            window.fbAsyncInit = function() {
                FB.init({
                    appId: "<?php echo e(gs('meta_app_id')); ?>",
                    autoLogAppEvents: true,
                    xfbml: true,
                    version: 'v23.0'
                });
            };

            window.addEventListener('message', (event) => {
                if (!event.origin.endsWith('facebook.com')) return;

                try {
                    const data = JSON.parse(event.data);
                    if (data.type == 'WA_EMBEDDED_SIGNUP' && data.event == 'FINISH') {
                        wabaId = data.data.waba_id;
                        const payload = {
                            waba_id: data.data.waba_id,
                            business_id: data.data.business_id,
                            phone_number_id: data.data.phone_number_id,
                            _token: "<?php echo e(csrf_token()); ?>"
                        };

                        $.ajax({
                            url: "<?php echo e(route('user.whatsapp.account.embedded.signup')); ?>",
                            type: "POST",
                            data: payload,
                            success: function(res) {
                                if (res.data.success) {
                                    notify('success', res.message);
                                } else {
                                    notify('error', res.message);
                                }
                            },
                            error: function(err) {
                                notify("error", "<?php echo app('translator')->get('Failed to connect the business account'); ?>");
                            }
                        });
                    }
                } catch (e) {
                    notify("error", "<?php echo app('translator')->get('Failed to connect the business account'); ?>");
                }
            });

            const fbLoginCallback = (response) => {
                if (response.authResponse) {
                    const code = response.authResponse.code;
                    if (!code) return;
                    $(".preloader").fadeIn();
                    $.ajax({
                        url: "<?php echo e(route('user.whatsapp.account.access.token')); ?>",
                        type: "POST",
                        data: {
                            code: code,
                            waba_id: wabaId,
                            _token: "<?php echo e(csrf_token()); ?>"
                        },
                        success: function(res) {
                            $(".preloader").fadeOut();
                            if (res.data) {
                                notify('success', res.message);
                                accessToken = res.data.access_token;
                                launchPinModal(wabaId, accessToken);
                            } else {
                                notify('error', res.message);
                            }
                        },
                        error: function(err) {
                            $(".preloader").fadeOut();
                            notify("error", "<?php echo app('translator')->get('Failed to connect the business account'); ?>");
                        }
                    });
                } else {
                    notify("error", "<?php echo app('translator')->get('Embedded signup failed'); ?>");
                }
            }

            const launchWhatsAppSignup = () => {

                if ('<?php echo e($accountLimit); ?>' == false) {
                    notify("error", "<?php echo app('translator')->get('You have reached the maximum limit of WhatsApp account. Please upgrade your plan.'); ?>");
                    return;
                }

                FB.login(fbLoginCallback, {
                    config_id: "<?php echo e(gs('meta_configuration_id')); ?>",
                    response_type: 'code',
                    override_default_response_type: true,
                    extras: {
                        "version": "v23.0",
                        sessionInfoVersion: '3',
                        setup: {},
                    }
                });
            }

            $('.whatsapp-connect').on('click', function(e) {
                e.preventDefault();

                let appId = "<?php echo e(gs('meta_app_id')); ?>";
                let configurationId = "<?php echo e(gs('meta_configuration_id')); ?>";
                let appSecret = "<?php echo e(gs('meta_app_secret')); ?>";

                if (!appId || !configurationId || !appSecret) {
                    notify("error", "<?php echo app('translator')->get('The embedded signup feature is not available at this moment.'); ?>");
                    return;
                }

                launchWhatsAppSignup();
            });

            let refreshWarning = function(e) {
                e.preventDefault();
                e.returnValue = '⚠️ Are you sure? Your PIN setup will be lost!';
            };

            function launchPinModal(waba_id, access_token) {
                $('.whatsapp-connect-modal').find('input[name=waba_id]').val(waba_id);
                $('.whatsapp-connect-modal').find('input[name=access_token]').val(access_token);

                $('.whatsapp-connect-modal').modal('show');

                window.addEventListener("beforeunload", refreshWarning);
            }

            $('.whatsapp-connect-modal').on('hidden.bs.modal', function() {
                window.removeEventListener("beforeunload", refreshWarning);
            });

            $('.whatsapp-connect-modal form').on('submit', function() {
                window.removeEventListener("beforeunload", refreshWarning);
            });


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/whatsapp/accounts.blade.php ENDPATH**/ ?>