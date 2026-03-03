<?php
    @$pricingPlans = \App\Models\PricingPlan::active()->orderBy('monthly_price', 'asc')->get();
    @$user = auth()->user();
?>
<?php $__currentLoopData = $pricingPlans ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pricingPlan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-lg-4 col-md-6 wow animationfadeUp" data-wow-delay="0.6s">
        <div
            class="pricing-card <?php if($pricingPlan->is_popular): ?> popular <?php endif; ?>  <?php if(isset($cardTwo)): ?> card-two <?php endif; ?>">
            <div class="pricing-card__top">
                <h4 class="pricing-card__title"><?php echo e(__(@$pricingPlan->name)); ?></h4>
                <p class="pricing-card__desc"><?php echo e(__(@$pricingPlan->description)); ?></p>
            </div>
            <h2 class="pricing-card__number">
                <span class="monthly_price">
                    <span
                        class="currency-type"><?php echo e(gs('cur_sym')); ?></span><?php echo e(showAmount(@$pricingPlan->monthly_price, currencyFormat: false)); ?>

                </span>
                <span class="yearly_price d-none">
                    <span
                        class="currency-type"><?php echo e(gs('cur_sym')); ?></span><?php echo e(showAmount(@$pricingPlan->yearly_price, currencyFormat: false)); ?>

                </span>
            </h2>
            <ul class="pricing-list">
                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-user-friends"></i>
                        </span>
                        <?php echo app('translator')->get('Whatsapp Account Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->account_limit)); ?></span>
                </li>
                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-user-tie"></i>
                        </span>
                        <?php echo app('translator')->get('Agent Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->agent_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-address-book"></i>
                        </span>
                        <?php echo app('translator')->get('Contact Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->contact_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-copy"></i>
                        </span>
                        <?php echo app('translator')->get('Template Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->template_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="lab la-rocketchat"></i>
                        </span>
                        <?php echo app('translator')->get('Automation Flow Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->flow_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-bullhorn"></i>
                        </span>
                        <?php echo app('translator')->get('Campaign Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->campaign_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-link"></i>
                        </span>
                        <?php echo app('translator')->get('ShortLink Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->short_link_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-paper-plane"></i>
                        </span>
                        <?php echo app('translator')->get('Floater Limit'); ?>
                    </span>
                    <span><?php echo e(printLimit($pricingPlan->floater_limit)); ?></span>
                </li>

                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-smile"></i>
                        </span>
                        <?php echo app('translator')->get('Welcome Message Available'); ?>
                    </span>
                    <?php if($pricingPlan->welcome_message): ?>
                        <span class="text--success"><?php echo app('translator')->get('Yes'); ?></span>
                    <?php else: ?>
                        <span class="text--danger"><?php echo app('translator')->get('No'); ?></span>
                    <?php endif; ?>
                </li>
                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-robot"></i>
                        </span>
                        <?php echo app('translator')->get('AI Assistance'); ?>
                    </span>
                    <?php if($pricingPlan->ai_assistance): ?>
                        <span class="text--success"><?php echo app('translator')->get('Yes'); ?></span>
                    <?php else: ?>
                        <span class="text--danger"><?php echo app('translator')->get('No'); ?></span>
                    <?php endif; ?>
                </li>
                <li class="pricing-list__item justify-content-between">
                    <span class="d-flex gap-2">
                        <span class="pricing-list__item-icon fs-16">
                            <i class="las la-link"></i>
                        </span>
                        <?php echo app('translator')->get('Interactive Message'); ?>
                    </span>
                    <?php if($pricingPlan->interactive_message): ?>
                        <span class="text--success"><?php echo app('translator')->get('Yes'); ?></span>
                    <?php else: ?>
                        <span class="text--danger"><?php echo app('translator')->get('No'); ?></span>
                    <?php endif; ?>
                </li>
            </ul>
            <div class="pricing-card__btn">
                <?php if(auth()->guard()->check()): ?>
                    <button class="btn btn--base w-100 purchaseBtn" data-plan='<?php echo json_encode($pricingPlan, 15, 512) ?>'>
                        <?php if(@$user->plan_id == $pricingPlan->id): ?>
                            <?php echo app('translator')->get('Renew Now'); ?>
                        <?php else: ?>
                            <?php echo app('translator')->get('Buy Now'); ?>
                        <?php endif; ?>
                    </button>
                <?php else: ?>
                    <a href="<?php echo e(route('user.login')); ?>" class="btn btn--base w-100"> <?php echo app('translator')->get('Buy Now'); ?> </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/pricing.blade.php ENDPATH**/ ?>