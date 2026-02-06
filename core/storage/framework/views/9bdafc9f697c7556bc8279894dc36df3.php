<?php $__env->startSection('content'); ?>
    <div class="alert alert--info alert-dismissible mb-3 template-requirements" role="alert">
        <div class="alert__content">
            <h4 class="alert__title"><i class="las la-info-circle"></i> <?php echo app('translator')->get('Template Information'); ?></h4>
            <ul class="ms-4">
                <li class="mb-0 text-dark"><?php echo app('translator')->get('Each carousel template is limited to a minimum 2 and maximum of 10 cards.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('The template body can contain maximum of 1024 characters.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('You can submit a maximum of 100 templates per hour.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('All carousel cards should have at least one button.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('Each carousel card is limited to a maximum of two buttons, which can be categorized as Quick Reply, URL, or Phone Number.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('Carousel cards with different button combinations not supported.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('The body text of carousel cards are optional.It can contain maximum of 160 characters.'); ?></li>
                <li class="mb-0 text-dark"><?php echo app('translator')->get('The media is not editable, please upload your product image/video for carousel cards.'); ?></li>
            </ul>
        </div>
    </div>
    <div class="dashboard-container">
        <div class="container-top">
            <div class="container-top__left">
                <h5 class="container-top__title"><?php echo e(__(@$pageTitle)); ?></h5>
                <p class="container-top__desc"><?php echo app('translator')->get('Easily create carousel templates with multiple products cards for better marketing.'); ?></p>
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
                    <form action="<?php echo e(route('user.template.create.carousel.store')); ?>" method="POST" id="template-form"
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
                                    <label class="label-two"><?php echo app('translator')->get('Template Name'); ?></label>
                                    <input type="text" class="form--control form-two" name="name"
                                        placeholder="<?php echo app('translator')->get('Enter a unique name for this template'); ?>" value="<?php echo e(old('name')); ?>" required>
                                </div>
                            </div>
                            <div class="col-md-12">
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
                                            <span><?php echo app('translator')->get('CAROUSEL CARDS'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn--base add-card-button mb-2">
                                <i class="las la-plus"></i>
                                <?php echo app('translator')->get('Add Card'); ?>
                            </button>
                        </div>

                        <div id="cards-wrapper">

                            <div class="card-block mb-4 p-3 border rounded carousel--card" data-card-index="0">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Card 1</h5>
                                    <button class="btn btn--danger btn--sm remove-card-button">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Header Format'); ?></label>
                                    <select name="cards[0][header_format]" class="form--control header-format"
                                        data-card-index="0">
                                        <option value="IMAGE" selected><?php echo app('translator')->get('Image'); ?></option>
                                        <option value="VIDEO"><?php echo app('translator')->get('Video'); ?></option>
                                    </select>
                                </div>

                                <div class="header-field" data-card-index="0"></div>

                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Body Text'); ?></label>
                                    <div class="body-content">
                                        <textarea class="form--control form-two card-body" name="cards[0][body]" id="cards[0][body]" maxlength="160"
                                            placeholder="<?php echo app('translator')->get('Write your card body...'); ?>"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end fs-12 text-muted">
                                        <span class="character-count">0</span>
                                        <span>/ 160</span>
                                    </div>
                                </div>

                                <div class="buttons-wrapper">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="text-dark text--bold"><?php echo app('translator')->get('Buttons'); ?></div>
                                        <div class="dropdown">
                                            <button class="btn btn--base btn--sm dropdown-toggle" type="button"
                                                id="buttonDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="las la-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="buttonDropdown">
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="QUICK_REPLY"><?php echo app('translator')->get('Quick Reply'); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="URL"><?php echo app('translator')->get('URL'); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="PHONE_NUMBER"><?php echo app('translator')->get('Phone Number'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="custom-attribute-wrapper mb-2">
                                        <div class="row align-items-center gy-3 w-100">
                                            <div class="col-12">
                                                <input type="text" name="cards[0][buttons][0][text]" maxlength="25"
                                                    class="form--control form-two quick-reply button-input-element"
                                                    placeholder="<?php echo app('translator')->get('Quick Reply Text'); ?>" required>
                                                <input type="hidden" name="cards[0][buttons][0][type]"
                                                    value="QUICK_REPLY">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn--danger remove-attribute">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-block mb-4 p-3 border rounded carousel--card" data-card-index="1">

                                <div class="d-flex align-items-center justify-content-between">
                                    <h5>Card 2</h5>
                                    <button class="btn btn--danger btn--sm remove-card-button">
                                        <i class="las la-times"></i>
                                    </button>
                                </div>

                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Header Format'); ?></label>
                                    <select name="cards[1][header_format]" class="form--control header-format"
                                        data-card-index="1">
                                        <option value="IMAGE" selected><?php echo app('translator')->get('Image'); ?></option>
                                        <option value="VIDEO"><?php echo app('translator')->get('Video'); ?></option>
                                    </select>
                                </div>

                                <div class="header-field" data-card-index="1"></div>

                                <div class="form-group">
                                    <label class="label-two"><?php echo app('translator')->get('Body Text'); ?></label>
                                    <div class="body-content">
                                        <textarea class="form--control form-two card-body" name="cards[1][body]" maxlength="160"
                                            placeholder="<?php echo app('translator')->get('Write your card body...'); ?>"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end fs-12 text-muted">
                                        <span class="character-count">0</span>
                                        <span>/ 160</span>
                                    </div>
                                </div>

                                <div class="buttons-wrapper">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="text-dark text--bold"><?php echo app('translator')->get('Buttons'); ?></div>
                                        <div class="dropdown">
                                            <button class="btn btn--base btn--sm dropdown-toggle" type="button"
                                                id="buttonDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="las la-plus"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="buttonDropdown">
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="QUICK_REPLY"><?php echo app('translator')->get('Quick Reply'); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="URL"><?php echo app('translator')->get('URL'); ?></a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item card-button-add"
                                                        data-type="PHONE_NUMBER"><?php echo app('translator')->get('Phone Number'); ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="custom-attribute-wrapper mb-2">
                                        <div class="row align-items-center gy-3 w-100">
                                            <div class="col-12">
                                                <input type="text" name="cards[1][buttons][0][text]" maxlength="25"
                                                    class="form--control form-two quick-reply button-input-element"
                                                    placeholder="<?php echo app('translator')->get('Quick Reply Text'); ?>" required>
                                                <input type="hidden" name="cards[1][buttons][0][type]"
                                                    value="QUICK_REPLY">
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn--danger remove-attribute">
                                            <i class="las la-trash"></i>
                                        </button>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </form>
                </div>

                <div class="template-info-container__right">
                    <div class="preview-item">
                        <div class="preview-item__header">
                            <h5 class="preview-item__title"><?php echo app('translator')->get('Template Preview'); ?></h5>
                        </div>
                        <div class="preview-item__content">
                            <div class="preview-item__shape">
                                <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>" alt="image">
                            </div>
                            <div class="preview-item__body">
                                <div class="card-item">
                                    <div class="card-item__content">
                                        <p class="card-item__desc body_text"><?php echo app('translator')->get('Template body'); ?></p>
                                    </div>
                                </div>
                                <div class="carousel-cards overflow-auto mt-1 d-flex gap-2 align-items-center">
                                    <div class="card-item col-12" data-card-index="0">
                                        <div class="card-item__thumb header_media">
                                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>"
                                                alt="image">
                                        </div>
                                        <div class="card-body-text">

                                        </div>
                                        <div class="button-preview mt-2 d-flex gap-2 flex-column">
                                            <button type="button" class="btn btn--template bg-white w-100"
                                                data-type="QUICK_REPLY">
                                                <i class="las la-reply"></i> <span
                                                    class="text"><?php echo app('translator')->get('Quick Reply'); ?></span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-item col-12" data-card-index="1">
                                        <div class="card-item__thumb header_media">
                                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>"
                                                alt="image">
                                        </div>
                                        <div class="card-body-text">

                                        </div>
                                        <div class="button-preview mt-2 d-flex gap-2 flex-column">
                                            <button type="button" class="btn btn--template bg-white w-100"
                                                data-type="QUICK_REPLY">
                                                <i class="las la-reply"></i> <span
                                                    class="text"><?php echo app('translator')->get('Quick Reply'); ?></span>
                                            </button>
                                        </div>
                                    </div>
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
                    url: "<?php echo e(route('user.template.create.carousel.store')); ?>",
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

            const $buttonPrevContainer = $(".button-preview");
            const $templatePreviewWrapper = $(".preview-item");

            const generateHtml = {
                templateHeaderTypeHtml: function(selectedType, cardIndex) {
                    if (selectedType === 'IMAGE') {
                        return `<div class="form-group">
                            <label class="form--label label-two"><?php echo app('translator')->get('Upload Image'); ?></label>
                            <input type="file" class="form--control form-two card-image-input" data-card-index="${cardIndex}"
                                name="cards[${cardIndex}][header][handle]" accept="image/*">
                        </div>`;
                    } else {
                        return `<div class="form-group">
                            <label class="form--label label-two"><?php echo app('translator')->get('Upload Video'); ?></label>
                            <input type="file" class="form--control form-two card-image-input" data-card-index="${cardIndex}"
                                name="cards[${cardIndex}][header][handle]" accept="video/*">
                        </div>`;
                    }
                },
                buttonHtml: function(btnType, btnText = undefined) {
                    let btnIcon = "";
                    if (btnType == 'QUICK_REPLY') {
                        btnIcon = `<i class="las la-undo"></i>`;
                        btnText = btnText || "Quick Reply";
                    } else if (btnType == "PHONE_NUMBER") {
                        btnIcon = `<i class="las la-phone"></i>`;
                        btnText = btnText || "Call Us";
                    } else {
                        btnIcon = `<i class="las la-globe"></i>`;
                        btnText = btnText || "Visit Us";
                    }
                    return `<button type="button" class="btn btn--template bg-white w-100" data-type="${btnType}">
                                ${btnIcon}
                                <span class="text">${btnText}</span>
                            </button>`
                }
            }

            $('body').on('input', '.button-input-element', function() {
                let value = $(this).val();
                let cardIndex = $(this).closest('.carousel--card').data('card-index');
                let type = $(this).siblings('input').val();
                let selector = $('.carousel-cards').find(`.card-item[data-card-index="${cardIndex}"]`)
                    .find('.button-preview').find(`button[data-type="${type}"]`).find('.text').text(value);
            });

            $(document).on('click', '.add-card-button', function(e) {
                e.preventDefault();

                let count = $('#cards-wrapper .card-block').length;

                if (count >= 10) {
                    notify('error', "<?php echo app('translator')->get('Maximum 10 carousel cards are allowed'); ?>");
                    return;
                }

                let newIndex = count;

                let $clone = $('#cards-wrapper .card-block:first').clone();

                $clone.find('[name]').each(function() {
                    let name = $(this).attr('name');

                    if (name) {
                        let updated = name.replace(/cards\[\d+\]/, 'cards[' + newIndex + ']');
                        $(this).attr('name', updated);
                    }
                });

                $clone.find('input').each(function() {
                    let id = $(this).attr('id');

                    if (id) {
                        let updated = id.replace(/cards\[\d+\]/, 'cards[' + newIndex + ']');
                        $(this).attr('id', updated);
                    }
                });

                $clone.find('label').each(function() {
                    let forAttr = $(this).attr('for');

                    if (forAttr) {
                        let updated = forAttr.replace(/cards\[\d+\]/, 'cards[' + newIndex + ']');
                        $(this).attr('for', updated);
                    }
                });

                $clone.find('textarea').each(function() {
                    let id = $(this).attr('id');

                    if (id) {
                        let updated = id.replace(/cards\[\d+\]/, 'cards[' + newIndex + ']');
                        $(this).attr('id', updated);
                    }
                });

                $clone.attr('data-card-index', newIndex);
                $clone.find('[data-card-index]').each(function() {
                    $(this).attr('data-card-index', newIndex);
                });

                $clone.find('h5').text('Card ' + (newIndex + 1));

                $clone.find('input[type=text], input[type=url], input[type=file]').val('');
                $clone.find('textarea').val('');
                $clone.find('select').prop('selectedIndex', 0);

                $('#cards-wrapper').append($clone);

                $clone.find('.header-format').trigger('change');

                addPreviewCard(newIndex);
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 'slow');

            });

            function addPreviewCard(index) {
                const $carousel = $('.carousel-cards');

                let newCard = `
                    <div class="card-item col-12" data-card-index="${index}">
                        <div class="card-item__thumb header_media">
                            <img src="<?php echo e(getImage($activeTemplateTrue . 'images/preview-1.png')); ?>" alt="image">
                        </div>
                        <div class="card-body-text">
                        </div>
                        <div class="button-preview mt-2 d-flex gap-2 flex-column">
                            <button type="button" class="btn btn--template bg-white w-100" data-type="QUICK_REPLY">
                                <i class="las la-reply"></i> <span class="text">Quick Reply</span>
                            </button>
                            <button type="button" class="btn btn--template bg-white w-100" data-type="URL">
                                <i class="la la-external-link-alt"></i> <span class="text">Shop</span>
                            </button>
                        </div>
                    </div>
                `;

                $carousel.append(newCard);
            }


            $(document).on('change', '.header-format', function() {
                var selectedType = $(this).val();
                var cardIndex = $(this).data('card-index');
                var fieldHtml = generateHtml.templateHeaderTypeHtml(selectedType, cardIndex);
                $('.header-field[data-card-index="' + cardIndex + '"]').html(fieldHtml);
            }).change();

            function triggerHeaderFormatChange() {
                $('.header-format').each(function() {
                    $(this).trigger('change');
                });
            }

            triggerHeaderFormatChange();

            $('body').on('input paste', "textarea[name=template_body]", function(e) {
                const text = $(this).val() || "Template Body";
                $templatePreviewWrapper.find('.body_text').html(text);
            }).change();

            var bodyVariableCount = 1;

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

            $(document).on('input', 'input[name="header[example][header_text][]"]', function() {
                let val = $(this).val();
            });

            $(document).on('change', '.card-image-input', function() {
                
                const fileInput = this;
                const cardIndex = $(this).data('card-index');
                const mediaSelector = $('.carousel-cards').find(
                        `.card-item[data-card-index="${cardIndex}"]`)
                    .find('.header_media');

                if (fileInput.files && fileInput.files[0]) {
                    const file = fileInput.files[0];
                    const fileType = file.type;

                    const reader = new FileReader();

                    reader.onload = function(e) {
                        if (fileType.startsWith('image/')) {
                            mediaSelector.html(`<img src="${e.target.result}" alt="Image">`);
                        } else if (fileType.startsWith('video/')) {
                            mediaSelector.html(
                                `<video controls>
                                    <source src="${e.target.result}" type="${fileType}">
                                    Your browser does not support the video tag.
                                </video>`
                            );
                        } else {
                            notify('error', "<?php echo app('translator')->get('Please select a valid image, video.'); ?>");
                            mediaSelector.html('');
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    mediaSelector.html('');
                }
            });

            function updateCharacterCount($input) {
                const count = $input.val().length;
                $input.closest('.form-group').find('.character-count').text(count);
            }

            $(document).on('input paste keyup change', '.card-body', function() {
                updateCharacterCount($(this));
                let index = $(this).closest('.carousel--card').data('card-index');
                let text = $(this).val();
                updateCardBody(text, index);
            });

            function updateCardBody(text, cardIndex) {
                const $cardBodyContainer = $(
                    `.carousel-cards .card-item[data-card-index="${cardIndex}"] .card-body-text`);
                if (text.length > 0) {
                    $cardBodyContainer.html(`<p class="text py-2">${text}</p>`);
                } else {
                    $cardBodyContainer.html('');
                }
            }

            $(document).on('input paste keyup change', 'textarea[name="template_body"]',
                function() {
                    const text = $(this).val() || "Template Body";
                    $templatePreviewWrapper.find('.body_text').html(parseMarkdown(text));
                    const matches = text.match(/\{\{\s*(\d+)\s*\}\}/g) || [];
                    const uniqueIndexes = [...new Set(matches.map(m => m.match(/\d+/)[0]))];
                    regenerateBodyExampleFields(uniqueIndexes.length + 1);
                    updateCharacterCount($(this));
                });

            $(document).on('click', '.remove-card-button', function(e) {
                e.preventDefault();

                let index = $(this).closest('.carousel--card').data('card-index');
                let previewCard = $('.preview-item__body').find(`.card-item[data-card-index="${index}"]`);
                let count = $('body .carousel--card').length;

                if (count == 2) {
                    notify('error', "<?php echo app('translator')->get('Minimum 2 carousel cards are required'); ?>");
                    return;
                }
                $(this).closest('.carousel--card').remove();
                previewCard.remove();
            });

            $(document).on('click', '.card-button-add', function(e) {
                e.preventDefault();
                const $card = $(this).closest('.carousel--card');
                const type = $(this).data('type');
                const index = $card.find('.buttons-wrapper .custom-attribute-wrapper').length;
                const cardIndex = $card.data('card-index');

                if (index >= 2) {
                    notify('error', "<?php echo app('translator')->get('Maximum 2 buttons are allowed per card'); ?>");
                    return;
                }

                $card.find('.buttons-wrapper').append(generateButtonHtml(type, index, cardIndex));
                const $buttonContainer = $(
                    `.carousel-cards .card-item[data-card-index="${cardIndex}"] .button-preview`);
                $buttonContainer.append(generateHtml.buttonHtml(type));
            });

            function generateButtonHtml(type, index, cardIndex) {
                let html = '';
                let baseName = `cards[${cardIndex}][buttons][${index}]`;
                if (type == 'QUICK_REPLY') {
                    html = `<div class="custom-attribute-wrapper mb-2">
                                <div class="row align-items-center gy-3 w-100">
                                    <div class="col-12">
                                        <input type="text" name="${baseName}[text]" maxlength="25"
                                            class="form--control form-two quick-reply button-input-element"
                                            placeholder="<?php echo app('translator')->get('Quick Reply Text'); ?>" required>
                                        <input type="hidden" name="${baseName}[type]"
                                            value="QUICK_REPLY">
                                    </div>
                                </div>
                                <button type="button" class="btn btn--danger remove-attribute">
                                    <i class="las la-trash"></i>
                                </button>
                            </div>`;
                } else if (type == 'URL') {
                    html = `<div class="custom-attribute-wrapper mb-2">
                                <div class="row align-items-center gy-3 w-100">
                                    <div class="col-lg-6">
                                        <input type="text" name="${baseName}[text]" maxlength="25"
                                            class="form--control form-two  button-input-element"
                                            placeholder="<?php echo app('translator')->get('Button Text'); ?>" required>
                                        <input type="hidden" name="${baseName}[type]" value="URL">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="url" name="${baseName}[url]" maxlength="20000"
                                            class="form--control form-two visit-website"
                                            placeholder="<?php echo app('translator')->get('Enter valid URL'); ?>" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn--danger remove-attribute">
                                    <i class="las la-trash"></i>
                                </button>
                            </div>`;
                } else if (type == 'PHONE_NUMBER') {
                    html = `<div class="custom-attribute-wrapper mb-2">
                                <div class="row align-items-center gy-3 w-100">
                                    <div class="col-lg-6">
                                        <input type="text" name="${baseName}[text]" maxlength="25"
                                            class="form--control form-two  button-input-element"
                                            placeholder="<?php echo app('translator')->get('Button Text'); ?>" required>
                                        <input type="hidden" name="${baseName}[type]" value="PHONE_NUMBER">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="${baseName}[phone_number]" maxlength="20"
                                            class="form--control form-two call-to-number button-input-element"
                                            placeholder="<?php echo app('translator')->get('Phone Number with country code'); ?>" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn--danger remove-attribute">
                                    <i class="las la-trash"></i>
                                </button>
                            </div>`;
                }

                return html;
            }

            $(document).on('click', '.remove-attribute', function(e) {
                e.preventDefault();

                const $wrapper = $(this).closest('.custom-attribute-wrapper');
                const cardIndex = $wrapper.closest('[data-card-index]').data('card-index');

                const buttonIndex = $wrapper.parent().find('.custom-attribute-wrapper').index($wrapper);

                $wrapper.remove();

                const $buttonPrevContainer = $(
                    `.carousel-cards .card-item[data-card-index="${cardIndex}"] .button-preview`);
                $buttonPrevContainer.find('button').eq(buttonIndex).remove();
            });


        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
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

        .preview-item {
            position: sticky;
            top: 0;
            z-index: 1;
            right: 0;
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

        .template-info-container__right .preview-item__content .card-item__thumb img {
            max-height: 210px
        }

        .custom-attribute-wrapper {
            display: flex;
            width: 100%;
            gap: 10px;
            align-items: flex-end;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/user/template/create_carousel.blade.php ENDPATH**/ ?>