<?php
    $socialCredentials = gs('socialite_credentials');
?>
<?php if(
    @$socialCredentials->linkedin->status ||
        @$socialCredentials->facebook->status == Status::ENABLE ||
        @$socialCredentials->google->status == Status::ENABLE): ?>
    <div class="col-sm-12">
        <div class="social-link-wrapper">
            <?php if(request()->routeIs('user.login')): ?>
                <p class="text"><?php echo app('translator')->get('OR USE YOUR SOCIAL ACCOUNT TO LOGIN'); ?></p>
            <?php else: ?>
                <p class="text"><?php echo app('translator')->get('OR USE YOUR SOCIAL ACCOUNT TO REGISTER'); ?></p>
            <?php endif; ?>
            <ul class="social-link-list  mb-3">
                <?php if(@$socialCredentials->google->status == Status::ENABLE): ?>
                    <li>
                        <a href="<?php echo e(route('user.social.login', 'google')); ?>" class="social-btn-link google">
                            <i class="fab fa-google"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(@$socialCredentials->facebook->status == Status::ENABLE): ?>
                    <li>
                        <a href="<?php echo e(route('user.social.login', 'facebook')); ?>" class="social-btn-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if(@$socialCredentials->linkedin->status == Status::ENABLE): ?>
                    <li>
                        <a href="<?php echo e(route('user.social.login', 'linkedin')); ?>" class="social-btn-link linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/partials/social_login.blade.php ENDPATH**/ ?>