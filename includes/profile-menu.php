<?php

// غیرفعال کردن نوار ابزار برای کاربران غیر از مدیر
add_action('after_setup_theme', 'clp_disable_admin_bar_for_non_admins');
function clp_disable_admin_bar_for_non_admins() {
    if (get_option('clp_hide_admin_bar', 0) && !current_user_can('manage_options')) {
        show_admin_bar(false);
    }
}

// نمایش منوی بالایی فقط برای کاربران غیر از مدیر و لاگین‌کرده
add_action('wp_body_open', 'clp_render_topbar_profile_menu');
function clp_render_topbar_profile_menu() {
    if (!is_user_logged_in()) return;
    if (!get_option('clp_enable_topbar_profile', 0)) return;

    $user = wp_get_current_user();

    // فقط کاربران غیر از مدیر
    if (in_array('administrator', $user->roles)) return;

    $profile_page_id = get_option('clp_profile_page_id');
    $profile_url = $profile_page_id ? get_permalink($profile_page_id) : admin_url('profile.php');
    $logout_url = home_url('/logout/');
    
    $image_id = get_user_meta($user->ID, 'clp_profile_picture', true);
    $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'thumbnail') : false;

    // اگر تصویر وجود نداشت، از Gravatar استفاده کن
    if (!$image_url) {
        $image_url = get_avatar_url($user->user_email, ['size' => 64]);
    }
    ?>
    <div class="clp-topbar-profile">
        <div class="clp-topbar-container">
            <span class="clp-user-name">
                <img src="<?= esc_url($image_url); ?>" width="32" height="32" style="border-radius: 50%;" />
                <?= esc_html($user->display_name); ?>
            </span>
            <ul class="clp-profile-dropdown">
                <li><a href="<?= esc_url($profile_url); ?>"><?php _e('پروفایل شما', 'restricted-pages-and-custom-login'); ?></a></li>
                <li><a href="<?= esc_url($logout_url); ?>"><?php _e('خروج از حساب', 'restricted-pages-and-custom-login'); ?></a></li>
            </ul>
        </div>
    </div>
    <?php
}

// استایل منوی بالایی
add_action('wp_head', 'clp_add_custom_topbar_style');
function clp_add_custom_topbar_style() {
    if (!get_option('clp_enable_topbar_profile', 0)) return;

    $height = get_theme_mod('clp_topbar_height', 40);
    $padding = get_theme_mod('clp_topbar_padding', 10);
    $bg_color = get_theme_mod('clp_topbar_bg_color', '#ffffff');
    $link_color = get_theme_mod('clp_profile_link_color', '#0073aa');
    $link_hover_color = get_theme_mod('clp_profile_link_hover_color', '#005f85');
    $link_hover_bg = get_theme_mod('clp_profile_link_bg_hover_color', '#f1f1f1');

    ?>
    <style type="text/css">
        .clp-topbar-profile {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            background-color: <?= esc_attr($bg_color); ?>;
            padding: <?= intval($padding); ?>px 20px;
            height: <?= intval($height); ?>px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
            border-bottom: 1px solid #eee;
            font-size: 16px;
            font-family: 'Vazirmatn', sans-serif;
            direction: rtl;
            transition: all 0.2s ease;
        }

        .clp-topbar-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: <?= intval($height - 10); ?>px;
        }

        .clp-user-name {
            font-size: 15px;
            color: <?= esc_attr($link_color); ?>;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: default;
        }

        .clp-profile-dropdown {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 20px;
        }

        .clp-profile-dropdown li {
            display: inline-block;
        }

        .clp-profile-dropdown a {
            text-decoration: none;
            color: <?= esc_attr($link_color); ?>;
            padding: 5px 10px;
            border-radius: 4px;
            transition: all 0.2s ease;
        }

        .clp-profile-dropdown a:hover,
        .clp-profile-dropdown li:hover a {
            color: <?= esc_attr($link_hover_color); ?>;
            background-color: <?= esc_attr($link_hover_bg); ?>;
        }
    </style>
    <?php
}

// اعمال margin-top فقط برای کاربران غیر از مدیر و لاگین‌کرده
add_action('wp_head', 'clp_add_global_styles');
function clp_add_global_styles() {
    if (!get_option('clp_enable_topbar_profile', 0)) return;
    if (!is_user_logged_in()) return;

    $user = wp_get_current_user();
    if (in_array('administrator', $user->roles)) return;

    $margin = get_theme_mod('clp_topbar_body_margin', 50);

    if ($margin < 0 || $margin > 200) {
        $margin = 50; // Default
    }
    ?>
    <style type="text/css">
        body {
            margin-top: <?= intval($margin); ?>px !important;
        }

        /* اضافه کردن padding به header یا main content */
        .site-header,
        .main-navigation,
        header[role="banner"],
        .entry-header,
        .entry-content,
        .wrap,
        .content-area,
        .site-main {
            padding-top: <?= intval($margin); ?>px !important;
            margin-top: 0 !important;
        }
    </style>
    <?php
}