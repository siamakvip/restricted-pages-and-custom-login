<?php

add_action('customize_register', 'clp_customize_profile_form');
function clp_customize_profile_form($wp_customize) {
    // === Section: فرم پروفایل ===
    $wp_customize->add_section('clp_profile_styling_section', [
        'title' => __('فرم پروفایل کاربری', 'restricted-pages-and-custom-login'),
        'priority' => 150,
    ]);

    // --- رنگ پس‌زمینه فرم ---
    $wp_customize->add_setting('clp_profile_form_bg_color', [
        'default' => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_form_bg_color', [
        'label' => __('رنگ پس‌زمینه فرم پروفایل', 'restricted-pages-and-custom-login'),
        'section' => 'clp_profile_styling_section',
    ]));

    // --- رنگ متن فرم ---
    $wp_customize->add_setting('clp_profile_form_text_color', [
        'default' => '#333333',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_form_text_color', [
        'label' => __('رنگ متن فرم پروفایل', 'restricted-pages-and-custom-login'),
        'section' => 'clp_profile_styling_section',
    ]));

    // --- رنگ لینک/دکمه‌ها ---
    $wp_customize->add_setting('clp_profile_form_link_color', [
        'default' => '#0073aa',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_form_link_color', [
        'label' => __('رنگ لینک‌ها و دکمه‌ها', 'restricted-pages-and-custom-login'),
        'section' => 'clp_profile_styling_section',
    ]));

    // --- رنگ hover لینک/دکمه‌ها ---
    $wp_customize->add_setting('clp_profile_form_link_hover_color', [
        'default' => '#005f85',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_form_link_hover_color', [
        'label' => __('رنگ Hover لینک/دکمه', 'restricted-pages-and-custom-login'),
        'section' => 'clp_profile_styling_section',
    ]));

    // --- رنگ بوردر فیلد ورودی ---
    $wp_customize->add_setting('clp_profile_form_input_border_color', [
        'default' => '#ddd',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'clp_profile_form_input_border_color', [
        'label' => __('رنگ بوردر فیلدها', 'restricted-pages-and-custom-login'),
        'section' => 'clp_profile_styling_section',
    ]));
}