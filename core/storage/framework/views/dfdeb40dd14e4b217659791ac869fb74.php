
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
                            <button class="nav-link active" id="console-script-tab" data-bs-toggle="tab"
                                data-bs-target="#console-script-pane" type="button" role="tab">
                                <i class="las la-terminal"></i> <?php echo app('translator')->get('Console Script'); ?> <span class="badge bg-success ms-1"><?php echo app('translator')->get('Recommended'); ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="extension-import-tab" data-bs-toggle="tab"
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
                        
                        <div class="tab-pane fade show active" id="console-script-pane" role="tabpanel">
                            <div class="alert alert-info py-2 mb-3">
                                <strong><i class="las la-bolt"></i> <?php echo app('translator')->get('100% Accurate Extraction'); ?></strong> —
                                <?php echo app('translator')->get('This method reads WhatsApp\'s internal data directly. No extension needed.'); ?>
                            </div>

                            <div class="row g-3">
                                <div class="col-lg-7">
                                    <h6><?php echo app('translator')->get('Step-by-step Instructions:'); ?></h6>
                                    <ol class="mb-3" style="line-height: 2;">
                                        <li><?php echo app('translator')->get('Open'); ?> <a href="https://web.whatsapp.com" target="_blank"><strong>web.whatsapp.com</strong></a> <?php echo app('translator')->get('and open the group chat'); ?></li>
                                        <li><?php echo app('translator')->get('Click the'); ?> <strong><?php echo app('translator')->get('group header/name'); ?></strong> <?php echo app('translator')->get('at the top to open group info'); ?></li>
                                        <li><?php echo app('translator')->get('Press'); ?> <kbd>F12</kbd> <?php echo app('translator')->get('to open Developer Tools, then click the'); ?> <strong>Console</strong> <?php echo app('translator')->get('tab'); ?></li>
                                        <li><?php echo app('translator')->get('Click the button below to copy the script, then paste it in the console and press'); ?> <kbd>Enter</kbd></li>
                                        <li><?php echo app('translator')->get('Come back here and click'); ?> <strong>"<?php echo app('translator')->get('Paste from Clipboard'); ?>"</strong> <?php echo app('translator')->get('in the Legacy Paste tab'); ?></li>
                                    </ol>

                                    <div class="d-flex gap-2 flex-wrap mb-3">
                                        <button type="button" class="btn btn--base btn--sm" id="copyConsoleScriptBtn">
                                            <i class="las la-copy"></i> <?php echo app('translator')->get('Copy Extraction Script'); ?>
                                        </button>
                                        <span class="badge bg-secondary fs-12 align-self-center" id="scriptCopyStatus" style="display:none;">
                                            <i class="las la-check"></i> <?php echo app('translator')->get('Copied!'); ?>
                                        </span>
                                    </div>

                                    <div class="alert alert-warning py-2 mb-0">
                                        <small><i class="las la-info-circle"></i>
                                        <?php echo app('translator')->get('After running the script, all member phone numbers will be automatically copied to your clipboard. Then switch to the "Legacy Paste" tab and paste them.'); ?></small>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <h6><?php echo app('translator')->get('Preview of the script:'); ?></h6>
                                    <pre id="consoleScriptPreview" class="bg-dark text-light p-3 rounded" style="font-size:11px; max-height:250px; overflow:auto; white-space:pre-wrap; word-break:break-all; cursor:pointer;"
                                        title="<?php echo app('translator')->get('Click to copy'); ?>"></pre>
                                    <small class="text-muted"><?php echo app('translator')->get('This script reads the currently open group\'s member list from WhatsApp Web\'s internal data and copies all phone numbers to your clipboard.'); ?></small>
                                </div>
                            </div>
                        </div>

                        
                        <div class="tab-pane fade" id="extension-import-pane" role="tabpanel">
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
                                <p class="text-muted fs-12 mb-1">
                                    <?php echo app('translator')->get('Paste phone numbers in ANY format — one per line, pipe-separated, CSV, or mixed text. Numbers are auto-detected.'); ?>
                                </p>
                                <textarea name="paste_text" id="pasteTextArea" class="form--control" rows="6"
                                    placeholder="<?php echo app('translator')->get('Examples of supported formats:'); ?>&#10;+92 300 1234567&#10;John Doe, +923001234567&#10;923001234567|923012345678&#10;Name: 03001234567&#10;<?php echo app('translator')->get('...or any text containing phone numbers'); ?>"></textarea>
                                <div class="d-flex align-items-center gap-2 mt-2 flex-wrap">
                                    <button type="button" class="btn btn--info btn--sm" id="pasteFromClipboardBtn">
                                        <i class="las la-clipboard"></i> <?php echo app('translator')->get('Paste from Clipboard'); ?>
                                    </button>
                                    <span class="badge bg-secondary fs-12" id="pastePreviewCount" style="display:none;">
                                        <i class="las la-phone"></i> <span id="pasteDetectedCount">0</span> <?php echo app('translator')->get('numbers detected'); ?>
                                    </span>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4 form-group">
                                        <label class="label-two"><?php echo app('translator')->get('Name Prefix (Optional)'); ?></label>
                                        <input type="text" name="name_prefix" class="form--control"
                                            placeholder="<?php echo app('translator')->get('e.g. Group Member'); ?>">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label class="label-two">
                                            <?php echo app('translator')->get('Country Hint'); ?>
                                            <span data-bs-toggle="tooltip" title="<?php echo app('translator')->get('Default country code for numbers without a prefix (e.g. PK for Pakistan, IN for India)'); ?>">
                                                <i class="las la-question-circle"></i>
                                            </span>
                                        </label>
                                        <input type="text" name="country_hint" class="form--control" maxlength="10"
                                            value="<?php echo e(strtoupper(getParentUser()->country_code ?? 'PK')); ?>"
                                            placeholder="<?php echo app('translator')->get('e.g. PK'); ?>">
                                    </div>
                                    <div class="col-md-4 form-group">
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
                        $('#pasteTextArea').val(text).trigger('input');
                        notify('success', 'Contacts pasted successfully!');
                    } else {
                        notify('warning', 'Clipboard is empty. Run the extractor on WhatsApp Web first.');
                    }
                } catch (err) {
                    notify('error', 'Could not access clipboard. Please paste manually (Ctrl+V).');
                    console.error('Clipboard error:', err);
                }
            });

            // Live preview: count detected phone numbers as user types/pastes
            function countDetectedPhones(text) {
                if (!text || !text.trim()) return 0;
                const seen = new Set();
                // Find all phone-like patterns
                const pattern = /(?:\+\s*)?(?:00\s*)?(?:\(?\d{1,4}\)?\s*[-.\s]?\s*){1,}\d{2,}/g;
                const matches = text.match(pattern) || [];
                matches.forEach(function(m) {
                    const digits = m.replace(/\D/g, '');
                    if (digits.length >= 7 && digits.length <= 15) {
                        const key = digits.length >= 10 ? digits.slice(-10) : digits;
                        seen.add(key);
                    }
                });
                return seen.size;
            }

            let previewTimer = null;
            $('#pasteTextArea').on('input change keyup paste', function() {
                clearTimeout(previewTimer);
                previewTimer = setTimeout(function() {
                    const text = $('#pasteTextArea').val();
                    const count = countDetectedPhones(text);
                    if (count > 0) {
                        $('#pasteDetectedCount').text(count);
                        $('#pastePreviewCount').show();
                    } else {
                        $('#pastePreviewCount').hide();
                    }
                }, 300);
            });

            // ═══════════════════════════════════════════════════════
            // Console Script — extraction script generator v3.0
            // Multi-strategy with STRICT phone validation (7-13 digits only)
            // ═══════════════════════════════════════════════════════
            const CONSOLE_SCRIPT = `(async function(){
  /* WA Group Extractor v3.0 — strict phone validation */
  var V="3.0",log=function(m){console.log("%c[WAExtract v"+V+"] "+m,"color:#00cc66;font-weight:bold")};var warn=function(m){console.warn("[WAExtract v"+V+"] "+m)};
  log("Starting v"+V+"...");

  /* === Helpers === */
  function sid(o){if(!o)return"";if(typeof o==="string"){if(o.includes("@c.us")||o.includes("@s.whatsapp.net")||o.includes("@g.us"))return o;return""}for(var v of[o._serialized,o.serialized,o?.id?._serialized,o?.id?.serialized,o?.wid?._serialized,o?.wid?.serialized,o?.jid?._serialized,o?.jid?.serialized]){if(typeof v==="string"&&v&&(v.includes("@c.us")||v.includes("@s.whatsapp.net")||v.includes("@g.us")))return v}var u=o.user||o?.id?.user||o?.wid?.user;return u?(u+"@"+(o.server||o?.id?.server||"c.us")):""}
  function asArr(s){if(!s)return[];if(Array.isArray(s))return s;for(var p of["_models","models"]){if(Array.isArray(s[p]))return s[p]}for(var f of["toArray","getModelsArray"]){if(typeof s[f]==="function")try{var a=s[f]();if(Array.isArray(a))return a}catch(e){}}if(typeof s?.values==="function")try{return Array.from(s.values())}catch(e){}try{if(s&&typeof s[Symbol.iterator]==="function")return Array.from(s)}catch(e){}return[]}
  function getParts(c){if(!c)return[];var all=[];for(var src of[c?.groupMetadata?.participants,c?.groupMetadata?._participants,c?.participants,c?.__x_groupMetadata?.participants,c?.__x_participants,c?.participantCollection]){var a=asArr(src);if(a.length>0)all=all.concat(a)}if(all.length===0&&c?.groupMetadata){for(var k of Object.keys(c.groupMetadata)){try{var v=c.groupMetadata[k];var a2=asArr(v);if(a2.length>=2&&a2.slice(0,3).some(function(x){return sid(x?.id||x?.wid||x).includes("@c.us")})){all=a2;break}}catch(e){}}}var seen={};return all.filter(function(p){var id=sid(p?.id||p?.wid||p);if(!id||seen[id])return false;seen[id]=1;return true})}
  function pPhone(p){for(var x of[p?.id,p?.wid,p?.contact?.id,p?.contact?.wid,p?.participant,p?.__x_id,p?.jid,p]){var s=sid(x);if(s&&(s.includes("@c.us")||s.includes("@s.whatsapp.net"))){var d=s.split("@")[0].replace(/\\D/g,"");if(d.length>=7&&d.length<=13)return d}}return""}
  function pName(p){for(var v of[p?.shortName,p?.name,p?.pushname,p?.notifyName,p?.displayName,p?.formattedName,p?.contact?.name,p?.contact?.pushname,p?.contact?.notifyName,p?.contact?.displayName]){var s=String(v||"").trim();if(s)return s}return""}

  /* === Find target group ID from URL === */
  var hash=decodeURIComponent(location.hash||"").replace(/^#\\/?/,"").split("?")[0].trim();
  var tid="";
  if(hash.includes("@g.us"))tid=hash;
  else{var dg=hash.replace(/[^0-9\\-]/g,"");if(dg)tid=dg+"@g.us"}

  var chat=null;

  /* === STRATEGY 1: Webpack chunk arrays (try EVERY array on window) === */
  log("Strategy 1: Trying webpack chunk hook on ALL window arrays...");
  var req=null;
  try{
    var keys=Object.getOwnPropertyNames(window);
    for(var i=0;i<keys.length;i++){
      try{
        var val=window[keys[i]];
        if(!val||!Array.isArray(val)||!val.push)continue;
        val.push([[Date.now()+"_ge"],{},function(r){req=r}]);
        if(req&&req.c){log("Strategy 1: Found require via window."+keys[i]);break}
        req=null;
      }catch(e){}
    }
  }catch(e){log("Strategy 1 error: "+e.message)}

  /* === STRATEGY 2: __webpack_require__ global === */
  if(!req||!req.c){
    log("Strategy 2: Trying __webpack_require__...");
    try{
      if(typeof window.__webpack_require__==="function"&&window.__webpack_require__.c){
        req=window.__webpack_require__;
        log("Strategy 2: Found __webpack_require__");
      }
    }catch(e){}
  }

  /* === Search module cache if we have req === */
  if(req&&req.c){
    log("Searching module cache ("+Object.keys(req.c).length+" modules)...");
    var bestN=0;
    for(var key in req.c){
      try{
        var exp=req.c[key]?.exports;if(!exp)continue;
        for(var vv of[exp,exp?.default].filter(Boolean)){
          for(var b of[vv,vv?.Chat,vv?.ChatCollection,vv?.GroupChat,vv?.GroupMetadata,vv?.default?.Chat,vv?.default?.GroupMetadata]){
            if(!b)continue;
            if(typeof b.get==="function"&&tid){try{var c=b.get(tid);if(c&&getParts(c).length>0){chat=c;log("Found group via .get(tid)")}}catch(e){}}
            if(chat)break;
            for(var item of asArr(b)){
              var id=sid(item?.id||item);if(!id.includes("@g.us"))continue;
              var p=getParts(item);if(p.length===0)continue;
              if(tid&&id===tid){chat=item;log("Found exact match in cache");break}
              if(p.length>bestN){bestN=p.length;chat=item}
            }
            if(chat&&tid&&sid(chat?.id)===tid)break;
          }
          if(chat&&tid&&sid(chat?.id)===tid)break;
        }
      }catch(e){}
      if(chat&&tid&&sid(chat?.id)===tid)break;
    }
    if(chat)log("Module cache: found group with "+getParts(chat).length+" participants");
  }

  /* === STRATEGY 3: Scan ALL window properties for Store-like objects === */
  if(!chat){
    log("Strategy 3: Scanning window for Store objects...");
    try{
      var wKeys=Object.getOwnPropertyNames(window);
      for(var wi=0;wi<wKeys.length;wi++){
        try{
          var wv=window[wKeys[wi]];
          if(!wv||typeof wv!=="object")continue;
          /* Look for objects that have Chat/GroupMetadata stores */
          for(var storeProp of["Chat","GroupMetadata","Group","Conn"]){
            var store=wv[storeProp];if(!store)continue;
            if(typeof store.get==="function"&&tid){
              try{var gc=store.get(tid);if(gc&&getParts(gc).length>0){chat=gc;log("Strategy 3: Found via window."+wKeys[wi]+"."+storeProp);break}}catch(e){}
            }
            for(var itm of asArr(store)){
              var itId=sid(itm?.id||itm);if(!itId.includes("@g.us"))continue;
              var pp=getParts(itm);if(pp.length>=2){chat=itm;log("Strategy 3: Found via iteration");break}
            }
            if(chat)break;
          }
        }catch(e){}
        if(chat)break;
      }
    }catch(e){log("Strategy 3 error: "+e.message)}
  }

  /* === STRATEGY 4: React Fiber traversal === */
  if(!chat){
    log("Strategy 4: React Fiber traversal...");
    try{
      var fKey="";
      var probeEls=[document.getElementById("app"),document.querySelector("#main"),document.querySelector("#main header"),document.querySelector("div[tabindex]")].filter(Boolean);
      for(var pe of probeEls){
        for(var pk of Object.keys(pe)){
          if(pk.startsWith("__reactFiber\\$")||pk.startsWith("__reactInternalInstance\\$")){fKey=pk;break}
        }
        if(fKey)break;
      }
      if(fKey){
        log("Found React Fiber key: "+fKey.slice(0,25)+"...");
        var entryEls=[document.querySelector("#main header"),document.querySelector("#main"),document.getElementById("app")].filter(function(e){return e&&e[fKey]});
        for(var ent of entryEls){
          var fiber=ent[fKey];var visited=new Set();var depth=0;
          while(fiber&&depth<500){
            if(visited.has(fiber))break;visited.add(fiber);depth++;
            var props=fiber.memoizedProps;
            if(props&&typeof props==="object"){
              for(var fpk of Object.keys(props).slice(0,50)){
                try{
                  var fpv=props[fpk];if(!fpv||typeof fpv!=="object")continue;
                  if(fpv.groupMetadata||fpv.participants||fpv._participants){
                    var cand=fpv.groupMetadata?fpv:{groupMetadata:fpv};
                    if(getParts(cand).length>=2){chat=cand;log("Strategy 4: Found in Fiber props");break}
                  }
                }catch(e){}
              }
            }
            if(chat)break;
            fiber=fiber.return;
          }
          if(chat)break;
        }
      }else{log("No React Fiber key found")}
    }catch(e){log("Strategy 4 error: "+e.message)}
  }

  /* === QUALITY GATE: validate runtime data has real phone numbers === */
  if(chat&&getParts(chat).length>0){
    var qParts=getParts(chat);var qValid=0;var qSamples=[];
    for(var qi=0;qi<Math.min(qParts.length,20);qi++){
      var qSid=sid(qParts[qi]?.id||qParts[qi]?.wid||qParts[qi]);
      var qPh=pPhone(qParts[qi]);
      if(qi<5)qSamples.push(qSid+" => "+(qPh||"INVALID"));
      if(qPh)qValid++;
    }
    log("Quality gate: "+qValid+"/"+qParts.length+" have valid phone (7-13 digits)");
    log("Sample JIDs: "+qSamples.join(" | "));
    if(qValid===0){log("REJECTING runtime data — 0 valid phones! Falling back to DOM.");chat=null}
    else if(qValid<qParts.length*0.15){log("WARNING: Only "+Math.round(qValid/qParts.length*100)+"% valid — data may be unreliable")}
  }

  /* === STRATEGY 5: DOM extraction (guaranteed to work) === */
  if(!chat||getParts(chat).length===0){
    log("Strategy 5: DOM extraction — scrolling through member list...");
    /* Find the member list panel by looking for "Search members" or "N members" text */
    var memberPanel=null;
    var sidebar=document.querySelector("#side")||document.querySelector("#pane-side");
    function inSidebarFn(el){return sidebar?sidebar.contains(el):false}

    var textEls=document.querySelectorAll("span,div,header,p");
    var candidates=[];
    for(var ti=0;ti<textEls.length;ti++){
      var tel=textEls[ti];if(inSidebarFn(tel))continue;
      var txt=(tel.textContent||"").trim();
      if(/^search\\s+(members|participants)/i.test(txt)||/^\\d+\\s+(participant|member)s?$/i.test(txt)){
        var par=tel.parentElement;
        for(var up=0;up<25&&par&&par!==document.body;up++){
          var items=par.querySelectorAll('[role="listitem"]');
          if(items.length>=3){candidates.push({el:par,n:items.length,pri:/search/i.test(txt)?10:5});break}
          par=par.parentElement;
        }
      }
    }
    /* Also try role="list" containers */
    var lists=document.querySelectorAll('[role="list"]');
    for(var li=0;li<lists.length;li++){
      if(inSidebarFn(lists[li]))continue;
      var lItems=lists[li].querySelectorAll('[role="listitem"]');
      if(lItems.length>=3)candidates.push({el:lists[li],n:lItems.length,pri:2});
    }
    candidates.sort(function(a,b){return b.pri-a.pri||b.n-a.n});
    memberPanel=candidates[0]?.el||null;

    if(!memberPanel){
      alert("ERROR: Could not find the member list.\\n\\nPlease do this:\\n1. Open the group chat\\n2. Click the group name at the top\\n3. Click \\"Search\\" or scroll down to \\"Members\\"\\n4. Click \\"View all (N more)\\"\\n5. Then run this script again");
      throw new Error("member panel not found");
    }

    log("Found member panel with "+memberPanel.querySelectorAll('[role="listitem"]').length+" items");

    /* Find scrollable */
    var scrollDiv=null;
    if(memberPanel.scrollHeight>memberPanel.clientHeight+40)scrollDiv=memberPanel;
    if(!scrollDiv){
      var scrollKids=Array.from(memberPanel.querySelectorAll("div")).filter(function(d){return d.scrollHeight>d.clientHeight+40&&d.clientHeight>80}).sort(function(a,b){return b.scrollHeight-a.scrollHeight});
      scrollDiv=scrollKids[0]||null;
    }

    var domMap={};var dupCount=0;var nameOnlyDom=0;
    function collectDom(){
      var items=memberPanel.querySelectorAll('[role="listitem"]');
      for(var ii=0;ii<items.length;ii++){
        var item=items[ii];if(inSidebarFn(item))continue;
        var found=false;
        /* data-jid */
        var jid=item.getAttribute("data-jid")||"";
        if(jid&&(jid.includes("@c.us")||jid.includes("@s.whatsapp.net"))){
          var ph=jid.split("@")[0].replace(/\\D/g,"");
          if(ph.length>=7&&ph.length<=13){
            var ne=item.querySelector("span[title]");
            var nm=ne?(ne.getAttribute("title")||ne.textContent||"").trim():"";
            if(!domMap[ph])domMap[ph]={name:nm,phone:ph};else dupCount++;
            found=true;
          }
        }
        /* nested data-jid */
        if(!found){
          var jEl=item.querySelector("[data-jid]");
          if(jEl){var j2=jEl.getAttribute("data-jid")||"";
            if(j2.includes("@c.us")||j2.includes("@s.whatsapp.net")){
              var ph2=j2.split("@")[0].replace(/\\D/g,"");
              if(ph2.length>=7&&ph2.length<=13){
                var ne2=item.querySelector("span[title]");
                var nm2=ne2?(ne2.getAttribute("title")||ne2.textContent||"").trim():"";
                if(!domMap[ph2])domMap[ph2]={name:nm2,phone:ph2};else dupCount++;
                found=true;
              }
            }
          }
        }
        /* span[title] with phone */
        if(!found){
          var ts=item.querySelector("span[title]");
          if(ts){
            var tt=(ts.getAttribute("title")||"").trim();
            var pm=tt.match(/(\\+?\\d[\\d\\s()\\-]{5,}\\d)/);
            if(pm){var ph3=pm[1].replace(/\\D/g,"");
              if(ph3.length>=7&&ph3.length<=13){
                var nm3=tt.replace(pm[1],"").replace(/[,;:\\-\\s]+$/,"").trim();
                if(!domMap[ph3])domMap[ph3]={name:nm3,phone:ph3};else dupCount++;
                found=true;
              }
            }else if(tt&&tt.toLowerCase()!=="you"){nameOnlyDom++}
          }
        }
      }
      /* data-jid elements that aren't listitems */
      var jEls=memberPanel.querySelectorAll("[data-jid]");
      for(var ji=0;ji<jEls.length;ji++){
        if(inSidebarFn(jEls[ji]))continue;
        var jj=jEls[ji].getAttribute("data-jid")||"";
        if(!jj.includes("@c.us")&&!jj.includes("@s.whatsapp.net"))continue;
        var ph4=jj.split("@")[0].replace(/\\D/g,"");
        if(ph4.length>=7&&ph4.length<=13&&!domMap[ph4]){
          var ne4=jEls[ji].querySelector("span[title]")||jEls[ji].querySelector("span[dir='auto']");
          var nm4=ne4?(ne4.getAttribute("title")||ne4.textContent||"").trim():"";
          domMap[ph4]={name:nm4,phone:ph4};
        }
      }
    }

    /* Scroll loop */
    var stable=0;
    for(var si=0;si<300;si++){
      collectDom();
      if(!scrollDiv)break;
      var before=scrollDiv.scrollTop;
      scrollDiv.scrollTop=before+Math.max(100,Math.floor(scrollDiv.clientHeight*0.75));
      await new Promise(function(r){setTimeout(r,280)});
      if(Math.abs(scrollDiv.scrollTop-before)<4){if(++stable>=5)break}else{stable=0}
    }
    if(scrollDiv){scrollDiv.scrollTop=0;await new Promise(function(r){setTimeout(r,400)});collectDom()}

    var domKeys=Object.keys(domMap);
    log("DOM extraction: "+domKeys.length+" unique phones, "+dupCount+" dupes, "+nameOnlyDom+" name-only");

    if(domKeys.length>0){
      /* Resolve group name */
      var gNameDom="WhatsApp Group";
      var mh=document.querySelector("#main header span[title]");
      if(mh){var mt=(mh.getAttribute("title")||"").trim();if(mt&&mt.split(",").length<=4&&mt.length<120)gNameDom=mt}
      var domLines=domKeys.map(function(k){var m=domMap[k];return m.name?(m.name+", +"+m.phone):("+"+m.phone)});
      var domOutput=domLines.join("\\n");
      try{
        await navigator.clipboard.writeText(domOutput);
        alert("SUCCESS (DOM)! "+domLines.length+" members extracted from \\""+gNameDom+"\\"\\n"+(nameOnlyDom>0?nameOnlyDom+" saved contacts had name only (no phone visible).\\n":"")+"\\nPhone numbers COPIED TO CLIPBOARD.\\nGo to CRM → Import from Group → Legacy Paste → click Paste from Clipboard.");
      }catch(e2){
        console.log("=== COPY THESE NUMBERS ===");console.log(domOutput);
        prompt("Auto-copy failed. Check console (scroll up) for full list. First numbers:",domOutput.slice(0,500));
      }
      console.log("Extracted "+domLines.length+" from "+gNameDom);console.log(domOutput);
      return;
    }
    alert("ERROR: Could not extract any members. Make sure the full member list is open.");
    return;
  }

  /* === We have a chat object — extract from runtime data === */
  var parts=getParts(chat);
  log("Runtime extraction: "+parts.length+" participants (via Store/webpack)");
  var lines=[];var seen={};var nameOnly=0;
  for(var p of parts){var phone=pPhone(p);var name=pName(p);if(!phone){nameOnly++;continue}if(seen[phone])continue;seen[phone]=1;lines.push(name?(name+", +"+phone):("+"+phone))}
  log("Runtime result: "+lines.length+" valid phones, "+nameOnly+" without phone");
  if(lines.length>0){log("Sample: "+lines.slice(0,3).join(" | "))}
  if(lines.length===0){
    log("Runtime gave 0 valid phones. Check console logs above for JID samples.");
    alert("Store data had 0 valid phone numbers (all were internal IDs).\\nThe data-jid values in the member list DOM will be tried next.\\nRe-run the script with the member list open.");
    return;
  }
  var gName=(chat?.formattedTitle||chat?.name||chat?.groupMetadata?.subject||"WhatsApp Group");
  if(gName.split(",").length>4)gName="WhatsApp Group";
  gName=gName.slice(0,100);
  var output=lines.join("\\n");
  try{
    await navigator.clipboard.writeText(output);
    alert("SUCCESS! "+lines.length+" members extracted from \\""+gName+"\\"\\n"+(nameOnly>0?nameOnly+" members had no phone.\\n":"")+"\\nPhone numbers COPIED TO CLIPBOARD.\\nGo to CRM → Import from Group → Legacy Paste → click Paste from Clipboard.");
  }catch(e2){
    console.log("=== COPY THESE NUMBERS ===");console.log(output);
    prompt("Auto-copy failed. Check console for full list:",output.slice(0,500));
  }
  console.log("Extracted "+lines.length+" from "+gName);console.log(output);
})();`;

            // Set preview
            $('#consoleScriptPreview').text(CONSOLE_SCRIPT);

            // Copy button
            $('#copyConsoleScriptBtn').on('click', async function() {
                try {
                    await navigator.clipboard.writeText(CONSOLE_SCRIPT);
                    $(this).html('<i class="las la-check"></i> Copied!').removeClass('btn--base').addClass('btn--success');
                    $('#scriptCopyStatus').show();
                    notify('success', 'Script copied to clipboard! Now paste it in WhatsApp Web console (F12).');
                    setTimeout(() => {
                        $(this).html('<i class="las la-copy"></i> Copy Extraction Script').removeClass('btn--success').addClass('btn--base');
                        $('#scriptCopyStatus').hide();
                    }, 5000);
                } catch (err) {
                    // Fallback: select the pre element text
                    const range = document.createRange();
                    range.selectNodeContents(document.getElementById('consoleScriptPreview'));
                    window.getSelection().removeAllRanges();
                    window.getSelection().addRange(range);
                    notify('warning', 'Auto-copy failed. The script text has been selected — press Ctrl+C to copy.');
                }
            });

            // Click on preview to copy
            $('#consoleScriptPreview').on('click', function() {
                $('#copyConsoleScriptBtn').trigger('click');
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