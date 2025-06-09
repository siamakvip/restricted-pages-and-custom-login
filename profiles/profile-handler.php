<?php

// شورت‌کد فرم پروفایل کاربری
add_shortcode('clp_user_profile', 'clp_render_user_profile_form');
function clp_render_user_profile_form() {
    if (!is_user_logged_in()) {
        return '<p>' . __('برای دسترسی به پروفایل، باید وارد حساب کاربری خود بشوید.', 'restricted-pages-and-custom-login') . '</p>';
    }

    $user = wp_get_current_user();
    $error = '';
    $success = '';

    // --- ذخیره فرم ---
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clp_update_profile_nonce'])) {
        check_admin_referer('clp_update_profile', 'clp_update_profile_nonce');

        // اطلاعات عمومی
        $first_name = sanitize_text_field($_POST['first_name']);
        $last_name = sanitize_text_field($_POST['last_name']);
        $email = sanitize_email($_POST['email']);
        $phone = sanitize_text_field($_POST['phone']);
        $password = $_POST['password'];

        // به‌روزرسانی اطلاعات کاربر
        $user_data = [
            'ID' => $user->ID,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'user_email' => $email
        ];

        $updated = wp_update_user($user_data);

        // به‌روزرسانی موبایل
        if (!empty($phone)) {
            update_user_meta($user->ID, 'clp_user_phone', $phone);
        }

        // به‌روزرسانی رمز
        if (!empty($password)) {
            wp_set_password($password, $user->ID);
            $success = __('رمز عبور شما به‌روز شد.', 'restricted-pages-and-custom-login');
        }

        // آپلود تصویر
        if (!empty($_FILES['profile_picture']['name'])) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');

            $uploaded_image_id = media_handle_upload('profile_picture', 0);
            if (!is_wp_error($uploaded_image_id)) {
                update_user_meta($user->ID, 'clp_profile_picture', $uploaded_image_id);
                $success = __('اطلاعات و تصویر پروفایل شما به‌روز شد.', 'restricted-pages-and-custom-login');
            } else {
                $error = __('خطا در آپلود تصویر.', 'restricted-pages-and-custom-login');
            }
        }

        if (is_wp_error($updated)) {
            $error = __('خطا در به‌روزرسانی اطلاعات.', 'restricted-pages-and-custom-login');
        } elseif (!$error) {
            $success = __('اطلاعات شما به‌روز شد.', 'restricted-pages-and-custom-login');
        }
    }

    // دریافت اطلاعات فعلی کاربر
    $phone = get_user_meta($user->ID, 'clp_user_phone', true);
    $image_id = get_user_meta($user->ID, 'clp_profile_picture', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : false;
    ?>
    <div class="clp-user-profile-form-wrapper">
        <?php if ($error): ?>
            <div class="notice notice-error is-dismissible">
                <p><?= esc_html($error); ?></p>
            </div>
        <?php elseif ($success): ?>
            <div class="notice notice-success is-dismissible">
                <p><?= esc_html($success); ?></p>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="clp-user-profile-form">
            <?php wp_nonce_field('clp_update_profile', 'clp_update_profile_nonce'); ?>
            
            <!-- تصویر پروفایل -->
            <table class="form-table">
                <tr>
                    <th><label><?php _e('تصویر پروفایل', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td>
                        <?php if ($image_url): ?>
                            <img src="<?= esc_url($image_url); ?>" alt="<?php _e('تصویر پروفایل', 'restricted-pages-and-custom-login'); ?>" style="max-width: 100px; border-radius: 50%; margin-bottom: 10px;" />
                            <br>
                        <?php endif; ?>
                        <input type="file" name="profile_picture" accept="image/*" />
                    </td>
                </tr>

                <!-- نام -->
                <tr>
                    <th><label for="first_name"><?php _e('نام', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td><input type="text" name="first_name" id="first_name" value="<?= esc_attr($user->first_name); ?>" class="regular-text" /></td>
                </tr>

                <!-- نام خانوادگی -->
                <tr>
                    <th><label for="last_name"><?php _e('نام خانوادگی', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td><input type="text" name="last_name" id="last_name" value="<?= esc_attr($user->last_name); ?>" class="regular-text" /></td>
                </tr>

                <!-- ایمیل -->
                <tr>
                    <th><label for="email"><?php _e('ایمیل', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td><input type="email" name="email" id="email" value="<?= esc_attr($user->user_email); ?>" class="regular-text" /></td>
                </tr>

                <!-- موبایل -->
                <tr>
                    <th><label for="phone"><?php _e('شماره همراه', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td><input type="text" name="phone" id="phone" value="<?= esc_attr(get_user_meta($user->ID, 'clp_user_phone', true)); ?>" class="regular-text" /></td>
                </tr>

                <!-- رمز عبور -->
                <tr>
                    <th><label for="password"><?php _e('رمز عبور جدید', 'restricted-pages-and-custom-login'); ?></label></th>
                    <td><input type="password" name="password" id="password" class="regular-text" /></td>
                </tr>

                <!-- دکمه ثبت -->
                <tr>
                    <td colspan="2">
                        <input type="submit" value="<?php _e('به‌روزرسانی پروفایل', 'restricted-pages-and-custom-login'); ?>" class="button button-primary" />
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <?php
}