<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['widget']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['widget']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>
<div class="row responsive-row">
    <div class="col-xxl-6">
        <div class="card shadow-none h-100">
            <div class="card-header d-flex justify-content-between align-items-center gap-3 flex-wrap border-0">
                <h5 class="card-title"><?php echo app('translator')->get('Financial Overview'); ?></h5>
                <ul class="nav nav-pills payment-history" id="pills-tab" role="tablist">
                    <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'view deposit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'view deposit']); ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#pills-deposit"
                                type="button" role="tab">
                                <?php echo app('translator')->get('Deposit'); ?>
                            </button>
                        </li>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'view withdraw']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'view withdraw']); ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" data-bs-toggle="pill" data-bs-target="#pills-withdraw"
                                type="button" role="tab" aria-controls="pills-withdraw" aria-selected="false">
                                <?php echo app('translator')->get('Withdrawals'); ?>
                            </button>
                        </li>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'view deposit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'view deposit']); ?>
                        <div class="tab-pane fade show active" id="pills-deposit" role="tabpanel">
                            <div class="widget-card-wrapper custom-widget-wrapper">
                                <div class="row g-0">
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--success">
                                            <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <span class="widget-icon">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </span>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Total Deposits'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_deposit_amount'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--warning">
                                            <a href="<?php echo e(route('admin.deposit.pending')); ?>" class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-spinner"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Pending Deposits'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_deposit_pending'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--danger">
                                            <a href="<?php echo e(route('admin.deposit.rejected')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-ban"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Rejected Deposits'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_deposit_rejected'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--primary">
                                            <a href="<?php echo e(route('admin.deposit.list')); ?>" class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon ">
                                                    <i class="fas fa-percentage"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Deposited Charge'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_deposit_charge'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--warning">
                                            <a href="<?php echo e(route('admin.deposit.pending')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-spinner"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Pending Deposit Count'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e($widget['total_deposit_pending_count']); ?>

                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--danger">
                                            <a href="<?php echo e(route('admin.deposit.rejected')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-ban"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Rejected Deposit Count'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e($widget['total_deposit_rejected_count']); ?>

                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal255fb1ebb863741a9024cbf0271e1957 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal255fb1ebb863741a9024cbf0271e1957 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.permission_check','data' => ['permission' => 'view withdraw']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'view withdraw']); ?>
                        <div class="tab-pane fade" id="pills-withdraw" role="tabpanel">
                            <div class="widget-card-wrapper custom-widget-wrapper">
                                <div class="row g-0">
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--success">
                                            <a href="<?php echo e(route('admin.withdraw.data.all')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-hand-holding-usd"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Total Withdrawal'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_withdraw_amount'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="widget-card widget--warning">
                                            <a href="<?php echo e(route('admin.withdraw.data.pending')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-spinner"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Pending Withdrawal'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_withdraw_pending'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="widget-card widget--danger">
                                            <a href="<?php echo e(route('admin.withdraw.data.rejected')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-ban"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Rejected Withdrawal'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_withdraw_rejected'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="widget-card widget--primary">
                                            <a href="<?php echo e(route('admin.withdraw.data.all')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-percentage"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Withdrawal Charge'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e(gs('cur_sym')); ?><?php echo e(showAmount($widget['total_withdraw_charge'], currencyFormat: false)); ?>

                                                        <span class="currency"><?php echo e(__(gs('cur_text'))); ?></span>
                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>'
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="widget-card widget--warning">
                                            <a href="<?php echo e(route('admin.withdraw.data.pending')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-spinner"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Pending Withdrawal Count'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e($widget['total_withdraw_pending_count']); ?>

                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">

                                        <div class="widget-card widget--danger">
                                            <a href="<?php echo e(route('admin.withdraw.data.rejected')); ?>"
                                                class="widget-card-link"></a>
                                            <div class="widget-card-left">
                                                <div class="widget-icon">
                                                    <i class="fas fa-ban"></i>
                                                </div>
                                                <div class="widget-card-content">
                                                    <p class="widget-title fs-14"><?php echo app('translator')->get('Rejected Withdrawal Count'); ?></p>
                                                    <h6 class="widget-amount">
                                                        <?php echo e($widget['total_withdraw_rejected_count']); ?>

                                                    </h6>
                                                </div>
                                            </div>
                                            <span class="widget-card-arrow">
                                                <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $attributes = $__attributesOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__attributesOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal255fb1ebb863741a9024cbf0271e1957)): ?>
