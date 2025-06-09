<?php

// اضافه کردن منوی تنظیمات
function clp_add_admin_menu() {
    add_options_page(
        __('تنظیمات صفحه لاگین دلخواه', 'restricted-pages-and-custom-login'),
        __('صفحه لاگین دلخواه', 'restricted-pages-and-custom-login'),
        'manage_options',
        'custom-login-page',
        'clp_options_page'
    );
}
add_action('admin_menu', 'clp_add_admin_menu');

// ثبت تنظیمات
function clp_register_settings() {
    // --- تنظیمات عمومی ---
    register_setting('clp_options_group', 'clp_login_page_id', 'absint');
    register_setting('clp_options_group', 'clp_enable_protection', 'intval');
    register_setting('clp_options_group', 'clp_show_login_form', 'intval');
    register_setting('clp_options_group', 'clp_show_register_form', 'intval');
    register_setting('clp_options_group', 'clp_send_verification_email', 'intval');
    register_setting('clp_options_group', 'clp_auto_login_after_register', 'intval');
    register_setting('clp_options_group', 'clp_recaptcha_site_key');

    // --- تنظیمات کاربری ---
    register_setting('clp_options_group', 'clp_hide_admin_bar', 'intval');
    register_setting('clp_options_group', 'clp_enable_topbar_profile', 'intval'); 
    register_setting('clp_options_group', 'clp_logout_page_id', 'absint');
    register_setting('clp_options_group', 'clp_profile_page_id', 'absint');
    
    // --- تنظیمات پروفایل کاربری ---
    register_setting('clp_options_group', 'clp_enable_user_profile', 'intval');
    register_setting('clp_options_group', 'clp_default_role', 'sanitize_text_field');

    // --- تنظیمات نقش ویژه ---
    register_setting('clp_options_group', 'clp_enable_special_user_role', 'intval');


    // === سکشن اصلی - صفحه لاگین ===
    add_settings_section(
        'clp_main_section',
        __('انتخاب صفحه لاگین', 'restricted-pages-and-custom-login'),
        null,
        'custom-login-page'
    );

    // صفحه لاگین
    add_settings_field(
        'clp_login_page_id',
        __('صفحه لاگین', 'restricted-pages-and-custom-login'),
        'clp_render_page_selector',
        'custom-login-page',
        'clp_main_section'
    );

    // محافظت از صفحات
    add_settings_field(
        'clp_enable_protection',
        __('محافظت از صفحات خصوصی', 'restricted-pages-and-custom-login'),
        'clp_render_protection_checkbox',
        'custom-login-page',
        'clp_main_section'
    );

    // نمایش فرم ورود
    add_settings_field(
        'clp_show_login_form',
        __('نمایش فرم ورود در صفحه لاگین', 'restricted-pages-and-custom-login'),
        'clp_render_login_checkbox',
        'custom-login-page',
        'clp_main_section'
    );

    // نمایش فرم ثبت‌نام
    add_settings_field(
        'clp_show_register_form',
        __('نمایش فرم ثبت‌نام در صفحه لاگین', 'restricted-pages-and-custom-login'),
        'clp_render_register_checkbox',
        'custom-login-page',
        'clp_main_section'
    );

    // ارسال ایمیل تأیید
    add_settings_field(
        'clp_send_verification_email',
        __('ارسال ایمیل تأیید بعد از ثبت‌نام', 'restricted-pages-and-custom-login'),
        'clp_render_verification_checkbox',
        'custom-login-page',
        'clp_main_section'
    );

    // ورود خودکار
    add_settings_field(
        'clp_auto_login_after_register',
        __('ورود خودکار بعد از ثبت‌نام', 'restricted-pages-and-custom-login'),
        'clp_render_auto_login_checkbox',
        'custom-login-page',
        'clp_main_section'
    );

    // reCAPTCHA Site Key
    add_settings_field(
        'clp_recaptcha_site_key',
        __('reCAPTCHA Site Key', 'restricted-pages-and-custom-login'),
        'clp_render_recaptcha_input',
        'custom-login-page',
        'clp_main_section'
    );


    // === سکشن کاربری ===
    add_settings_section(
        'clp_user_section',
        __('تنظیمات کاربری', 'restricted-pages-and-custom-login'),
        function () {
            echo '<p>' . __('تنظیمات مربوط به نوار ابزار و منوی بالایی کاربری', 'restricted-pages-and-custom-login') . '</p>';
        },
        'custom-login-page'
    );

    // عدم نمایش نوار ابزار
    add_settings_field(
        'clp_hide_admin_bar',
        __('عدم نمایش نوار ابزار وردپرس برای کاربران غیر مدیر', 'restricted-pages-and-custom-login'),
        'clp_render_hide_admin_bar_checkbox',
        'custom-login-page',
        'clp_user_section'
    );

    // نمایش منوی بالایی
    add_settings_field(
        'clp_enable_topbar_profile',
        __('نمایش منوی پروفایل و خروج در نوار بالای صفحه', 'restricted-pages-and-custom-login'),
        'clp_render_topbar_profile_checkbox',
        'custom-login-page',
        'clp_user_section'
    );

    // صفحه ریدایرکت بعد از خروج
    add_settings_field(
        'clp_logout_page_id',
        __('صفحه ریدایرکت بعد از خروج', 'restricted-pages-and-custom-login'),
        'clp_render_logout_page_selector',
        'custom-login-page',
        'clp_user_section'
    );

    // صفحه پروفایل
    add_settings_field(
        'clp_profile_page_id',
        __('انتخاب صفحه پروفایل', 'restricted-pages-and-custom-login'),
        'clp_render_profile_page_selector',
        'custom-login-page',
        'clp_user_section'
    );

    // فعال کردن صفحه پروفایل داخلی
    add_settings_field(
        'clp_enable_user_profile',
        __('فعال کردن صفحه پروفایل داخلی', 'restricted-pages-and-custom-login'),
        'clp_render_user_profile_checkbox',
        'custom-login-page',
        'clp_user_section'
    );


    // === سکشن نقش کاربری پیشفرض ===
    add_settings_section(
        'clp_role_section',
        __('نقش کاربری پیشفرض', 'restricted-pages-and-custom-login'),
        function () {
            echo '<p>' . __('تعیین نقش کاربری برای کاربران جدید', 'restricted-pages-and-custom-login') . '</p>';
        },
        'custom-login-page'
    );

    add_settings_field(
        'clp_default_role',
        __('نقش پیش‌فرض کاربر جدید', 'restricted-pages-and-custom-login'),
        'clp_render_role_dropdown',
        'custom-login-page',
        'clp_role_section'
    );


    // === سکشن نقش ویژه ===
    add_settings_section(
        'clp_special_user_section',
        __('نقش کاربری ویژه', 'restricted-pages-and-custom-login'),
        function () {
            echo '<p>' . __('ایجاد یک نقش کاربری ویژه با دسترسی به صفحات Restricted.', 'restricted-pages-and-custom-login') . '</p>';
            echo '<p><em>' . __('نکته مهم: اگر گزینه "کاربر ویژه" رو غیرفعال کنید یا پلاگین رو دی‌اکتیو کنید، این نقش در دیتابیس باقی می‌ماند. برای حذف آن از دکمه زیر استفاده کنید.', 'restricted-pages-and-custom-login') . '</em></p>';
        },
        'custom-login-page'
    );

    // چک‌باکس نقش ویژه
    add_settings_field(
        'clp_enable_special_user_role',
        __('فعال کردن نقش "کاربر ویژه"', 'restricted-pages-and-custom-login'),
        'clp_render_special_user_role_checkbox',
        'custom-login-page',
        'clp_special_user_section'
    );

    // دکمه حذف نقش ویژه
    add_settings_field(
        'clp_delete_special_user_role',
        __('حذف نقش کاربران ویژه', 'restricted-pages-and-custom-login'),
        'clp_render_delete_special_user_role_button',
        'custom-login-page',
        'clp_special_user_section'
    );
}
add_action('admin_init', 'clp_register_settings');


