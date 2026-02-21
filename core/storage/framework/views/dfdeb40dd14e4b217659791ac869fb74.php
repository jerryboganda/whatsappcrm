
<?php $__env->startSection('content'); ?>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Organize and manage your contact with effortless ease.'); ?></p>
            </div>
            <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'add contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'add contact']); ?>
                <div class="container-top__right">
                    <div class="btn--group">
                        <a href="<?php echo e(route('user.contact.create')); ?>" class="btn btn--base btn-shadow">
                            <i class="las la-plus"></i> <?php echo app('translator')->get('Add New'); ?>
                        </a>
                        <button type="button" class="btn btn--info btn-shadow importBtn">
                            <i class="las la-upload"></i>
                            <?php echo app('translator')->get('Import Contacts'); ?>
                        </button>
                        <button type="button" class="btn btn--primary btn-shadow importGroupBtn">
                            <i class="las la-paste"></i>
                            <?php echo app('translator')->get('Import from WhatsApp Group'); ?>
                        </button>
                    </div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
        </div>
        <div class="dashboard-container__body">
            <div class="body-top">
                <div class="body-top__left">
                    <form class="search-form">
                        <input type="search" class="form--control" name="search" placeholder="<?php echo app('translator')->get('Search here...'); ?>"
                            value="<?php echo e(request()->search); ?>" autocomplete="off">
                        <span class="search-form__icon"> <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </form>
                </div>
                <div class="body-top__right">
                    <form class="select-group filter-form">
                        <select class="form-select form--control select2" name="tag_id">
                            <option selected value=""><?php echo app('translator')->get('Filter Tag'); ?></option>
                            <?php $__currentLoopData = $contactTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tag->id); ?>" <?php if(request()->tag_id == $tag->id): echo 'selected'; endif; ?>>
                                    <?php echo e(__(@$tag->name)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select class="form-select form--control select2" name="paginate">
                            <option value="20" <?php if(request()->paginate == 20): echo 'selected'; endif; ?>><?php echo app('translator')->get('20 Per Page'); ?></option>
                            <option value="50" <?php if(request()->paginate == 50): echo 'selected'; endif; ?>><?php echo app('translator')->get('50 Per Page'); ?></option>
                            <option value="100" <?php if(request()->paginate == 100): echo 'selected'; endif; ?>><?php echo app('translator')->get('100 Per Page'); ?></option>
                            <option value="1000" <?php if(request()->paginate == 1000): echo 'selected'; endif; ?>><?php echo app('translator')->get('All Contacts'); ?></option>
                        </select>
                    </form>
                    <button type="button" class="btn btn--danger d-none" id="bulkDeleteBtn">
                        <i class="las la-trash"></i> <?php echo app('translator')->get('Delete Selected'); ?>
                    </button>
                </div>
            </div>
            <div class="dashboard-table">
                <table class="table table--responsive--md">
                    <thead>
                        <tr>
                            <th>
                                <div class="d-flex align-items-center">
                                    <input type="checkbox" class="form-check-input checkAll">
                                </div>
                            </th>
                            <th><?php echo app('translator')->get('Name'); ?></th>
                            <th><?php echo app('translator')->get('Mobile'); ?></th>
                            <th><?php echo app('translator')->get('Tags'); ?></th>
                            <th><?php echo app('translator')->get('Action'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input contactCheck" value="<?php echo e($contact->id); ?>">
                                    </div>
                                </td>
                                <td>
                                    <div
                                        class="d-flex align-items-center gap-2 flex-wrap justify-content-end justify-content-md-start">
                                        <?php echo $__env->make('Template::user.contact.thumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                        <?php echo e(__(@$contact->fullName)); ?>

                                    </div>
                                </td>
                                <td>+<?php echo e(@$contact->mobileNumber); ?></td>
                                <td>
                                    <ul class="tag-list">
                                        <?php $__empty_2 = true; $__currentLoopData = $contact->tags->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <li>
                                                <a href="<?php echo e(appendQuery('tag_id', $tag->id)); ?>"
                                                    class="tag-list__link"><?php echo e(__(@$tag->name)); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <li>
                                                <span class="text-muted"><?php echo app('translator')->get('N/A'); ?></span>
                                            </li>
                                        <?php endif; ?>
                                        <?php if($contact->tags->count() > 3): ?>
                                            <li>
                                                <button type="button" data-tags="<?php echo e($contact->tags); ?>"
                                                    class="more_tags_btn text--base"><?php echo app('translator')->get('See More...'); ?>
                                                </button>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'edit contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'edit contact']); ?>
                                            <a href="<?php echo e(route('user.contact.edit', $contact->id)); ?>"
                                                class="action-btn text--base" data-bs-toggle="tooltip"
                                                data-bs-title="<?php echo app('translator')->get('Edit'); ?>">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'send message']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'send message']); ?>
                                            <a href="<?php echo e(route('user.inbox.list')); ?>?contact_id=<?php echo e($contact->id); ?>"
                                                class="action-btn text--info" data-bs-toggle="tooltip"
                                                data-bs-title="<?php echo app('translator')->get('Send Message'); ?>"><i class="fa-solid fa-paper-plane"></i>
                                            </a>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                                        <?php if (isset($component)) { $__componentOriginala51f62547316d5db73491e0449589f36 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala51f62547316d5db73491e0449589f36 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.permission_check','data' => ['permission' => 'delete contact']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('permission_check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['permission' => 'delete contact']); ?>
                                            <button type="button" class="action-btn confirmationBtn text--danger"
                                                data-bs-toggle="tooltip" data-question="<?php echo app('translator')->get('Are you sure to remove this contact?'); ?>"
                                                data-action="<?php echo e(route('user.contact.delete', @$contact->id)); ?>"
                                                data-bs-title="<?php echo app('translator')->get('Delete'); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $attributes = $__attributesOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__attributesOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala51f62547316d5db73491e0449589f36)): ?>
