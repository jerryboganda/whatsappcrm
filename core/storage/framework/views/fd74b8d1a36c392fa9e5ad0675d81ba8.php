<?php
    @$pricingContent = @getContent('pricing.content', true)->data_values;
    @$pricingPlans = \App\Models\PricingPlan::active()->orderBy('monthly_price', 'asc')->get();
    @$user = auth()->user();
?>

<?php $__env->startSection('content'); ?>
    <section class="pricing-section banner-bg py-100">
        <div class="container">
            <div class="section-heading">
                <h1 class="section-heading__title wow animationfadeUp" data-wow-delay="0.2s"><?php echo e(__(@$pricingContent->heading)); ?></h1>
                <p class="section-heading__desc wow animationfadeUp" data-wow-delay="0.4s"><?php echo e(__(@$pricingContent->subheading)); ?></p>
            </div>
            <div class="pricing-card-top wow animationfadeUp" data-wow-delay="0.6s">
                <p class="pricing-card-top__text"><?php echo app('translator')->get('Monthly'); ?></p>
                <div class="form--switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="recurring_type" />
                </div>
                <p class="pricing-card-top__text">
                    <?php echo app('translator')->get('Yearly'); ?>
                </p>
            </div>
            <div class="row gy-4 justify-content-center align-items-center wow animationfadeUp" data-wow-delay="0.8s">
                <?php echo $__env->make('Template::partials.pricing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
        </div>
    </section>
    <?php if (isset($component)) { $__componentOriginal682bb9643994427a41dd0b1527fe0889 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal682bb9643994427a41dd0b1527fe0889 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.purchase_modal','data' => ['isDark' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('purchase_modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['is_dark' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal682bb9643994427a41dd0b1527fe0889)): ?>
<?php $attributes = $__attributesOriginal682bb9643994427a41dd0b1527fe0889; ?>
<?php unset($__attributesOriginal682bb9643994427a41dd0b1527fe0889); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal682bb9643994427a41dd0b1527fe0889)): ?>
<?php $component = $__componentOriginal682bb9643994427a41dd0b1527fe0889; ?>
<?php unset($__componentOriginal682bb9643994427a41dd0b1527fe0889); ?>
<?php endif; ?>
    <?php if(@$sections->secs != null): ?>
        <?php $__currentLoopData = json_decode($sections->secs); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make($activeTemplate . 'sections.' . $sec, array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/pricing.blade.php ENDPATH**/ ?>