<?php
global $wpdb;

function custom_affiliate_create_tables()
{
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();

    // Tabel untuk data afiliasi
    $affiliate_data_table = $wpdb->prefix . 'affiliate_data';
    $sql1 = "CREATE TABLE $affiliate_data_table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        user_id BIGINT UNSIGNED NOT NULL,
        total_pendapatan DECIMAL(10, 2) NOT NULL DEFAULT 0,
        saldo DECIMAL(10, 2) NOT NULL DEFAULT 0,
        membership_id BIGINT UNSIGNED NOT NULL,   /* Referensi ke jenis membership */
        PRIMARY KEY (id)
    ) $charset_collate;";

    // Tabel untuk aturan komisi berdasarkan jenis membership
    $commission_rules_table = $wpdb->prefix . 'commission_rules';
    $sql2 = "CREATE TABLE $commission_rules_table (
        id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        membership_id BIGINT UNSIGNED NOT NULL,
        rate DECIMAL(5, 2) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql1);
    dbDelta($sql2);
}

function custom_affiliate_delete_tables()
{
    global $wpdb;
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}affiliate_data");
    $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}commission_rules");
}
