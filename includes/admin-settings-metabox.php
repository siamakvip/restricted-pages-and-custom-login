<?php

// اضافه کردن متا باکس
add_action('add_meta_boxes', 'clp_add_login_required_metabox');
function clp_add_login_required_metabox() {
    add_meta_box(
        'clp-login-required',
        __('نیاز به لاگین', 'custom-login-page'),
        'clp_render_login_required_metabox',
        ['page', 'post'],
        'side',
        'default'
    );
}

function clp_render_login_required_metabox($post) {
    wp_nonce_field('clp_save_login_required', 'clp_login_required_nonce');

    $login_required = get_post_meta($post->ID, '_clp_login_required', true);
    ?>
    <label>
        <input type="checkbox" name="clp_login_required" value="1" <?php checked(1, $login_required); ?> />
        <?php _e('این صفحه/پست نیاز به لاگین دارد.', 'custom-login-page'); ?>
    </label>
    <?php
}

add_action('save_post', 'clp_save_login_required_metabox');
function clp_save_login_required_metabox($post_id) {
    if (!isset($_POST['clp_login_required_nonce'])) return;
    if (!wp_verify_nonce($_POST['clp_login_required_nonce'], 'clp_save_login_required')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    $login_required = isset($_POST['clp_login_required']) ? 1 : 0;
    update_post_meta($post_id, '_clp_login_required', $login_required);
}