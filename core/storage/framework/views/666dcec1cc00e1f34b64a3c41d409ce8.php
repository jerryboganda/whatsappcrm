<div class="row responsive-row">
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => route('admin.users.all'),'variant' => 'primary','title' => 'Total Users','value' => $widget['all'],'icon' => 'las la-users','currency' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.users.all')),'variant' => 'primary','title' => 'Total Users','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['all']),'icon' => 'las la-users','currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => ''.e(route('admin.users.all')).'?date='.e(now()->toDateString()).'','variant' => 'danger','title' => 'Users Joined Today','value' => $widget['today'],'icon' => 'las la-clock','currency' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.users.all')).'?date='.e(now()->toDateString()).'','variant' => 'danger','title' => 'Users Joined Today','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['today']),'icon' => 'las la-clock','currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => ''.e(route('admin.users.all')).'?date='.e(now()->subDays(7)->toDateString()).'to'.e(now()->toDateString()).'','variant' => 'success','title' => 'Users Joined Last Week','value' => $widget['week'],'icon' => 'las la-calendar','currency' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.users.all')).'?date='.e(now()->subDays(7)->toDateString()).'to'.e(now()->toDateString()).'','variant' => 'success','title' => 'Users Joined Last Week','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['week']),'icon' => 'las la-calendar','currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
    <div class="col-xxl-3 col-sm-6">
        <?php if (isset($component)) { $__componentOriginal0eadc963ccd0212b9105fae0c75fc545 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.widget.four','data' => ['url' => ''.e(route('admin.users.all')).'?date='.e(now()->subDays(30)->toDateString()).'to'.e(now()->toDateString()).'','variant' => 'primary','title' => 'Users Joined Last Month','value' => $widget['month'],'icon' => 'las la-calendar-plus','currency' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.widget.four'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => ''.e(route('admin.users.all')).'?date='.e(now()->subDays(30)->toDateString()).'to'.e(now()->toDateString()).'','variant' => 'primary','title' => 'Users Joined Last Month','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($widget['month']),'icon' => 'las la-calendar-plus','currency' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $attributes = $__attributesOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__attributesOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545)): ?>
<?php $component = $__componentOriginal0eadc963ccd0212b9105fae0c75fc545; ?>
<?php unset($__componentOriginal0eadc963ccd0212b9105fae0c75fc545); ?>
<?php endif; ?>
    </div>
</div>
<?php /**PATH /var/www/html/core/resources/views/admin/users/widget.blade.php ENDPATH**/ ?>