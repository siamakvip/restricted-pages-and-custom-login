<?php
use PHPUnit\Framework\TestCase;

class SampleTest extends \WP_UnitTestCase {
    public function test_plugin_defined() {
        $this->assertTrue(defined('CLP_PLUGIN_DIR'));
    }

    public function test_login_page_redirect_url() {
        $login_url = apply_filters('login_url', 'http://example.com/wp-login.php');
        $this->assertStringContainsString('your-custom-page-slug', $login_url);
    }
}