// ===============
// Render Functions
// ===============

// نمایش لیست صفحات - صفحه لاگین
function clp_render_page_selector() {
    $selected = get_option('clp_login_page_id', '');
    $pages = get_pages();
    echo '<select name="clp_login_page_id">';
    echo '<option value="">-- ' . __('انتخاب کنید', 'restricted-pages-and-custom-login') . ' --</option>';
    foreach ($pages as $page) {
        $selected_attr = ($selected == $page->ID) ? 'selected' : '';
        echo "<option value='{$page->ID}' {$selected_attr}>" . esc_html($page->post_title) . '</option>';
    }
    echo '</select>';
}

// چک‌باکس محافظت از صفحات
function clp_render_protection_checkbox() {
    $enabled = get_option('clp_enable_protection', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_enable_protection" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('فعال کردن محافظت از صفحات با نیاز به لاگین', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// چک‌باکس نمایش فرم ورود
function clp_render_login_checkbox() {
    $enabled = get_option('clp_show_login_form', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_show_login_form" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('نمایش فرم ورود در صفحه لاگین', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// چک‌باکس نمایش فرم ثبت‌نام
function clp_render_register_checkbox() {
    $enabled = get_option('clp_show_register_form', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_show_register_form" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('نمایش فرم ثبت‌نام در صفحه لاگین', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// چک‌باکس ارسال ایمیل تأیید
function clp_render_verification_checkbox() {
    $enabled = get_option('clp_send_verification_email', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_send_verification_email" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('ارسال ایمیل تأیید بعد از ثبت‌نام', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// چک‌باکس ورود خودکار
function clp_render_auto_login_checkbox() {
    $enabled = get_option('clp_auto_login_after_register', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_auto_login_after_register" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('ورود خودکار بعد از ثبت‌نام', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// فیلد reCAPTCHA Site Key
function clp_render_recaptcha_input() {
    $key = get_option('clp_recaptcha_site_key', '');
    ?>
    <input type="text" name="clp_recaptcha_site_key" value="<?= esc_attr($key); ?>" style="width: 100%" />
    <p class="description"><?php _e('اگر reCAPTCHA فعال است، Site Key را اینجا وارد کنید.', 'restricted-pages-and-custom-login'); ?></p>
    <?php
}

// چک‌باکس عدم نمایش نوار ابزار
function clp_render_hide_admin_bar_checkbox() {
    $enabled = get_option('clp_hide_admin_bar', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_hide_admin_bar" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('عدم نمایش نوار ابزار وردپرس برای کاربران غیرمدیر', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// چک‌باکس فعال کردن منوی بالایی
function clp_render_topbar_profile_checkbox() {
    $enabled = get_option('clp_enable_topbar_profile', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_enable_topbar_profile" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('نمایش منوی پروفایل و خروج در نوار بالای صفحه', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// لیست صفحات - صفحه ریدایرکت بعد از خروج
function clp_render_logout_page_selector() {
    $selected = get_option('clp_logout_page_id', '');
    $pages = get_pages();
    echo '<select name="clp_logout_page_id">';
    echo '<option value="">-- ' . __('صفحه پیش‌فرض (همانند home)', 'restricted-pages-and-custom-login') . ' --</option>';
    foreach ($pages as $page) {
        $selected_attr = ($selected == $page->ID) ? 'selected' : '';
        echo "<option value='{$page->ID}' {$selected_attr}>" . esc_html($page->post_title) . '</option>';
    }
    echo '</select>';
}

// لیست صفحات - صفحه پروفایل
function clp_render_profile_page_selector() {
    $selected = get_option('clp_profile_page_id', '');
    $pages = get_pages();
    echo '<select name="clp_profile_page_id">';
    echo '<option value="">-- ' . __('صفحه پیش‌فرض (پروفایل وردپرس)', 'restricted-pages-and-custom-login') . ' --</option>';
    foreach ($pages as $page) {
        $selected_attr = ($selected == $page->ID) ? 'selected' : '';
        echo "<option value='{$page->ID}' {$selected_attr}>" . esc_html($page->post_title) . '</option>';
    }
    echo '</select>';
}

// چک‌باکس فعال کردن صفحه پروفایل داخلی
function clp_render_user_profile_checkbox() {
    $enabled = get_option('clp_enable_user_profile', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_enable_user_profile" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('فعال کردن صفحه پروفایل داخلی', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// لیست نقش‌های کاربری
function clp_render_role_dropdown() {
    global $wp_roles;
    $roles = $wp_roles->get_names();
    $selected = get_option('clp_default_role', 'subscriber');

    echo '<select name="clp_default_role">';
    foreach ($roles as $key => $name) {
        $selected_attr = selected($key, $selected, false);
        echo "<option value='{$key}' {$selected_attr}>" . esc_html($name) . '</option>';
    }
    echo '</select>';
}

// چک‌باکس فعال کردن نقش کاربری ویژه
function clp_render_special_user_role_checkbox() {
    $enabled = get_option('clp_enable_special_user_role', 0);
    ?>
    <label>
        <input type="checkbox" name="clp_enable_special_user_role" value="1" <?= checked(1, $enabled, false); ?> />
        <?php _e('ایجاد نقش "کاربر ویژه" با دسترسی به صفحات محدود شده', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// دکمه حذف نقش ویژه
function clp_render_delete_special_user_role_button() {
    ?>
    <button type="button" class="button button-secondary" id="clp-delete-special-role-button">
        <?php _e('حذف نقش کاربران ویژه و تبدیل به مشترک', 'restricted-pages-and-custom-login'); ?>
    </button>

    <div id="clp-delete-role-result" style="margin-top: 10px;"></div>

    <script>
        jQuery(document).ready(function ($) {
            $('#clp-delete-special-role-button').on('click', function (e) {
                e.preventDefault();
                if (!confirm('<?php _e("آیا از حذف نقش کاربران ویژه و تبدیل آنها به مشترک مطمئن هستید؟", "restricted-pages-and-custom-login"); ?>')) return;

                $.post(ajaxurl, {
                    action: 'clp_delete_special_role_and_convert_users',
                    security: '<?php echo wp_create_nonce("clp_delete_special_role_nonce"); ?>'
                }, function (response) {
                    $('#clp-delete-role-result').html('<div class="notice notice-success is-dismissible"><p>' + response.data.message + '</p></div>');
                }).fail(function (xhr) {
                    $('#clp-delete-role-result').html('<div class="notice notice-error is-dismissible"><p><?php _e('خطا در حذف نقش!', 'restricted-pages-and-custom-login'); ?></p></div>');
                });
            });
        })(jQuery);
    </script>
    <?php
}

// مدیریت نقش وقتی گزینه فعال شد
add_action('admin_init', 'clp_handle_special_user_role');
function clp_handle_special_user_role() {
    $enable_role = get_option('clp_enable_special_user_role', 0);

    if ($enable_role && !get_role('special_user')) {
        add_role('special_user', __('کاربر ویژه', 'restricted-pages-and-custom-login'), [
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'upload_files' => false,
        ]);
    }
}

// AJAX حذف نقش special_user + تبدیل کاربران به subscriber
add_action('wp_ajax_clp_delete_special_role_and_convert_users', 'clp_delete_special_role_and_convert_users');
function clp_delete_special_role_and_convert_users() {
    check_ajax_referer('clp_delete_special_role_nonce', 'security');

    if (!current_user_can('manage_options')) {
        wp_send_json_error(['message' => __('شما دسترسی لازم برای این عملیات را ندارید.', 'restricted-pages-and-custom-login')]);
    }

    if (!get_role('special_user')) {
        wp_send_json_error(['message' => __('نقش کاربر ویژه وجود ندارد.', 'restricted-pages-and-custom-login')]);
    }

    // تبدیل تمام کاربران special_user به subscriber
    $users = get_users(['role' => 'special_user']);
    foreach ($users as $user) {
        $user->set_role('subscriber');
    }

    // حذف نقش special_user
    remove_role('special_user');

    wp_send_json_success(['message' => __('نقش "کاربر ویژه" حذف شد و تمام کاربران به "مشترک" تبدیل شدند.', 'restricted-pages-and-custom-login')]);
}


// صفحه تنظیمات
function clp_options_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('تنظیمات صفحه لاگین دلخواه', 'restricted-pages-and-custom-login'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('clp_options_group');
            do_settings_sections('custom-login-page');
            submit_button();
            ?>
        </form>

        <!-- راهنما در پایین -->
        <div id="clp-guide-bottom" style="margin-top: 40px;">
            <?php clp_render_guide_content(); ?>
        </div>
    </div>
    <?php
}

// راهنما
function clp_render_guide_content() {
    ?>
    <h3><?php _e('راهنمای پلاگین', 'restricted-pages-and-custom-login'); ?></h3>
    <ul>
        <li><strong>صفحه لاگین:</strong> تعیین صفحه‌ای که فرم ورود در آن نمایش داده می‌شود.</li>
        <li><strong>محافظت از صفحات:</strong> اگر فعال باشد، فقط کاربران وارد شده میتونن محتوای صفحه رو ببینن – تو هر صفحه/پست میتونی اون رو فعال کنی.</li>
        <li><strong>نمایش فرم ورود:</strong> اگر فعال باشد، فرم ورود در صفحه لاگین ظاهر میشه.</li>
        <li><strong>نمایش فرم ثبت‌نام:</strong> اگر فعال باشد، فرم ثبت‌نام همراه با ورود نمایش داده میشه.</li>
        <li><strong>ارسال ایمیل تأیید:</strong> اگر فعال باشد، ایمیل تأیید به کاربران جدید فرستاده میشه.</li>
        <li><strong>ورود خودکار:</strong> اگر فعال باشد، کاربر بعد از ثبت‌نام بصورت خودکار وارد میشه.</li>
        <li><strong>reCAPTCHA:</strong> برای مقابله با اسپم، Site Key گوگل رو اینجا بذار.</li>
        <li><strong>عدم نمایش نوار ابزار:</strong> نوار ابزار وردپرس فقط برای مدیران نمایش داده میشه.</li>
        <li><strong>منوی بالایی:</strong> با انتخاب این گزینه، یک نوار بالایی با منوی پروفایل/خروج نمایش داده میشه – فقط برای کاربران غیر مدیر</li>
        <li><strong>صفحه ریدایرکت بعد از خروج:</strong> کاربر بعد از خروج به این صفحه منتقل میشه.</li>
        <li><strong>صفحه پروفایل:</strong> اگر گزینه «نمایش صفحه پروفایل» فعال باشه، کاربران به این صفحه منتقل میشن.</li>
        <li><strong>فعال کردن صفحه پروفایل داخلی:</strong> اگر فعال باشه، فرم پروفایل کاربری درون پلاگین لود میشه.</li>
        <li><strong>نکته مهم:</strong> اگر گزینه «کاربر ویژه» فعال باشه، نقش `special_user` ایجاد میشه – ولی با غیرفعال کردن گزینه، نقش حذف نمیشه.</li>
        <li><strong>استفاده از شورت‌کد:</strong> برای نمایش فرم پروفایل تو یه صفحه اختصاصی، از شورت‌کد زیر استفاده کنید:<br><code>[clp_user_profile]</code></li>
    </ul>
    <?php
}