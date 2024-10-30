<?php
function custom_affiliate_add_admin_menu()
{
    add_menu_page(
        'Affiliate Settings',
        'Affiliate Settings',
        'manage_options',
        'custom_affiliate_settings',
        'custom_affiliate_settings_page'
    );
}

function custom_affiliate_settings_page()
{
    global $wpdb;
    $commission_rules_table = $wpdb->prefix . 'fipand_commission_rules';

    // Load semua jenis membership dari MemberPress
    if (class_exists('MeprProduct')) {
        $memberships = MeprProduct::all();
    } else {
        $memberships = [];
    }

    // Simpan aturan komisi ke tabel database
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['commission_rules'])) {
        $wpdb->query("TRUNCATE TABLE $commission_rules_table");

        foreach ($_POST['commission_rules'] as $rule) {
            $wpdb->insert($commission_rules_table, [
                'membership_id' => intval($rule['membership_id']),
                'rate' => floatval($rule['rate'])
            ]);
        }
    }

    // Ambil aturan komisi yang tersimpan
    $commission_rules = $wpdb->get_results("SELECT * FROM $commission_rules_table", ARRAY_A);
    include CAP_PLUGIN_PATH . 'templates/admin-page-template.php';
}
