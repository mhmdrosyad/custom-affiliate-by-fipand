<?php
/*
Plugin Name: Custom Affiliate Plugin with MemberPress Integration by Fipand
Description: Plugin untuk mengatur komisi afiliasi berdasarkan membership dari MemberPress dengan tabel terpisah.
Version: 1.0.0
Author: Fipand
GitHub Plugin URI: https://github.com/username/repository-name
*/

define('CAP_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('CAP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Memuat file lain dalam plugin
require_once CAP_PLUGIN_PATH . 'includes/db-setup.php';
require_once CAP_PLUGIN_PATH . 'includes/admin-page.php';
require_once CAP_PLUGIN_PATH . 'includes/helpers.php';
require_once CAP_PLUGIN_PATH . 'includes/triggers.php';

// Hook aktivasi dan uninstall untuk membuat dan menghapus tabel
register_activation_hook(__FILE__, 'custom_affiliate_create_tables');
register_uninstall_hook(__FILE__, 'custom_affiliate_delete_tables');
register_deactivation_hook(__FILE__, 'custom_affiliate_delete_tables');

// Menambahkan halaman pengaturan ke menu admin
add_action('admin_menu', 'custom_affiliate_add_admin_menu');

// Enqueue JavaScript untuk halaman admin
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook != 'toplevel_page_custom_affiliate_settings') return;
    wp_enqueue_script('custom-affiliate-admin-js', CAP_PLUGIN_URL . 'assets/js/admin.js', ['jquery'], '1.0', true);
});
