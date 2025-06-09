<?php

add_action('customize_register', 'clp_customize_register');
function clp_customize_register($wp_customize) {
    // === Section: نوار بالایی ===
    $wp_customize->add_section('clp_topbar_section', [
        'title' => __('نوار بالایی پروفایل', 'restricted-pages-and-custom-login'),
        'priority' => 160,
    ]);

    // --- ارتفاع ---
    $wp_customize->add_setting('clp_topbar_height', [
        'default' => '40',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('clp_topbar_height', [
        'label' => __('ارتفاع نوار بالایی (px)', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
        'type' => 'number',
        'input_attrs' => ['min' => 30, 'max' => 100, 'step' => 1],
    ]);

    // --- پدینگ ---
    $wp_customize->add_setting('clp_topbar_padding', [
        'default' => '10',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('clp_topbar_padding', [
        'label' => __('پدینگ نوار بالایی (px)', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
        'type' => 'number',
        'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 1],
    ]);

    // --- رنگ پس‌زمینه ---
    $wp_customize->add_setting('clp_topbar_bg_color', [
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_topbar_bg_color', [
        'label' => __('رنگ پس‌زمینه نوار بالایی', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
    ]));

    // --- رنگ لینک/منو ---
    $wp_customize->add_setting('clp_profile_link_color', [
        'default' => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_link_color', [
        'label' => __('رنگ لینک‌ها (پروفایل/خروج)', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
    ]));

    // --- رنگ hover لینک ---
    $wp_customize->add_setting('clp_profile_link_hover_color', [
        'default' => '#005f85',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_link_hover_color', [
        'label' => __('رنگ لینک‌ها در حالت Hover', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
    ]));

    // --- رنگ hover باکس ---
    $wp_customize->add_setting('clp_profile_link_bg_hover_color', [
        'default' => '#f1f1f1',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_link_bg_hover_color', [
        'label' => __('رنگ بک گراند دکمه‌ها در حالت هاور', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
    ]));

    // --- مارجین بدی ---
    $wp_customize->add_setting('clp_topbar_body_margin', [
        'default' => '50',
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('clp_topbar_body_margin', [
        'label' => __('فاصله صفحه از بالا (margin-top بدی)', 'restricted-pages-and-custom-login'),
        'section' => 'clp_topbar_section',
        'type' => 'number',
        'input_attrs' => ['min' => 0, 'max' => 200, 'step' => 1],
    ]);
}