<?php

// REST API endpoint برای لاگین
add_action('rest_api_init', function () {
    register_rest_route('custom-login-page/v1', '/login', [
        'methods' => 'POST',
        'callback' => 'clp_rest_login_handler',
        'permission_callback' => '__return_true'
    ]);
});

function clp_rest_login_handler($request) {
    $params = $request->get_params();

    $creds = [
        'user_login' => sanitize_user($params['log']),
        'user_password' => $params['pwd'],
        'remember' => isset($params['rememberme'])
    ];

    $user = wp_signon($creds, false);

    if (is_wp_error($user)) {
        return new WP_REST_Response([
            'success' => false,
            'message' => $user->get_error_message()
        ], 400);
    }

    return new WP_REST_Response([
        'success' => true,
        'redirect' => home_url()
    ], 200);
}