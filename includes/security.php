<?php

// اضافه کردن Meta Box برای محدود کردن صفحه/پست
add_action('add_meta_boxes', 'clp_add_restricted_meta_box');
function clp_add_restricted_meta_box() {
    $screens = ['page', 'post'];
    foreach ($screens as $screen) {
        add_meta_box(
            'clp_restricted_section',
            __('دسترسی محدود', 'restricted-pages-and-custom-login'),
            'clp_render_restricted_meta_box',
            $screen,
            'side',
            'default'
        );
    }
}

// نمایش چک‌باکس
function clp_render_restricted_meta_box($post) {
    wp_nonce_field('clp_save_restricted_meta', 'clp_restricted_nonce');

    $is_restricted = get_post_meta($post->ID, '_clp_login_required', true);
    ?>
    <label for="clp_login_required">
        <input type="checkbox" name="clp_login_required" id="clp_login_required" value="1" <?= checked(1, $is_restricted, false); ?> />
        <?php _e('این مطلب نیازمند ورود کاربر است.', 'restricted-pages-and-custom-login'); ?>
    </label>
    <?php
}

// ذخیره وضعیت restricted
add_action('save_post', 'clp_save_restricted_meta');
function clp_save_restricted_meta($post_id) {
    if (!isset($_POST['clp_restricted_nonce'])) return;
    if (!wp_verify_nonce($_POST['clp_restricted_nonce'], 'clp_save_restricted_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (array_key_exists('clp_login_required', $_POST)) {
        update_post_meta($post_id, '_clp_login_required', 1);
    } else {
        delete_post_meta($post_id, '_clp_login_required');
    }
}