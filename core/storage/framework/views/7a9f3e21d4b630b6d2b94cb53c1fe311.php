<?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => ['class' => 'tc-card h-100']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'tc-card h-100']); ?>
    <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'py-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'py-4']); ?>
        <h5 class="card-title fs-16"><?php echo app('translator')->get('User Login by Browser'); ?></h5>
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
        <div id="userBrowserChart"></div>
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

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            (function() {
                const labels = <?php echo json_encode($userLogin->pluck('browser')->toArray(), 15, 512) ?>;
                const data   = <?php echo json_encode($userLogin->pluck('total')->toArray(), 15, 512) ?>;
                const total  = data.reduce((a, b) => a + b, 0);

                const legendLabels = labels.map((label, index) => {
                    const percent = ((data[index] / total) * 100).toFixed(2);
                    return `<div class=" d-flex  flex-column gap-1  align-items-start mb-3 me-1"><span>${percent}%</span> <span>${label}</span> </div>`;
                });
                const options = {
                    series: data,
                    chart: {
                        type: 'donut',
                        height: 420,
                        width: '100%'
                    },
                    labels: labels,
                    dataLabels: {
                        enabled: false,

                    },
                    legend: {
                        position: 'bottom',
                        markers: {
                            show: false // Hide the default markers
                        },
                        formatter: function(seriesName, opts) {
                            return legendLabels[opts.seriesIndex];
                        }
                    }
                };
                new ApexCharts(document.getElementById('userBrowserChart'), options).render();
            })()
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/components/admin/other/dashboard_login_chart.blade.php ENDPATH**/ ?>