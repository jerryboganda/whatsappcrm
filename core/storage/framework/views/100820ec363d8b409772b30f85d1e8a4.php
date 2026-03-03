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
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal1f098625d1559f0930c45d4dc9464fd6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.two','data' => ['url' => route('admin.users.all'),'variant' => 'primary','title' => 'Total Users','value' => $widget['total_users'],'icon' => 'las la-users']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.two'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.all')),'variant' => 'primary','title' => 'Total Users','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['total_users']),'icon' => 'las la-users']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $attributes = $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $component = $__componentOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal1f098625d1559f0930c45d4dc9464fd6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.two','data' => ['url' => route('admin.users.active'),'variant' => 'success','title' => 'Active User','value' => $widget['active_users'],'icon' => 'las la-user-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.two'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.active')),'variant' => 'success','title' => 'Active User','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['active_users']),'icon' => 'las la-user-check']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $attributes = $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $component = $__componentOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal1f098625d1559f0930c45d4dc9464fd6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.two','data' => ['url' => route('admin.users.email.unverified'),'variant' => 'warning','title' => 'Email Unverified Users','value' => $widget['email_unverified_users'],'icon' => 'lar la-envelope']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.two'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.email.unverified')),'variant' => 'warning','title' => 'Email Unverified Users','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['email_unverified_users']),'icon' => 'lar la-envelope']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $attributes = $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $component = $__componentOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal1f098625d1559f0930c45d4dc9464fd6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.two','data' => ['url' => route('admin.users.mobile.unverified'),'variant' => 'danger','title' => 'Mobile Unverified Users','value' => $widget['mobile_unverified_users'],'icon' => 'las la-comment-slash']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.two'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.mobile.unverified')),'variant' => 'danger','title' => 'Mobile Unverified Users','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['mobile_unverified_users']),'icon' => 'las la-comment-slash']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $attributes = $__attributesOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__attributesOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6)): ?>
<?php $component = $__componentOriginal1f098625d1559f0930c45d4dc9464fd6; ?>
<?php unset($__componentOriginal1f098625d1559f0930c45d4dc9464fd6); ?>
<?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/components/admin/ui/widget/group/dashboard/users.blade.php ENDPATH**/ ?>