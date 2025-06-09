<?php

// نمایش فرم ورود/ثبت‌نام در صفحه اختصاصی
add_action('the_content', 'clp_insert_login_register_form');
function clp_insert_login_register_form($content) {
    $page_id = get_option('clp_login_page_id', '');

    if (!$page_id || !is_page($page_id)) {
        return $content;
    }

    $show_login = get_option('clp_show_login_form', 0);
    $show_register = get_option('clp_show_register_form', 0);
    $recaptcha_key = get_option('clp_recaptcha_site_key', '');
    
    // 🔧 گرفتن redirect_to
    $redirect_to = isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : home_url();

    ob_start();

    // نمایش پیام خصوصی (در صورت وجود redirect_to)
    if (!empty($_GET['redirect_to'])) {
        echo '
        <div class="clp-private-message">
            <h2>این صفحه خصوصی است</h2>
            <br>
            <h4>برای مشاهده آن، وارد حساب کاربری خود شوید.</h4>
        </div>';
    }

    // فقط اگر فرم ورود فعال باشد
    if ($show_login):
        ?>
        <div id="loginform-wrapper" class="clp-login-form">
            <h3><?php _e('ورود', 'custom-login-page'); ?></h3>
            <?php if (isset($_GET['login']) && $_GET['login'] === 'failed'): ?>
                <p class="clp-login-error"><?php _e('نام کاربری یا رمز عبور اشتباه است.', 'custom-login-page'); ?></p>
            <?php endif; ?>

            <form id="loginform" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post" class="clp-ajax-form">
                <?php wp_nonce_field('clp_login_form'); ?>
                <input type="text" name="log" placeholder="<?php _e('نام کاربری', 'custom-login-page'); ?>" required />
                <input type="password" name="pwd" placeholder="<?php _e('رمز عبور', 'custom-login-page'); ?>" required />

                <!-- ✅ redirect_to بدون loop -->
                <input type="hidden" name="redirect_to" value="<?= esc_url($redirect_to); ?>" />

                <label><input name="rememberme" type="checkbox" value="forever" /> <?php _e('مرا بخاطر بسپار', 'custom-login-page'); ?></label>

                <?php if ($recaptcha_key): ?>
                    <div class="g-recaptcha" data-sitekey="<?= esc_attr($recaptcha_key); ?>" data-action="login"></div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                <?php endif; ?>
                <input type="submit" value="<?php _e('ورود', 'custom-login-page'); ?>" />
            </form>

            <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('رمز عبورتان را فراموش کرده‌اید؟', 'custom-login-page'); ?></a>

            <!-- دکمه ثبت‌نام فقط اگر فعال باشد -->
            <?php if ($show_register): ?>
                <p>
                    <input 
                        type="button" 
                        value="<?php _e('ثبت نام', 'custom-login-page'); ?>" 
                        class="clp-register-button"
                        onclick="document.getElementById('loginform-wrapper').style.display='none'; document.getElementById('registerform-wrapper').style.display='block'; return false;"
                    />
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- فقط اگر فرم ثبت‌نام فعال باشد -->
    <?php if ($show_register): ?>
        <div id="registerform-wrapper" class="clp-register-form" style="<?= $show_login ? 'display:none;' : 'display:block;' ?>">
            <h3><?php _e('ثبت‌نام', 'custom-login-page'); ?></h3>
            <form id="registerform" action="" method="post" class="clp-ajax-form">
                <?php wp_nonce_field('clp_register_form'); ?>
                <input type="text" name="first_name" placeholder="<?php _e('نام', 'custom-login-page'); ?>" required />
                <input type="text" name="last_name" placeholder="<?php _e('نام خانوادگی', 'custom-login-page'); ?>" required />
                <input type="text" name="username" placeholder="<?php _e('نام کاربری', 'custom-login-page'); ?>" required />
                <input type="email" name="email" placeholder="<?php _e('ایمیل', 'custom-login-page'); ?>" required />
                <input type="text" name="phone" placeholder="<?php _e('شماره همراه', 'custom-login-page'); ?>" required />
                <input type="password" name="password" placeholder="<?php _e('رمز عبور', 'custom-login-page'); ?>" required />

                <?php if ($recaptcha_key): ?>
                    <div class="g-recaptcha" data-sitekey="<?= esc_attr($recaptcha_key); ?>" data-action="register"></div>
                    <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response-register">
                <?php endif; ?>

                <!-- ✅ redirect_to در فرم ثبت‌نام -->
                <input type="hidden" name="redirect_to" value="<?= esc_url($redirect_to); ?>" />
                <input type="submit" value="<?php _e('ثبت نام', 'custom-login-page'); ?>" />
            </form>

            <?php if ($show_login): ?>
                <p>
                    <input 
                        type="button" 
                        value="<?php _e('بازگشت به ورود', 'custom-login-page'); ?>" 
                        class="clp-back-button"
                        onclick="document.getElementById('registerform-wrapper').style.display='none'; document.getElementById('loginform-wrapper').style.display='block'; return false;"
                    />
                </p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php
    return $content . ob_get_clean();
}