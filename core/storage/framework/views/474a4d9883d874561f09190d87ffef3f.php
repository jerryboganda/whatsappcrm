<?php
    $summary = $analytics['summary'] ?? [];
    $engagement = $analytics['engagement'] ?? [];
    $failures = $analytics['failures']['breakdown'] ?? collect();
    $timeline = $analytics['timeline']['daily'] ?? [];
    $metaEstimated = $analytics['meta_estimated'] ?? [];
?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="report-wrapper">
            <div class="d-flex align-items-center justify-content-end flex-wrap gap-2">
                <form class="select-group filter-form">
                    <select class="form-select form--control select2" data-minimum-results-for-search="-1" name="export">
                        <option selected value=""><?php echo app('translator')->get('Export Report'); ?></option>
                        <option value="minimal"><?php echo app('translator')->get('Minimal'); ?></option>
                        <option value="maximal"><?php echo app('translator')->get('Maximal'); ?></option>
                    </select>
                </form>

                <a href="<?php echo e(request()->fullUrlWithQuery(['refresh_meta' => 1])); ?>" class="btn btn--dark btn--sm">
                    <i class="las la-sync-alt me-1"></i><?php echo app('translator')->get('Refresh Meta Snapshot'); ?>
                </a>

                <div class="dropdown">
                    <button class="btn btn--base dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php echo app('translator')->get('Retargeting Actions'); ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'failed'])); ?>">
                                <i class="las la-exclamation-circle me-2"></i> <?php echo app('translator')->get('Create List from Failed'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'pending'])); ?>">
                                <i class="las la-clock me-2"></i> <?php echo app('translator')->get('Create List from Pending'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'delivered'])); ?>">
                                <i class="las la-check-circle me-2"></i> <?php echo app('translator')->get('Create List from Delivered'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'read'])); ?>">
                                <i class="las la-eye me-2"></i> <?php echo app('translator')->get('Create List from Opened'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'not_read'])); ?>">
                                <i class="las la-eye-slash me-2"></i> <?php echo app('translator')->get('Create List from Not Opened'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'replied'])); ?>">
                                <i class="las la-reply me-2"></i> <?php echo app('translator')->get('Create List from Replied'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'not_replied'])); ?>">
                                <i class="las la-comment-slash me-2"></i> <?php echo app('translator')->get('Create List from Not Replied'); ?>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('user.campaign.retarget', [$campaign->id, 'clicked'])); ?>">
                                <i class="las la-mouse-pointer me-2"></i> <?php echo app('translator')->get('Create List from Clickers'); ?>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <?php if(($analytics['legacy_mode'] ?? false) === true): ?>
                <div class="alert alert-warning mt-3 mb-0">
                    <?php echo app('translator')->get('This campaign was sent before analytics v2 linkage. Deep metrics for old records may be partial. New campaigns are fully accurate.'); ?>
                </div>
            <?php endif; ?>

            <div class="report-top mt-4">
                <div class="row gy-4">
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Targeted'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text"><?php echo e($summary['targeted'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('API Accepted'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--base"><?php echo e($summary['api_accepted'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Delivered'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--success"><?php echo e($summary['delivered'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title">
                                <?php echo app('translator')->get('Opened'); ?>
                                <span class="text--small text--muted d-block"><?php echo app('translator')->get('Opened = Read receipt from WhatsApp'); ?></span>
                            </h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--primary"><?php echo e($summary['read'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Replied'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--primary"><?php echo e($engagement['replied'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Clicked'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--primary"><?php echo e($engagement['clicked'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Failed'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text text--danger"><?php echo e($summary['failed'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-sm-6">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Pending Delivery'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text"><?php echo e($summary['pending_delivery'] ?? 0); ?></span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history"><h5 class="title"><?php echo app('translator')->get('Delivery Funnel'); ?></h5></div>
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Metric'); ?></th>
                            <th><?php echo app('translator')->get('Count'); ?></th>
                            <th><?php echo app('translator')->get('Rate'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo app('translator')->get('Delivery Rate'); ?></td>
                            <td><?php echo e($summary['delivered'] ?? 0); ?>/<?php echo e($summary['targeted'] ?? 0); ?></td>
                            <td><?php echo e(getAmount($engagement['delivery_rate'] ?? 0)); ?>%</td>
                        </tr>
                        <tr>
                            <td><?php echo app('translator')->get('Opened Rate'); ?></td>
                            <td><?php echo e($summary['read'] ?? 0); ?>/<?php echo e($summary['delivered'] ?? 0); ?></td>
                            <td><?php echo e(getAmount($engagement['opened_rate'] ?? 0)); ?>%</td>
                        </tr>
                        <tr>
                            <td><?php echo app('translator')->get('Reply Rate'); ?></td>
                            <td><?php echo e($engagement['replied'] ?? 0); ?>/<?php echo e($summary['delivered'] ?? 0); ?></td>
                            <td><?php echo e(getAmount($engagement['reply_rate'] ?? 0)); ?>%</td>
                        </tr>
                        <tr>
                            <td><?php echo app('translator')->get('CTR'); ?></td>
                            <td><?php echo e($engagement['clicked'] ?? 0); ?>/<?php echo e($summary['delivered'] ?? 0); ?></td>
                            <td><?php echo e(getAmount($engagement['ctr'] ?? 0)); ?>%</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history"><h5 class="title"><?php echo app('translator')->get('Reliability Metrics'); ?></h5></div>
                <div class="row gy-3">
                    <div class="col-md-4">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Avg First Response'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text"><?php echo e($engagement['avg_first_response_seconds'] ?? 0); ?>s</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Avg Send to Deliver'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text"><?php echo e($engagement['avg_send_to_deliver_seconds'] ?? 0); ?>s</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="report-item">
                            <h5 class="report-item__title"><?php echo app('translator')->get('Avg Deliver to Open'); ?></h5>
                            <div class="report-item__bottom">
                                <div class="text-wrapper"><span class="text"><?php echo e($engagement['avg_deliver_to_read_seconds'] ?? 0); ?>s</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history"><h5 class="title"><?php echo app('translator')->get('Failure Diagnostics'); ?></h5></div>
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Error Code'); ?></th>
                            <th><?php echo app('translator')->get('Error Title'); ?></th>
                            <th><?php echo app('translator')->get('Count'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $failures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $failure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($failure->error_code); ?></td>
                                <td><?php echo e($failure->error_title); ?></td>
                                <td><?php echo e($failure->total); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center"><?php echo app('translator')->get('No failure records found'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history"><h5 class="title"><?php echo app('translator')->get('Timeline'); ?></h5></div>
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Date'); ?></th>
                            <th><?php echo app('translator')->get('API Accepted'); ?></th>
                            <th><?php echo app('translator')->get('Sent'); ?></th>
                            <th><?php echo app('translator')->get('Delivered'); ?></th>
                            <th><?php echo app('translator')->get('Opened'); ?></th>
                            <th><?php echo app('translator')->get('Failed'); ?></th>
                            <th><?php echo app('translator')->get('Replied'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $timeline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $timelineRow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($timelineRow['event_date'] ?? '-'); ?></td>
                                <td><?php echo e($timelineRow['api_accepted'] ?? 0); ?></td>
                                <td><?php echo e($timelineRow['sent'] ?? 0); ?></td>
                                <td><?php echo e($timelineRow['delivered'] ?? 0); ?></td>
                                <td><?php echo e($timelineRow['read'] ?? 0); ?></td>
                                <td><?php echo e($timelineRow['failed'] ?? 0); ?></td>
                                <td><?php echo e($timelineRow['replied'] ?? 0); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="text-center"><?php echo app('translator')->get('No timeline events recorded yet'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history"><h5 class="title"><?php echo app('translator')->get('Estimated Attribution (Meta Aggregate)'); ?></h5></div>
                <div class="row gy-3">
                    <?php $__empty_1 = true; $__currentLoopData = $metaEstimated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $snapshot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="col-md-4">
                            <div class="report-item">
                                <h5 class="report-item__title text-capitalize">
                                    <?php echo e(str_replace('_', ' ', $snapshot['source_type'] ?? '')); ?>

                                </h5>
                                <div class="report-item__bottom">
                                    <div class="text-wrapper">
                                        <span class="text">
                                            <?php echo app('translator')->get('Confidence'); ?>:
                                            <span class="badge badge--info text-capitalize"><?php echo e($snapshot['attribution_confidence'] ?? 'low'); ?></span>
                                        </span>
                                    </div>
                                    <small class="text--muted">
                                        <?php echo app('translator')->get('Fetched at'); ?>: <?php echo e(!empty($snapshot['fetched_at']) ? showDateTime($snapshot['fetched_at']) : '-'); ?>

                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-12">
                            <div class="alert alert-info mb-0">
                                <?php echo app('translator')->get('Meta aggregate analytics are not fetched yet. Click "Refresh Meta Snapshot" to pull latest estimated aggregates.'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="campaign-wrapper mt-4">
                <div class="performance-history">
                    <h5 class="title"><?php echo app('translator')->get('Campaign History'); ?></h5>
                </div>
                <table class="table table--responsive--xl">
                    <thead>
                        <tr>
                            <th><?php echo app('translator')->get('Contact'); ?></th>
                            <th><?php echo app('translator')->get('Status'); ?></th>
                            <th><?php echo app('translator')->get('Sent'); ?></th>
                            <th><?php echo app('translator')->get('Delivered'); ?></th>
                            <th><?php echo app('translator')->get('Opened'); ?></th>
                            <th><?php echo app('translator')->get('Replied'); ?></th>
                            <th><?php echo app('translator')->get('Last Modified'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = @$campaignContacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campaignContact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php echo e(@$campaignContact->contact->mobileNumber); ?>

                                    <?php if($campaignContact->meta_error_title): ?>
                                        <div class="text--danger fs-12"><?php echo e($campaignContact->meta_error_title); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo $campaignContact->statusBadge; ?></td>
                                <td><?php echo e($campaignContact->sent_at ? showDateTime($campaignContact->sent_at) : '-'); ?></td>
                                <td><?php echo e($campaignContact->delivered_at ? showDateTime($campaignContact->delivered_at) : '-'); ?></td>
                                <td><?php echo e($campaignContact->read_at ? showDateTime($campaignContact->read_at) : '-'); ?></td>
                                <td><?php echo e($campaignContact->responded_at ? showDateTime($campaignContact->responded_at) : '-'); ?></td>
                                <td><?php echo e(showDateTime($campaignContact->updated_at)); ?><br><?php echo e(diffForHumans($campaignContact->updated_at)); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php echo e(paginateLinks($campaignContacts)); ?>

            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('.filter-form').find('select').on('change', function() {
                $('.filter-form').submit();
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/campaign/report.blade.php ENDPATH**/ ?>