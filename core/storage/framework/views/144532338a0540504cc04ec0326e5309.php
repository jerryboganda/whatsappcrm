<header class="header" id="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand logo" href="<?php echo e(route('home')); ?>">
                <img src="<?php echo e(siteLogo('dark')); ?>" alt="Image">
            </a>
            <button class="navbar-toggler header-button" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span id="hiddenNav"><i class="las la-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav nav-menu me-auto align-items-lg-center">
                    <li class="nav-item <?php echo e(menuActive('home')); ?> d-block d-lg-none">
                        <div class="top-button d-flex flex-wrap justify-content-between align-items-center">
                            <div class="d-flex flex-wrap align-items-center gap-2">
                                <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('user.logout')); ?>" class="btn btn--danger"><?php echo app('translator')->get('Logout'); ?></a>
                                    <a href="<?php echo e(route('user.home')); ?>" class="btn btn--base"><?php echo app('translator')->get('Dashboard'); ?></a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('user.login')); ?>" class="btn btn--base-two"><?php echo app('translator')->get('Login'); ?></a>
                                    <a href="<?php echo e(route('user.register')); ?>" class="btn btn--base"><?php echo app('translator')->get('Create Free Account'); ?></a>
                                <?php endif; ?>

                            </div>
                            <?php if(gs('multi_language')): ?>
                                <div class="custom--dropdown language--dropdown">
                                    <div class="custom--dropdown__selected dropdown-list__item">
                                        <div class="icon">
                                            <img src="<?php echo e(getCurrentLangImage()); ?>" alt="image">
                                        </div>
                                        <span class="text"><?php echo e(strtoupper(getCurrentLang())); ?></span>
                                    </div>
                                    <ul class="dropdown-list">
                                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="dropdown-list__item langSel" data-value="<?php echo e($language->code); ?>">
                                                <a href="#" class="thumb">
                                                    <img src="<?php echo e($language->image_src); ?>" alt="image">
                                                </a>
                                                <span class="text"><?php echo e(strtoupper($language->code)); ?></span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('home')); ?>">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>"><?php echo app('translator')->get('Home'); ?></a>
                    </li>

                    <li class="nav-item <?php echo e(menuActive('features')); ?>">
                        <a class="nav-link" href="<?php echo e(route('features')); ?>"><?php echo app('translator')->get('Features'); ?></a>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('pricing')); ?>">
                        <a class="nav-link" href="<?php echo e(route('pricing')); ?>"><?php echo app('translator')->get('Pricing'); ?></a>
                    </li>
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('pages', $page->slug)); ?>">
                                <?php echo e(__($page->name)); ?>

                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item <?php echo e(menuActive(['blogs', 'blog.details'])); ?>">
                        <a class="nav-link" href="<?php echo e(route('blogs')); ?>"><?php echo app('translator')->get('Blog'); ?></a>
                    </li>
                    <li class="nav-item <?php echo e(menuActive('contact')); ?>">
                        <a class="nav-link" href="<?php echo e(route('contact')); ?>"><?php echo app('translator')->get('Contact'); ?></a>
                    </li>
                </ul>
                <div class="nav-item d-lg-block d-none ms-auto">
                    <div class="top-button d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('user.home')); ?>" class="btn btn--base"><?php echo app('translator')->get('Dashboard'); ?></a>
                            <?php else: ?>
                                <a href="<?php echo e(route('user.login')); ?>" class="btn btn--base-two"><?php echo app('translator')->get('Login'); ?></a>
                                <a href="<?php echo e(route('user.register')); ?>" class="btn btn--base"><?php echo app('translator')->get('Create Free Account'); ?></a>
                            <?php endif; ?>
                        </div>
                        <?php if(gs('multi_language')): ?>
                            <div class="custom--dropdown language--dropdown">
                                <div class="custom--dropdown__selected dropdown-list__item">
                                    <div class="icon">
                                        <img src="<?php echo e(getCurrentLangImage()); ?>" alt="image">
                                    </div>
                                    <span class="text"><?php echo e(strtoupper(getCurrentLang())); ?></span>
                                </div>
                                <ul class="dropdown-list">
                                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dropdown-list__item langSel" data-value="<?php echo e($language->code); ?>">
                                            <a href="#" class="thumb">
                                                <img src="<?php echo e($language->image_src); ?>" alt="image">
                                            </a>
                                            <span class="text"><?php echo e(strtoupper($language->code)); ?></span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
<?php /**PATH C:\laragon\www\whatsapp_crm\core\resources\views/templates/basic/partials/header.blade.php ENDPATH**/ ?>