<?php $component = $__componentOriginal255fb1ebb863741a9024cbf0271e1957; ?>
<?php unset($__componentOriginal255fb1ebb863741a9024cbf0271e1957); ?>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-6">
        <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => ['class' => 'shadow-none h-100 dw-card']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'shadow-none h-100 dw-card']); ?>
            <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'flex-between py-3 gap-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex-between py-3 gap-2']); ?>
                <h5 class="card-title mb-0 fs-16"><?php echo app('translator')->get('Deposit & Withdraw Report'); ?></h5>
                <div class="d-flex gap-2 flex-wrap flex-md-nowrap">
                    <select class="form-select form-select-sm  form-control">
                        <option value="daily" selected><?php echo app('translator')->get('Daily'); ?></option>
                        <option value="monthly"><?php echo app('translator')->get('Monthly'); ?></option>
                        <option value="yearly"><?php echo app('translator')->get('Yearly'); ?></option>
                        <option value="date_range"><?php echo app('translator')->get('Date Range'); ?></option>
                    </select>
                    <div class="date-picker-wrapper d-none w-100">
                        <input type="text" class="form-control-sm date-picker form-control" name="date"
                            placeholder="<?php echo app('translator')->get('Select Date'); ?>">
                    </div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $attributes = $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df)): ?>
<?php $component = $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df; ?>
<?php unset($__componentOriginal79cca64cbea31c60ec0b996a52c8e9df); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal82a520cb144a92d0fb68c226771dfec2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal82a520cb144a92d0fb68c226771dfec2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
                <div id="dwChartArea"> </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $attributes = $__attributesOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__attributesOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal82a520cb144a92d0fb68c226771dfec2)): ?>
<?php $component = $__componentOriginal82a520cb144a92d0fb68c226771dfec2; ?>
<?php unset($__componentOriginal82a520cb144a92d0fb68c226771dfec2); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
    </div>
</div>


<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {

            let dwChart = barChart(
                document.querySelector("#dwChartArea"),
                <?php echo json_encode(__(gs('cur_text')), 15, 512) ?>,
                [{
                        name: 'Deposited',
                        data: []
                    },
                    {
                        name: 'Withdrawn',
                        data: []
                    }
                ],
                [],
            );
            const depositWithdrawChart = (startDate, endDate) => {
                const url = <?php echo json_encode(route('admin.chart.deposit.withdraw'), 15, 512) ?>;
                const timePeriod = $(".dw-card").find('select').val();

                if (timePeriod == 'date_range') {
                    $(".dw-card").find('.date-picker-wrapper').removeClass('d-none')
                } else {
                    $(".dw-card").find('.date-picker-wrapper').addClass('d-none')
                }
                const date = $(".dw-card").find('input[name=date]').val();
                const data = {
                    time_period: timePeriod,
                    date: date
                }

                $.get(url, data,
                    function(data, status) {
                        if (data.success) {
                            const updatedData = ['Deposited', 'Withdrawn'].map(name => ({
                                name,
                                data: Object.values(data.data).map(item => item[name.toLowerCase() +
                                    '_amount'])
                            }));

                            dwChart.updateSeries(updatedData);
                            dwChart.updateOptions({
                                xaxis: {
                                    categories: Object.keys(data.data),
                                }
                            });
                        } else {
                            notify('error', data.message);
                        }
                    }
                );
            }
            depositWithdrawChart();

            $(".dw-card").on('change', 'select', function(e) {
                depositWithdrawChart();
            });

            $(".dw-card").on('change', '.date-picker', function(e) {
                depositWithdrawChart();
            });

            let $tabLinks = $('#pills-tab .nav-link:visible');

            if ($tabLinks.length === 1) {
                $tabLinks.addClass('active');
                $tabLinks.attr('aria-selected', 'true');
            }

            let $tabs = $('#pills-tab .nav-link:visible');

            if ($tabs.length == 1) {
                $tabs.addClass('active').attr('aria-selected', 'true');
                let target = $tabs.data('bs-target');
                $(target).addClass('show active');
            }


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/widget/group/dashboard/financial_overview.blade.php ENDPATH**/ ?>