<?php
/*
Plugin Name: Restricted Pages and Custom Login
Plugin URI:  https://sepandar.ir 
Description: این پلاگین به شما اجازه می‌ده یک صفحه دلخواه وردپرسی رو به عنوان صفحه لاگین پیش‌فرض تعیین کنید و صفحات خصوصی را مدیریت کنید.
Version:     3.1
Author:      Siamak
Author URI:  https://sepandar.ir 
Text Domain: restricted-pages-and-custom-login
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Direct access forbidden
}

define('CLP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CLP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Load Textdomain for translations
load_plugin_textdomain('restricted-pages-and-custom-login', false, dirname(plugin_basename(__FILE__)) . '/languages');

// Includes
require_once CLP_PLUGIN_DIR . 'includes/admin-settings.php';
require_once CLP_PLUGIN_DIR . 'profiles/profile-handler.php';
require_once CLP_PLUGIN_DIR . 'includes/customizer.php';        
require_once CLP_PLUGIN_DIR . 'includes/login-redirects.php';
require_once CLP_PLUGIN_DIR . 'includes/logout-handler.php';
require_once CLP_PLUGIN_DIR . 'includes/profile-menu.php';
require_once CLP_PLUGIN_DIR . 'includes/custom-login-form.php';
require_once CLP_PLUGIN_DIR . 'includes/security.php';
require_once CLP_PLUGIN_DIR . 'includes/rest-api.php';

// Enqueue styles
add_action('wp_enqueue_scripts', 'clp_enqueue_styles');
function clp_enqueue_styles() {
    if (is_page(get_option('clp_login_page_id'))) {
        wp_enqueue_style('clp-custom-style', CLP_PLUGIN_URL . 'assets/css/clp-style.css', [], filemtime(CLP_PLUGIN_DIR . 'assets/css/clp-style.css'));
        wp_enqueue_style('vazirmatn-font', 'https://fonts.googleapis.com/css2?family=Vazirmatn&display=swap');
    }

    // منوی بالایی
    if (get_option('clp_enable_topbar_profile', 0)) {
        $css_file = CLP_PLUGIN_DIR . 'assets/css/clp-profile.css';
        $version = file_exists($css_file) ? filemtime($css_file) : false;
        wp_enqueue_style('clp-topbar-profile-style', CLP_PLUGIN_URL . 'assets/css/clp-profile.css', [], $version);
    }

    // استایل فرم پروفایل
    if (is_page(get_option('clp_profile_page_id')) && get_option('clp_enable_user_profile', 0)) {
        $css_file = CLP_PLUGIN_DIR . 'assets/css/clp-profile-form.css';
        $version = file_exists($css_file) ? filemtime($css_file) : false;
        wp_enqueue_style('clp-profile-form-style', CLP_PLUGIN_URL . 'assets/css/clp-profile-form.css', [], $version);
    }
}

// Gutenberg Block (اختیاری)
add_action('enqueue_block_editor_assets', 'clp_enqueue_block_editor_assets');
function clp_enqueue_block_editor_assets() {
    $asset_file = include plugin_dir_path(__FILE__) . 'block.build.js.asset.php';

    wp_enqueue_script(
        'custom-login-page-block',
        plugins_url('block.build.js', __FILE__),
        $asset_file['dependencies'],
        $asset_file['version']
    );

    wp_enqueue_style(
        'custom-login-page-block-editor',
        plugins_url('block.editor.css', __FILE__),
        [],
        filemtime(plugin_dir_path(__FILE__) . 'block.editor.css')
    );
}

// REST API Meta Fields
add_action('rest_api_init', function () {
    register_rest_field(['page', 'post'], '_clp_login_required', [
        'get_callback' => function ($post) {
            return get_post_meta($post['id'], '_clp_login_required', true);
        },
        'update_callback' => function ($value, $post) {
            update_post_meta($post->ID, '_clp_login_required', $value);
        },
        'schema' => null,
    ]);
});

// === ثبت Hook برای زمان فعال‌سازی ===
register_activation_hook(__FILE__, 'clp_on_activate');
function clp_on_activate() {
    // اگر گزینه "کاربر ویژه" فعال باشه، نقش special_user رو ایجاد کن
    if (get_option('clp_enable_special_user_role', 0) && !get_role('special_user')) {
        add_role('special_user', __('کاربر ویژه', 'restricted-pages-and-custom-login'), [
            'read' => true,
            'edit_posts' => false,
            'delete_posts' => false,
            'upload_files' => false,
        ]);
    }
}

// === ثبت Hook برای زمان غیرفعال‌سازی ===
register_deactivation_hook(__FILE__, 'clp_on_deactivate');
function clp_on_deactivate() {
    // فقط تنظیمات باقی بمونه – مثل ووکامرس
}

// === ثبت Hook برای زمان حذف کامل ===
register_uninstall_hook(__FILE__, 'clp_on_uninstall');
function clp_on_uninstall() {
    // فقط اگر مدیر دکمه «حذف نقش» رو زده باشد، آنوقت حذف بشه
}