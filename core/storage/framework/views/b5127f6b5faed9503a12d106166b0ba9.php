<?php $__env->startSection('content'); ?>
    <div class="alert alert--info alert-dismissible mb-3 template-requirements" role="alert">
        <div class="alert__content">
            <h4 class="alert__title"><i class="las la-info-circle"></i> <?php echo app('translator')->get('Template Information'); ?></h4>
            <ul class="ms-4">
                <li class="mb-0 text-dark"><?php echo app('translator')->get('The template name must be unique and less than 512 characters. '); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('You can submit a maximum of 100 templates per hour.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('You can add up to 6 Quick Reply buttons, 2 Visit Website buttons, 1 Call to Number button, and 1 Copy Offer Code button per template.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('Templates with authentication type can only contain a single button.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('Header text can contain a maximum of 1024 characters with 1 variable.'); ?></li>
            </ul>
        </div>
    </div>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Easily create and manage message templates for seamless communication.'); ?></p>
            </div>
            <div class="container-top__right">
                <div class="btn--group">
                    <a href="<?php echo e(route('user.template.index')); ?>" class="btn btn--dark">
                        <i class="las la-undo"></i>
                        <?php echo app('translator')->get('Back'); ?>
                    </a>
                    <button class="btn btn--base btn-shadow submitBtn" type="submit" form="template-form">
                        <i class="lab la-telegram"></i> <?php echo app('translator')->get('Save Template'); ?>
                    </button>
                </div>
            </div>
        </div>
        <div class="dashboard-container__body">
            <div class="template-info-container">
                <div class="template-info-container__left">
                    <form action="<?php echo e(route('user.template.store')); ?>" method="POST" id="template-form"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Whatsapp Account'); ?></label>
                                    <?php if (isset($component)) { $__componentOriginal78fc733786e0718cdf5e64f6023f5630 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal78fc733786e0718cdf5e64f6023f5630 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.whatsapp_account','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('whatsapp_account'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal78fc733786e0718cdf5e64f6023f5630)): ?>
<?php $attributes = $__attributesOriginal78fc733786e0718cdf5e64f6023f5630; ?>
<?php unset($__attributesOriginal78fc733786e0718cdf5e64f6023f5630); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal78fc733786e0718cdf5e64f6023f5630)): ?>
<?php $component = $__componentOriginal78fc733786e0718cdf5e64f6023f5630; ?>
<?php unset($__componentOriginal78fc733786e0718cdf5e64f6023f5630); ?>
<?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Pre Made Templates'); ?></label>
                                    <select class="form--control form-two pre-made-template select2">
                                        <?php $__currentLoopData = $preMadeTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $preMadeTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="" data-template='<?php echo json_encode($preMadeTemplate, 15, 512) ?>'>
                                                <?php echo e(keyToTitle(__($preMadeTemplate->name))); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Template Name'); ?></label>
                                    <input type="text" class="form--control form-two" name="name"
                                        placeholder="<?php echo app('translator')->get('Enter a unique name for this template'); ?>" value="<?php echo e(old('name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="label-two">
                                        <?php echo app('translator')->get('Category'); ?>
                                    </label>
                                    <select class="form--control select2" name="category_id"
                                        data-minimum-results-for-search="-1" required>
                                        <option selected value=""><?php echo app('translator')->get('Select Template Category'); ?></option>
                                        <?php $__currentLoopData = $templateCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $templateCategory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(@$templateCategory->id); ?>"
                                                data-category="<?php echo e($templateCategory->name); ?>" <?php if(old('category_id') == $templateCategory->id): echo 'selected'; endif; ?>>
                                                <?php echo e(__(@$templateCategory->label)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="fs-13 mt-1">
                                        <i><?php echo app('translator')->get('Choose the template category supported by the WhatsApp Business API'); ?></i>
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form--label label-two"><?php echo app('translator')->get('Language'); ?></label>
                                    <select class="form--control select2" name="language_id" required>
                                        <?php $__currentLoopData = $templateLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $templateLanguage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e(@$templateLanguage->id); ?>" <?php if($templateLanguage->code == 'en_US'): echo 'selected'; endif; ?>>
                                                <?php echo e(__(@$templateLanguage->country)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <span class="fs-13 mt-1">
                                        <i><?php echo app('translator')->get('Choose the template language supported by the WhatsApp Business API.'); ?></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="auth-devider text-center">
                                            <span> <?php echo app('translator')->get('TEMPLATE HEADER'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="label-two"><?php echo app('translator')->get('Header Type'); ?></label>
                                <select name="header_format" class="form--control select2"
                                    data-minimum-results-for-search="-1">
                                    <?php $__currentLoopData = templateHeaderTypes() ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($label); ?>">
                                            <?php echo e(ucfirst($key)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <option value=""><?php echo app('translator')->get('None'); ?></option>
                                </select>
                            </div>
                            <div class="header-filed"></div>
                        </div>
                        <div class="col-12">
                            <div class="my-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="auth-devider text-center">
                                            <span> <?php echo app('translator')->get('TEMPLATE BODY'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="label-two"><?php echo app('translator')->get('Body Content'); ?></label>
                                <div class="body-content">
                                    <textarea class="form--control form-two markdown-editor" name="template_body" id="template_body" maxlength="1024"
                                        placeholder="<?php echo app('translator')->get('Write your template body...'); ?>" required><?php echo e(old('template_body')); ?></textarea>
                                    <button type="button" class="add-variable body-add-variable" data-bs-toggle="tooltip"
                                        title="<?php echo app('translator')->get('Add Variable'); ?>">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-end fs-12 text-muted">
                                    <span class="character-count">0</span>
                                    <span>/ 1024</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="auth-devider text-center">
                                            <span> <?php echo app('translator')->get('TEMPLATE FOOTER'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="title" class="form--label label-two"><?php echo app('translator')->get('Footer Text'); ?></label>
                                <input type="text" class="form--control form-two" name="footer" maxlength="60"
                                    placeholder="<?php echo app('translator')->get('Enter footer text'); ?>" value="<?php echo e(old('footer')); ?>">
                                <div class="d-flex justify-content-end fs-12 pt-2 text-muted">
                                    <span class="character-count">0</span>
                                    <span>/ 60</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="my-4">
                                <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="auth-devider text-center">
                                            <span> <?php echo app('translator')->get('TEMPLATE BUTTONS'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="button-container form-group"></div>
                            <div class="form-group d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn--template template-add-button btn--base flex-fill"
                                    data-type="PHONE_NUMBER">
                                    <i class="las la-phone"></i>
                                    <?php echo app('translator')->get('CALL PHONE NUMBER'); ?>
                                </button>
                                <button type="button" class="btn btn--template template-add-button flex-fill btn--info"
                                    data-type="URL">
                                    <i class="las la-globe"></i>
                                    <?php echo app('translator')->get('VISIT WEBSITE'); ?>
                                </button>
                                <button type="button" class="btn btn--template template-add-button flex-fill btn--base"
                                    data-type="OTP">
                                    <i class="las la-copy"></i>
                                    <?php echo app('translator')->get('COPY OFFER CODE'); ?></button>
                                <button type="button" class="btn btn--template template-add-button flex-fill btn--info"
                                    data-type="QUICK_REPLY">
                                    <i class="las la-undo"></i>
                                    <?php echo app('translator')->get('QUICK REPLY'); ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="template-info-container__right">
                    <div class="preview-item">
                        <div class="preview-item__header">
                            <h5 class="preview-item__title"><?php echo app('translator')->get('Template Preview'); ?></h5>
                        </div>
                        <div class="preview-item__content FL;E">
                            <div class="preview-item__shape">
                                <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>" alt="image">
                            </div>
                            <div>
                                <div class="card-item">
                                    <div class="card-item__thumb header_media">
                                        <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>"
                                            alt="image">
                                    </div>
                                    <div class="card-item__content">
                                        <p class="card-item__title header_text"><?php echo app('translator')->get('Template Title'); ?></p>
                                        <p class="card-item__desc body_text"><?php echo app('translator')->get('Template body'); ?></p>
                                        <p class="text-wrapper">
                                            <span class="text footer_text"><?php echo app('translator')->get('Footer text'); ?></span>
                                        </p>
                                    </div>
                                </div>
                                <div class="button-preview mt-2 d-flex gap-2 flex-column">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/global/css/select2.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/select2.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/ovo-markdown.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('#template-form').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);
                const $submitBtn = $(".submitBtn");
                const oldHtml = $submitBtn.html();
                $.ajax({
                    url: "<?php echo e(route('user.template.store')); ?>",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    beforeSend: function() {
                        $submitBtn.addClass('disabled').attr("disabled", true).html(`
                            <div class="button-loader d-flex gap-2 flex-wrap align-items-center justify-content-center">
                                <div class="spinner-border"></div><span>Loading...</span>
                            </div>
                        `);
                    },
                    success: function(response) {
                        if (response.status === 'error') {
                            notify('error', response.message);
                            return;
                        }
                        notify(response.status, response.message);
                        setTimeout(() => {
                            window.location.href = "<?php echo e(route('user.template.index')); ?>";
                        }, 500);
                    },
                    complete: function() {
                        $submitBtn.removeClass('disabled').attr("disabled", false).html(oldHtml);
                    }
                });

            });

            const $buttonContainer = $('.button-container');
            const $buttonPrevContainer = $(".button-preview");
            const $templatePreviewWrapper = $(".preview-item");

            const generateHtml = {
                prevButtonHtml: function(btnType, btnText = undefined) {
                    let btnIcon = "";
                    if (btnType == 'QUICK_REPLY') {
                        btnIcon = `<i class="las la-undo"></i>`;
                        btnText = btnText || "Quick Reply Button";
                    } else if (btnType == "PHONE_NUMBER") {
                        btnIcon = `<i class="las la-phone"></i>`;
                        btnText = btnText || "CTA Button";
                    } else if (btnType == 'URL') {
                        btnIcon = `<i class="las la-globe"></i>`;
                        btnText = btnText || "Website Button";
                    } else if (btnType == 'OTP') {
                        btnIcon = `<i class="las la-copy"></i>`;
                        btnText = btnText || "Copy Button";
                    }

                    return `<button type="button" class="btn btn--template bg-white w-100" data-type="${btnType}">
                                ${btnIcon} ${btnText}
                            </button>`
                },

                prevButtonInputHtml: function(buttonType, btnText = null, index = 0) {
                    const length = $buttonContainer.find(`.custom-attribute-wrapper`).length + index;
                    var html = "";
                    if (buttonType == 'QUICK_REPLY') {
                        html = `<div class="custom-attribute-wrapper mb-2">
                        <div class="row align-items-center gy-3 w-100">
                            <div class="col-12">
                                <input type="text" value="${btnText || ''}" name="buttons[${length}][text]" maxlength="25" class="form--control form-two quick-reply button-input-element" placeholder="<?php echo app('translator')->get('Button Text'); ?>" required>
                                <input type="hidden" name="buttons[${length}][type]" value="${buttonType}">
                            </div>
                            </div>
                            <button type="button" class="btn btn--danger remove-attribute">
                                <i class="las la-trash"></i>
                            </button>
                        </div>`;
                    } else if (buttonType == 'PHONE_NUMBER') {
                        html = `<div class="custom-attribute-wrapper mb-2">
                        <div class="row align-items-center gy-3 w-100">
                            <div class="col-lg-6">
                                <input type="text" value="${btnText || ''}" name="buttons[${length}][text]" maxlength="25" class="form--control form-two  button-input-element" placeholder="<?php echo app('translator')->get('Button text'); ?>" required>
                                <input type="hidden" name="buttons[${length}][type]" value="${buttonType}">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" name="buttons[${length}][phone_number]" maxlength="20" class="form--control form-two call-to-number button-input-element" placeholder="<?php echo app('translator')->get('Phone Number with country code'); ?>" required>
                            </div>
                            </div>
                            <button type="button" class="btn btn--danger remove-attribute">
                                <i class="las la-trash"></i>
                            </button>
                        </div>`;
                    } else if (buttonType == 'URL') {
                        html = `<div class="custom-attribute-wrapper mb-2">
                        <div class="row align-items-center gy-3 w-100">
                            <div class="col-lg-6">
                                <input type="text" value="${btnText || ''}" name="buttons[${length}][text]" maxlength="25" class="form--control form-two  button-input-element" placeholder="<?php echo app('translator')->get('Button Text'); ?>" required>
                                <input type="hidden" name="buttons[${length}][type]" value="${buttonType}">
                            </div>
                            <div class="col-lg-6">
                                <input type="url" name="buttons[${length}][url]" maxlength="20000" class="form--control form-two visit-website" placeholder="<?php echo app('translator')->get('Website URL'); ?>" required>
                            </div>
                            </div>
                            <button type="button" class="btn btn--danger remove-attribute">
                                <i class="las la-trash"></i>
                            </button>
                        </div>`;

                    } else if (buttonType == 'OTP') {
                        html = `<div class="custom-attribute-wrapper mb-2">
                        <div class="row align-items-center gy-3 w-100">
                            <div class="col-lg-6">
                                <input type="text" value="${btnText || ''}" name="buttons[${length}][text]" maxlength="25" class="form--control form-two  button-input-element" placeholder="<?php echo app('translator')->get('Button Text'); ?>">
                                <input type="hidden" name="buttons[${length}][type]" value="${buttonType}">
                            </div>
                            <div class="col-lg-6">
                                <select name="buttons[${length}][otp_type]" readonly class="form--control form-two offer-code">
                                    <option value="copy_code" selected><?php echo app('translator')->get('Copy Code'); ?></option>
                                </select>
                            </div>
                            </div>
                            <button type="button" class="btn btn--danger remove-attribute">
                                <i class="las la-trash"></i>
                            </button>
                        </div>`;
                    }

                    return html;
                },
                templateHeaderTypeHtml: function(selectedType) {
                    if (selectedType == 'TEXT') {
                        $('body').find('.header_media').addClass('d-none');
                        $('body').find('.header_text').removeClass('d-none');
                        return `<div class="form-group position-relative">
                        <label class="form--label label-two"><?php echo app('translator')->get('Header Text'); ?></label>
                        <input type="text" class="form--control form-two header-input" name="header[text]" maxlength="1024">
                        <button type="button" class="add-variable header-add-variable"><i class="las la-plus"></i></button>
                        <div class="d-flex justify-content-end fs-12 pt-2 text-muted">
                            <span class="character-count">0</span>
                            <span>/ 1024</span>
                        </div>
                    </div>`;

                    } else {
                        $('body').find('.header_media').removeClass('d-none');
                        $('body').find('.header_text').addClass('d-none');
                        return `<div class="form-group">
                        <label class="form--label label-two"><?php echo app('translator')->get('Upload ${selectedType.charAt(0) + selectedType.slice(1)}'); ?></label>
                        <input type="file" class="form--control form-two" name="header[handle]" accept="${selectedType === 'IMAGE' ? 'image/*' : selectedType === 'VIDEO' ? 'video/*' : 'application/pdf'}">
                    </div>`;

                    }
                }
            }

            $('select[name=header_format]').on('change', function() {
                var selectedType = $(this).val();
                var fieldHtml = generateHtml.templateHeaderTypeHtml(selectedType);
                $('.header-filed').html(fieldHtml);
            }).change();

            $('body').on('input paste', ".header-input", function(e) {
                const text = $(this).val() || "Template Header";
                $templatePreviewWrapper.find('.header_text').text(text);
            }).change();

            $('body').on('input paste', "textarea[name=template_body]", function(e) {
                const text = $(this).val() || "Template Body";
                $templatePreviewWrapper.find('.body_text').html(parseMarkdown(text));
                const matches = text.match(/\{\{\s*(\d+)\s*\}\}/g) || [];
                const uniqueIndexes = [...new Set(matches.map(m => m.match(/\d+/)[0]))];
                regenerateBodyExampleFields(uniqueIndexes.length + 1);
            }).change();

            $('body').on('input paste', "input[name=footer]", function(e) {
                const text = $(this).val() || "Template Footer";
                $templatePreviewWrapper.find('.footer_text').text(text);
            }).change();

            $('.template-add-button').on('click', function() {
                let buttonType = $(this).data('type');
                const limits = {
                    OTP: {
                        selector: '.offer-code',
                        max: 1
                    },
                    QUICK_REPLY: {
                        selector: '.quick-reply',
                        max: 3
                    },
                    PHONE_NUMBER: {
                        selector: '.call-to-number',
                        max: 1
                    },
                    URL: {
                        selector: '.visit-website',
                        max: 2
                    },
                };

                const limit = limits[buttonType];
                if (limit && $(document).find(limit.selector).length >= limit.max) {
                    return;
                }

                let buttonHtml = generateHtml.prevButtonInputHtml(buttonType);
                let previewButtonHtml = generateHtml.prevButtonHtml(buttonType);

                $buttonContainer.append(buttonHtml);
                $buttonPrevContainer.append(previewButtonHtml);
            });

            $buttonContainer.on(`input`, ".button-input-element", function() {
                const index = $(this).closest('.custom-attribute-wrapper').index();
                const text = $(this).val();
                const $btnElement = $(".button-preview").find(`button:nth(${index})`)
                $btnElement.find('span').text(text);
            });

            var bodyVariableCount = 1;
            var headerVariableCount = 1;

            $(document).on('click', '.body-add-variable', function() {
                $('textarea[name=template_body]').val($('textarea[name=template_body]').val() +
                    "\{\{" + bodyVariableCount + "\}\}");
                bodyVariableCount++;
                regenerateBodyExampleFields(bodyVariableCount);
                $('textarea[name=template_body]').focus();
            });

            function regenerateBodyExampleFields(count) {
                $('.body-example-field').remove();

                let html = '';
                for (let i = 1; i < count; i++) {
                    html += `
                        <div class="form-group body-example-field">
                            <label class="form--label label-two">Example for \{\{${i}\}\}</label>
                            <input type="text" class="form--control form-two" name="body[example][body_text][]" placeholder="e.g., John" required>
                        </div>`;
                }
                $('textarea[name="template_body"]').closest('.form-group').after(html);
            }

            $(document).on('click', '.header-add-variable', function() {
                const $input = $('input[name="header[text]"]');

                if ($input.val().includes('<?php echo e(1); ?>')) return;

                $input.val($input.val() + `\{\{1\}\}`);
                $input.focus();

                regenerateHeaderExampleFields();
            });

            function regenerateHeaderExampleFields() {
                const $input = $('input[name="header[text]"]');

                if (!$input.length) return;

                const value = $input.val();
                const hasPlaceholder = value.includes('<?php echo e(1); ?>') || value.includes('<?php echo e(1); ?>');

                const $exampleField = $('.header-example-field');

                if (hasPlaceholder) {
                    if (!$exampleField.length) {
                        const headerExample = `
                        <div class="form-group header-example-field">
                            <label class="form--label label-two"><?php echo app('translator')->get('Example for <?php echo e(1); ?>'); ?></label>
                            <input type="text" class="form--control form-two" name="header[example][header_text][]" placeholder="e.g., John" required>
                        </div>`;
                        $input.closest('.form-group').after(headerExample);
                    }
                } else {
                    $exampleField.remove();
                }
            }

            $(document).on('input', 'input[name="header[example][header_text][]"]', function() {
                let val = $(this).val();
            });

            $('.markdown-editor').initiateMarkdown({
                previewOn: '.body_text',
                position: 'bottom',
                tools: ['bold', 'italic', 'mono', 'strike']
            });

            $(document).on('click', '.remove-attribute', function(e) {
                e.preventDefault();
                const index = $(this).closest('.custom-attribute-wrapper').index();
                $(".button-preview").find(`button:nth(${index})`).remove();
                $(this).parent().remove();
            });

            $('select[name=category_id]').on('change', function() {
                const category = $(this).find('option:selected').data('category');
                appendAuthenticationHtml(category);
            });

            function appendAuthenticationHtml(category) {
                if (category === 'AUTHENTICATION') {
                    let securityHtml = `<div class="form-group">
                            <div class="form--switch two">
                                <input class="form-check-input status-switch" type="checkbox" role="switch" id="add_security_recommendation" name="add_security_recommendation" />
                                <label class="form-check-label" for="add_security_recommendation">
                                    <?php echo app('translator')->get('Add Security Recommendation'); ?>
                                </label>
                            </div>
                        </div>`;
                    let expiryHtml = `<div class="col-12">
                                <div class="form-group">
                                    <label class="form--label label-two"><?php echo app('translator')->get('Code Expires After (Minutes)'); ?></label>
                                    <input type="number" class="form--control form-two" name="code_expiration_minutes" placeholder="Expiry in minutes">
                                    <span class="fs-13 mt-1">
                                        <i><?php echo app('translator')->get('If the user comes online within that time, the message is delivered.'); ?></i>
                                    </span>
                                </div>
                            </div>`;

                    $('input[name="footer"]').closest('.form-group').after(expiryHtml);
                    $('textarea[name="template_body"]').closest('.form-group').after(securityHtml);
                } else {
                    $('input[name="code_expiration_minutes"]').closest('.form-group').remove();
                    $('input[name="add_security_recommendation"]').closest('.form--switch').remove();
                }
            }

            $(document).on('input change', 'input[name="header[handle]"]', function() {
                const fileInput = this;

                if (fileInput.files && fileInput.files[0]) {
                    const file = fileInput.files[0];
                    const fileType = file.type;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        if (fileType.startsWith('image/')) {
                            $('.header_media').html(
                                `<img src="${e.target.result}" alt="Image">`
                            );
                        } else if (fileType.startsWith('video/')) {
                            $('.header_media').html(
                                `<video controls>
                                    <source src="${e.target.result}" type="${fileType}">
                                    Your browser does not support the video tag.
                                </video>`
                            );
                        } else if (fileType === 'application/pdf') {
                            $('.header_media').html(`
                                        <embed class="pdf-embed" src="${e.target.result}" type="application/pdf" width="100%" height="200px" style="border: none">
                                 `);
                        } else {
                            notify('error', "<?php echo app('translator')->get('Please select a valid image, video, or PDF document.'); ?>");
                            $('.header_media').html('');
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('.header_media').html('');
                }
            });

            function updateCharacterCount($input) {
                const count = $input.val().length;
                $input.closest('.form-group').find('.character-count').text(count);
            }

            $(document).on('input paste keyup change',
                'input[name="header[text]"], input[name="footer"], textarea[name="template_body"]',
                function() {
                    updateCharacterCount($(this));
                    regenerateHeaderExampleFields();
                });

            $('input[name="header[text]"], input[name="footer"], textarea[name="template_body"]').each(function() {
                updateCharacterCount($(this));
            });

            $('.pre-made-template').on('change', function(e) {
                const template = $(this).find(`option:selected`).data('template');
                const imageUrl = "<?php echo e(asset($activeTemplateTrue . 'images/watemplate/:imageName')); ?>";
                var prevButtonHtml = "";
                var prevButtonInputHtml = "";
                bodyVariableCount = template.bodyVariableCount;

                $.each(template.button, function(i, button) {
                    prevButtonHtml += generateHtml.prevButtonHtml(button.type, button.label)
                    prevButtonInputHtml += generateHtml.prevButtonInputHtml(button.type, button.label,
                        i)
                });

                $buttonPrevContainer.html(prevButtonHtml);
                $buttonContainer.html(prevButtonInputHtml);

                $(`input[name=name]`).val(template.name);
                $(`select[name=header_format]`).val("IMAGE").change();
                $(`input[name="header[text]"]`).val(template.header).trigger('input');
                $(`textarea[name=template_body]`).val(template.body).trigger('input');
                $(`input[name=footer]`).val(template.footer).trigger('input');
                $(`.card-item__thumb img`).attr('src', imageUrl.replace(':imageName', template.name + ".png"));
                regenerateBodyExampleFields(bodyVariableCount);

            }).change();

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        /* markdown editor */
        .markdown-btn-group button {
            background: #f5f5f5a1;
            border: 1px solid #ccccccb2;
            color: #333;
            padding: 6px 10px;
            margin-right: 6px;
            font-weight: bold;
            font-family: monospace, monospace;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease, border-color 0.2s ease;
            user-select: none;
            min-width: 30px;
            height: 30px;
        }

        .markdown-btn-group button:hover,
        .markdown-btn-group button:focus {
            background-color: #e0e0e0b0;
            border-color: #999999a2;
            outline: none;
        }

        .markdown-btn-group button:active {
            background-color: #d4d4d4;
            border-color: #666;
        }

        .form--control[type=file] {
            line-height: 1 !important;
            padding: 8px 2px !important;
            height: 40px;
        }

        .form--control[type=file]::-webkit-file-upload-button {
            padding: unset !important;
        }

        .form--control[type=file]::file-selector-button {
            padding: unset !important;
        }

        .body-content {
            position: relative;
        }

        .add-variable {
            position: absolute;
            top: 5px;
            right: 5px;
            z-index: 1;
            height: 30px;
            width: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 1px solid #e8e8e8;
            border-radius: 50% !important;
        }

        .dropdown-menu {
            background: hsl(var(--section-bg));
            border-radius: 6px;
            border: 0;
            padding: 0 !important;
            overflow: hidden;
        }

        .dropdown-menu li .dropdown-item {
            color: hsl(var(--black)) !important;
            cursor: pointer;
            margin: 0;
            padding: 8px 14px;
            border-bottom: 1px solid hsl(var(--black)/.1);
            transition: .2s linear;
        }

        .dropdown-menu li:last-child .dropdown-item {
            border-bottom: 0;
        }

        .dropdown-menu li .dropdown-item:hover {
            background-color: hsl(var(--base)/.2);
        }

        .custom-attribute-wrapper {
            display: flex;
            width: 100%;
            gap: 10px;
            align-items: flex-end;
        }

        .template-info-container__right .preview-item__content .card-item {
            width: 100%;
            border-radius: 10px;
        }

        .divider-title::after {
            position: absolute;
            content: '';
            top: 14px;
            right: -40px;
            background: #6b6b6b65;
            height: 2px;
            width: 80px;
        }


        .divider-title::before {
            position: absolute;
            content: '';
            top: 14px;
            left: -40px;
            background: #6b6b6b65;
            height: 2px;
            width: 80px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/core/resources/views/templates/basic/user/template/create.blade.php ENDPATH**/ ?>