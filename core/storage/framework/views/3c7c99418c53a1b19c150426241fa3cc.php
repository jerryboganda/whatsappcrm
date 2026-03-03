<div class="col-xl-8">
    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.index','data' => ['class' => 'tc-card']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'tc-card']); ?>
        <?php if (isset($component)) { $__componentOriginal79cca64cbea31c60ec0b996a52c8e9df = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal79cca64cbea31c60ec0b996a52c8e9df = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card.header','data' => ['class' => 'flex-between gap-2 py-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex-between gap-2 py-3']); ?>
            <h5 class="card-title mb-0 fs-16"><?php echo app('translator')->get('Transactions Report'); ?></h5>
            <div class="d-flex gap-2 flex-wrap flex-md-nowrap">
                <select class="form-select form-control form-select-sm">
                    <option value="daily" selected><?php echo app('translator')->get('Daily'); ?></option>
                    <option value="monthly"><?php echo app('translator')->get('Monthly'); ?></option>
                    <option value="yearly"><?php echo app('translator')->get('Yearly'); ?></option>
                    <option value="date_range"><?php echo app('translator')->get('Date Range'); ?></option>
                </select>
                <div class="date-picker-wrapper d-none w-100">
                    <input type="text" class="form-control form-control-sm date-picker" name="date"
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
            <div id="transactionChartArea"></div>
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

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {

            let tcChart = barChart(
                document.querySelector("#transactionChartArea"),
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
            const transactionChart = (startDate, endDate) => {
                const url = <?php echo json_encode(route('admin.chart.transaction'), 15, 512) ?>;
                const timePeriod = $(".tc-card").find('select').val();
                if (timePeriod == 'date_range') {
                    $(".tc-card").find('.date-picker-wrapper').removeClass('d-none')
                } else {
                    $(".tc-card").find('.date-picker-wrapper').addClass('d-none')
                }
                const date = $(".tc-card").find('input[name=date]').val();
                const data = {
                    time_period: timePeriod,
                    date: date
                }

                $.get(url, data,
                    function(data, status) {
                        if (data.success) {
                            const plusAmount = Object.values(data.data).map(item => item.plus_amount);
                            const minusAmount = Object.values(data.data).map(item => item.minus_amount);
                            const updatedData = [{
                                    name: "Plus Transactions",
                                    data: plusAmount,
                                },
                                {
                                    name: "Minus Transactions",
                                    data: minusAmount,
                                }
                            ]

                            tcChart.updateSeries(updatedData);
                            tcChart.updateOptions({
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
            transactionChart();

            $(".tc-card").on('change', 'select', function(e) {
                transactionChart();
            });
            $(".tc-card").on('change', '.date-picker', function(e) {
                transactionChart();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/components/admin/other/dashboard_trx_chart.blade.php ENDPATH**/ ?>