<?php

// ریدایرکت URL لاگین
add_filter('login_url', 'clp_custom_login_url', 10, 2);
function clp_custom_login_url($login_url, $redirect) {
    $page_id = get_option('clp_login_page_id');

    if ($page_id) {
        $custom_login_url = get_permalink($page_id);

        if ($redirect) {
            $parsed_url = parse_url($redirect);
            $redirect_path = isset($parsed_url['path']) ? $parsed_url['path'] : $redirect;

            $custom_login_url = add_query_arg('redirect_to', urlencode($redirect_path), $custom_login_url);
        }

        return $custom_login_url;
    }

    return $login_url;
}

// ریدایرکت وقتی کاربر به صفحه Restricted دسترسی داره
add_action('template_redirect', 'clp_handle_login_required_pages');
function clp_handle_login_required_pages() {
    if (!get_option('clp_enable_protection', 0)) return;

    if (is_user_logged_in()) {
        $user = wp_get_current_user();

        // اگر مدیر یا کاربر ویژه یا مشترک بود، دسترسی بده
        if (
            in_array('administrator', $user->roles) ||
            in_array('special_user', $user->roles) ||
            in_array('subscriber', $user->roles)
        ) {
            return;
        }

        wp_safe_redirect(clp_get_login_page_url());
        exit;
    }

    global $post;

    if (!is_singular(['page', 'post'])) return;

    $login_required = get_post_meta($post->ID, '_clp_login_required', true);

    if ($login_required) {
        wp_safe_redirect(clp_get_login_page_url() . '?redirect_to=' . urlencode(get_permalink()));
        exit;
    }
}

// گرفتن URL صفحه لاگین
function clp_get_login_page_url() {
    $page_id = get_option('clp_login_page_id');
    return $page_id ? get_permalink($page_id) : wp_login_url();
}