<?php $component = $__componentOriginala51f62547316d5db73491e0449589f36; ?>
<?php unset($__componentOriginala51f62547316d5db73491e0449589f36); ?>
<?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <?php echo $__env->make('Template::partials.empty_message', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php echo e(paginateLinks(@$contacts)); ?>

        </div>
        
        <form action="<?php echo e(route('user.contact.delete.all')); ?>" method="POST" id="finalBulkDeleteForm">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="ids" id="finalBulkDeleteIds">
        </form>
    </div>

    <div class="modal custom--modal fade importModal progressModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div id="import-progress" class="progress  h-1 w-full d-none">
                    <div class="progress-bar bg-success progress-bar-striped progress-bar-animated h-full w-0"></div>
                </div>
                <div class="modal-header">
                    <div class="modal-header__left">
                        <h5 class="title"><?php echo app('translator')->get('Import Contacts'); ?></h5>
                        <p class="text"><?php echo app('translator')->get('Select your file to import contacts'); ?></p>
                    </div>
                    <div class="modal-header__right">
                        <div class="btn--group">
                            <button class="btn--white btn" data-bs-dismiss="modal"
                                aria-label="Close"><?php echo app('translator')->get('Cancel Import'); ?></button>
                            <button class="btn--base btn btn-shadow" form="import-form"><?php echo app('translator')->get('Import Contacts'); ?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="csv-form-wrapper">
                        <div class="csv-form-wrapper__left">
                            <div class="thumb-form-wrapper">
                                <form action="<?php echo e(route('user.contact.import')); ?>" method="POST" id="import-form"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="form-group">
                                        <label class="label-two">
                                            <?php echo app('translator')->get('Contact List'); ?>
                                            <span data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="<?php echo app('translator')->get('By specifying a contact list, all imported contacts will be added to the selected list. If left global, the contacts will not be added to any contact list.'); ?>">
                                                <i class="las la-question-circle"></i>
                                            </span>
                                        </label>
                                        <select class="form--control select2" name="contact_list_id"
                                            data-minimum-results-for-search="-1">
                                            <option value="0"> <?php echo app('translator')->get('Global'); ?> </option>
                                            <?php $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list->id); ?>"> <?php echo e(__(@$list->name)); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="thumb-form">
                                        <input type="file" class="form--control drag-drop" name="file"
                                            accept=".csv,xlsx">
                                        <label for="file">
                                            <span class="thumb-form__icon">
                                                <i class="las la-cloud-upload-alt"></i>
                                            </span>
                                            <p class="thumb-form__text file-name text-center">
                                                <span class="">
                                                    <span
                                                        class="cursor-pointer text-decoration-underline text--info"><?php echo app('translator')->get('Click to Upload'); ?></span>
                                                    <?php echo app('translator')->get('or drag and drop here'); ?>
                                                </span>
                                                <span class="text-muted fs-14">
                                                    <?php echo app('translator')->get('Supported Files:'); ?>
                                                    <b><?php echo app('translator')->get('.csv'); ?>, <?php echo app('translator')->get('.xlsx'); ?></b>
                                                    <?php echo app('translator')->get('& Maximum file size'); ?> <b>2</b><?php echo app('translator')->get('MB'); ?>
                                                </span>
                                            </p>
                                        </label>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="csv-form-wrapper__right">
                            <div class="instruction-wrapper">
                                <p class="title"><?php echo app('translator')->get('Steps to Import Your Contacts'); ?></p>
                                <ol class="instruction-list">
                                    <li class="instruction-list__item"><?php echo app('translator')->get('Download the sample template to ensure the correct format.'); ?></li>
                                    <li class="instruction-list__item"><?php echo app('translator')->get('Fill in the required customer details: firstname, lastname, mobile_code, and mobile number.'); ?></li>
                                    <li class="instruction-list__item"><?php echo app('translator')->get('Save the completed file in either .csv or .xlsx format.'); ?></li>
                                    <li class="instruction-list__item"><?php echo app('translator')->get('Upload the file by selecting it manually or dragging and dropping it into the upload area.'); ?></li>
                                </ol>
                                <div class="download-btn">
                                    <a href="<?php echo e(route('user.contact.csv.download')); ?>" class="btn--white btn btn--sm">
                                        <i class="la la-download"></i> <?php echo app('translator')->get('Download Sample File'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Group Import Modal -->
    <div class="modal custom--modal fade importGroupModal">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-header__left">
                        <h5 class="title"><?php echo app('translator')->get('Import from WhatsApp Group'); ?></h5>
                        <p class="text"><?php echo app('translator')->get('Use extension import for one-click extraction, or legacy paste as fallback.'); ?></p>
                    </div>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="nav nav-tabs" id="groupImportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="extension-import-tab" data-bs-toggle="tab"
                                data-bs-target="#extension-import-pane" type="button" role="tab">
                                <?php echo app('translator')->get('Extension Import'); ?>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="legacy-paste-tab" data-bs-toggle="tab"
                                data-bs-target="#legacy-paste-pane" type="button" role="tab">
                                <?php echo app('translator')->get('Legacy Paste'); ?>
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="extension-import-pane" role="tabpanel">
                            <div class="alert alert-warning py-2 mb-3">
                                <strong><?php echo app('translator')->get('Compliance Notice:'); ?></strong>
                                <?php echo app('translator')->get('Only extract members when you have legal permission and consent for CRM outreach.'); ?>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Contact List'); ?></label>
                                        <select class="form--control select2" id="geContactList" style="width: 100%">
                                            <option value=""><?php echo app('translator')->get('Auto-create list'); ?></option>
                                            <?php $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list->id); ?>"><?php echo e(__(@$list->name)); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Country Hint'); ?></label>
                                        <input type="text" class="form--control" id="geCountryHint" maxlength="10"
                                            value="<?php echo e(strtoupper(getParentUser()->country_code ?? 'PK')); ?>"
                                            placeholder="<?php echo app('translator')->get('e.g. PK'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="d-flex align-items-start gap-2">
                                            <input type="checkbox" id="geAttestation" class="mt-1">
                                            <span>
                                                <?php echo app('translator')->get('I confirm I am authorized to extract and import these contacts into CRM.'); ?>
                                            </span>
                                        </label>
                                    </div>

                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php
                                            $groupCaptureZipPath = public_path('extensions/wa-group-capture/wa-group-capture.zip');
                                            $groupCaptureZipVersion = file_exists($groupCaptureZipPath) ? filemtime($groupCaptureZipPath) : time();
                                        ?>
                                        <a href="<?php echo e(asset('extensions/wa-group-capture/wa-group-capture.zip')); ?>?v=<?php echo e($groupCaptureZipVersion); ?>"
                                            class="btn btn--dark btn--sm" target="_blank">
                                            <i class="las la-download"></i> <?php echo app('translator')->get('Download Extension'); ?>
                                        </a>
                                        <button type="button" class="btn btn--base btn--sm" id="geConnectBtn">
                                            <i class="las la-plug"></i> <?php echo app('translator')->get('Connect Extension'); ?>
                                        </button>
                                        <button type="button" class="btn btn--info btn--sm" id="geHistoryBtn">
                                            <i class="las la-history"></i> <?php echo app('translator')->get('Load History'); ?>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-7">
                                    <div class="border rounded p-3">
                                        <h6 class="mb-2"><?php echo app('translator')->get('Live Import Status'); ?></h6>
                                        <p class="text-muted fs-14 mb-2" id="geStatusText">
                                            <?php echo app('translator')->get('No active job. Click Connect Extension, then start extraction from WhatsApp Web.'); ?>
                                        </p>
                                        <div id="geJobPanel" class="d-none">
                                            <div class="row gy-2">
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Job ID'); ?>:</strong> <span id="geJobId">-</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Status'); ?>:</strong> <span id="geJobStatus">-</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Total'); ?>:</strong> <span id="geTotal">0</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Processed'); ?>:</strong> <span id="geProcessed">0</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Imported'); ?>:</strong> <span id="geImported">0</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Updated'); ?>:</strong> <span id="geUpdated">0</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Skipped'); ?>:</strong> <span id="geSkipped">0</span></div>
                                                <div class="col-sm-6"><strong><?php echo app('translator')->get('Failed'); ?>:</strong> <span id="geFailed">0</span></div>
                                            </div>
                                            <div class="progress mt-2" style="height: 8px;">
                                                <div id="geProgressBar" class="progress-bar bg-success" role="progressbar"
                                                    style="width: 0%"></div>
                                            </div>
                                            <div class="mt-3 d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn--warning btn--sm" id="geRetryFailedBtn">
                                                    <?php echo app('translator')->get('Retry Failed'); ?>
                                                </button>
                                                <button type="button" class="btn btn--secondary btn--sm" id="geDownloadFailedBtn">
                                                    <?php echo app('translator')->get('Download Failed CSV'); ?>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="geHistoryPanel" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="legacy-paste-pane" role="tabpanel">
                            <form action="<?php echo e(route('user.contact.import.group')); ?>" method="POST" id="import-group-form">
                                <?php echo csrf_field(); ?>
                                <label class="label-two"><?php echo app('translator')->get('Paste Extracted Contacts'); ?></label>
                                <textarea name="paste_text" id="pasteTextArea" class="form--control" rows="6"
                                    placeholder="<?php echo app('translator')->get('Paste contacts manually here...'); ?>"></textarea>
                                <button type="button" class="btn btn--info btn--sm mt-2" id="pasteFromClipboardBtn">
                                    <i class="las la-clipboard"></i> <?php echo app('translator')->get('Paste from Clipboard'); ?>
                                </button>
                                <div class="row mt-2">
                                    <div class="col-md-6 form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Name Prefix (Optional)'); ?></label>
                                        <input type="text" name="name_prefix" class="form--control"
                                            placeholder="<?php echo app('translator')->get('e.g. Group Member'); ?>">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Contact List (Optional)'); ?></label>
                                        <select class="form--control select2" name="contact_list_id" style="width: 100%">
                                            <option value=""><?php echo app('translator')->get('Select List'); ?></option>
                                            <?php $__currentLoopData = $contactLists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($list->id); ?>"> <?php echo e(__(@$list->name)); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="button" class="btn btn--white" data-bs-dismiss="modal"><?php echo app('translator')->get('Cancel'); ?></button>
                                    <button type="submit" class="btn btn--base"><?php echo app('translator')->get('Import Legacy Paste'); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade custom--modal tags-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Contact Tags'); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <ul class="tag-list contact-tags">
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalbd5922df145d522b37bf664b524be380 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbd5922df145d522b37bf664b524be380 = $attributes; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ConfirmationModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isFrontend' => 'true']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $attributes = $__attributesOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__attributesOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbd5922df145d522b37bf664b524be380)): ?>
<?php $component = $__componentOriginalbd5922df145d522b37bf664b524be380; ?>
<?php unset($__componentOriginalbd5922df145d522b37bf664b524be380); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/group_extraction_client.js?v=20260221c')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            const $modal = $('.importModal');
            const $groupModal = $('.importGroupModal');
            const $form = $('#import-form');
            const $groupForm = $('#import-group-form');
            const $drop = $('.thumb-form');
            const $input = $drop.find('input[type="file"]');
            const $progress = $('#import-progress');
            const $bar = $progress.find('.progress-bar');

            $('.importBtn').on('click', () => $modal.modal('show'));
            $('.importGroupBtn').on('click', () => $groupModal.modal('show'));

            $('.filter-form select').on('change', function() {
                $(this).closest('form').submit();
            });

            $form.on('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                $progress.removeClass('d-none');
                $bar.css('width', '0%');

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    xhr: function() {
                        const xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener('progress', function(e) {
                            if (e.lengthComputable) {
                                const percent = (e.loaded / e.total) * 100;
                                $bar.css('width', percent + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    success: function(res) {
                        $progress.addClass('d-none');
                        $bar.css('width', '0%');

                        if (res.status === 'success') {
                            notify('success', res.message);
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            notify('error', res.message || "Something went wrong");
                        }
                    },
                    error: function(xhr) {
                        $progress.addClass('d-none');
                        $bar.css('width', '0%');

                        let errorMessage = "Something went wrong";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        } else {
                            console.error('Unexpected response:', xhr.responseText);
                        }
                        notify('error', errorMessage);
                    }
                });
            });


            $(document).on('dragover dragenter drop', e => e.preventDefault());

            $drop.on('dragover', () => $drop.addClass('drag-over'))
                .on('dragleave drop', () => $drop.removeClass('drag-over'));

            $drop.on('drop', e => {
                const files = e.originalEvent.dataTransfer.files;
                if (files.length) {
                    $input[0].files = files;
                    $('.file-name').text($input[0].files[0].name);
                }
            });

            $input.on('change', () => {
                $('.file-name').text($input[0].files[0].name);
            })

            $('.more_tags_btn').on('click', function() {
                const contactTags = $(this).data('tags');
                $('.contact-tags').html('');
                contactTags.forEach(tag => {
                    $('.contact-tags').append(`
                    <li>
                        <a href = "?tag_id=${tag.id}" class = "tag-list__link">${tag.name}</a>
                    </li>`);
                });
                $('.tags-modal').modal('show');
            });
            
            // Paste from Clipboard button handler
            $('#pasteFromClipboardBtn').on('click', async function() {
                try {
                    const text = await navigator.clipboard.readText();
                    if (text && text.trim()) {
                        $('#pasteTextArea').val(text);
                        notify('success', 'Contacts pasted successfully!');
                    } else {
                        notify('warning', 'Clipboard is empty. Run the extractor on WhatsApp Web first.');
                    }
                } catch (err) {
                    notify('error', 'Could not access clipboard. Please paste manually (Ctrl+V).');
                    console.error('Clipboard error:', err);
                }
            });

            // Bulk Delete Logic
            $(document).on('click', '.checkAll', function() {
                if($(this).is(':checked')) {
                    $('.contactCheck').prop('checked', true);
                } else {
                    $('.contactCheck').prop('checked', false);
                }
                toggleDeleteBtn();
            });

            $(document).on('change', '.contactCheck', function() {
                toggleDeleteBtn();
                if($('.contactCheck:checked').length == $('.contactCheck').length) {
                    $('.checkAll').prop('checked', true);
                } else {
                    $('.checkAll').prop('checked', false);
                }
            });

            function toggleDeleteBtn() {
                if($('.contactCheck:checked').length > 0) {
                    $('#bulkDeleteBtn').removeClass('d-none');
                } else {
                    $('#bulkDeleteBtn').addClass('d-none');
                }
            }

            $('#bulkDeleteBtn').on('click', function() {
                var ids = [];
                $('.contactCheck:checked').each(function() {
                    ids.push($(this).val());
                });

                if(ids.length > 0) {
                    var modal = $('#bulkDeleteModal');
                    modal.find('.count').text(ids.length);
                    // Store as JSON string to avoid max_input_vars limit with 1000+ items
                    $('#finalBulkDeleteIds').val(JSON.stringify(ids));
                    modal.modal('show');
                }
            });

            $(document).on('click', '#confirmDeleteBtn', function() {
                // Fail-safe: Ensure input is populated
                var val = $('#finalBulkDeleteIds').val();
                if (!val || val === '[]') {
                    var ids = [];
                    $('.contactCheck:checked').each(function() {
                        ids.push($(this).val());
                    });
                    $('#finalBulkDeleteIds').val(JSON.stringify(ids));
                }

                $('#finalBulkDeleteForm').submit();
            });
            
            // Re-render checkAll logic on pagination (handled by standard page reload, so fine)

            if (window.GroupExtractionClient) {
                window.GroupExtractionClient.init({
                    routes: {
                        session: "<?php echo e(route('user.contact.group.extraction.session')); ?>",
                        status: "<?php echo e(route('user.contact.group.extraction.status', ['id' => '__JOB_ID__'])); ?>",
                        result: "<?php echo e(route('user.contact.group.extraction.result', ['id' => '__JOB_ID__'])); ?>",
                        retry: "<?php echo e(route('user.contact.group.extraction.retry', ['id' => '__JOB_ID__'])); ?>",
                        history: "<?php echo e(route('user.contact.group.extraction.history')); ?>",
                    },
                    selectors: {
                        connectBtn: '#geConnectBtn',
                        historyBtn: '#geHistoryBtn',
                        retryBtn: '#geRetryFailedBtn',
                        failedCsvBtn: '#geDownloadFailedBtn',
                        attestation: '#geAttestation',
                        contactList: '#geContactList',
                        countryHint: '#geCountryHint',
                        statusText: '#geStatusText',
                        historyPanel: '#geHistoryPanel',
                        jobPanel: '#geJobPanel',
                        jobId: '#geJobId',
                        jobStatus: '#geJobStatus',
                        total: '#geTotal',
                        processed: '#geProcessed',
                        imported: '#geImported',
                        updated: '#geUpdated',
                        skipped: '#geSkipped',
                        failed: '#geFailed',
                        progressBar: '#geProgressBar',
                    }
                });
            }

            const queryParams = new URLSearchParams(window.location.search);
            if (queryParams.get('open_group_import') === '1') {
                $groupModal.modal('show');
            }
            
        })(jQuery);
    </script>
    
    <!-- Bulk Delete Confirmation Modal -->
    <div class="modal fade" id="bulkDeleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
                <div class="modal-body text-center p-4">
                    <i class="las la-exclamation-circle text-danger display-1 mb-3"></i>
                    <h4 class="text--secondary mb-2"><?php echo app('translator')->get('Are you sure?'); ?></h4>
                    <p class="text--secondary mb-4"><?php echo app('translator')->get('You are about to delete'); ?> <span class="count fw-bold"></span> <?php echo app('translator')->get('contacts. This action cannot be undone.'); ?></p>
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal"><?php echo app('translator')->get('Cancel'); ?></button>
                        <button type="button" class="btn btn--danger" id="confirmDeleteBtn"><?php echo app('translator')->get('Yes, Delete'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/contact/index.blade.php ENDPATH**/ ?>