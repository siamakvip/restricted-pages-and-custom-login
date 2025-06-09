<?php

// اضافه کردن /logout/
add_action('init', 'clp_add_logout_endpoint');
function clp_add_logout_endpoint() {
    add_rewrite_rule('^logout/?$', 'index.php?clp_logout=true', 'top');
}

// query_var برای clp_logout
add_filter('query_vars', 'clp_add_logout_queryvar');
function clp_add_logout_queryvar($vars) {
    $vars[] = 'clp_logout';
    return $vars;
}

// ریدایرکت بعد از لاگ‌اوت
add_action('template_redirect', 'clp_handle_logout_request');
function clp_handle_logout_request() {
    if (get_query_var('clp_logout')) {
        wp_logout();

        $redirect_to = get_permalink(get_option('clp_logout_page_id'));

        if (!$redirect_to) {
            $redirect_to = home_url('/');
        }

        wp_safe_redirect($redirect_to);
        exit;
    }
}