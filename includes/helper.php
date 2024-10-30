<?php

/**
 * Helper untuk plugin Custom Affiliate Plugin.
 */

// Fungsi untuk mendapatkan aturan komisi berdasarkan user ID dan membership
function cap_get_commission_rate_by_user($user_id)
{
    global $wpdb;
    $affiliate_data_table = $wpdb->prefix . 'affiliate_data';
    $commission_rules_table = $wpdb->prefix . 'commission_rules';

    $rate = $wpdb->get_var($wpdb->prepare(
        "SELECT cr.rate
         FROM $affiliate_data_table ad
         JOIN $commission_rules_table cr ON ad.membership_id = cr.membership_id
         WHERE ad.user_id = %d",
        $user_id
    ));

    return $rate;
}

add_shortcode('commission_rate', 'cap_commission_rate_shortcode');

function cap_commission_rate_shortcode($atts)
{
    // Ambil user ID dari atribut shortcode atau gunakan ID pengguna yang sedang login
    $atts = shortcode_atts(array(
        'user_id' => get_current_user_id(), // Default ke ID pengguna yang sedang login
    ), $atts);

    $user_id = intval($atts['user_id']);
    $rate = cap_get_commission_rate_by_user($user_id);

    // Jika rate tidak ditemukan, tampilkan pesan default
    if ($rate === null) {
        return "0";
    }

    return esc_html($rate) . "%"; // Tampilkan rate komisi
}

// Fungsi untuk memperbarui total pendapatan dan saldo
function cap_update_affiliate_data($user_id, $amount, $commission_rate)
{
    global $wpdb;
    $affiliate_data_table = $wpdb->prefix . 'affiliate_data';

    // Hitung komisi
    $commission = $amount * ($commission_rate / 100);

    // Periksa apakah pengguna sudah ada di tabel afiliasi
    $existing_entry = $wpdb->get_row(
        $wpdb->prepare("SELECT * FROM $affiliate_data_table WHERE user_id = %d", $user_id)
    );

    // Jika ada, update data. Jika tidak, insert data baru.
    if ($existing_entry) {
        $wpdb->update(
            $affiliate_data_table,
            [
                'total_pendapatan' => $existing_entry->total_pendapatan + $amount,
                'saldo' => $existing_entry->saldo + $commission,
                'komisi' => $commission_rate
            ],
            ['user_id' => $user_id]
        );
    } else {
        $wpdb->insert(
            $affiliate_data_table,
            [
                'user_id' => $user_id,
                'total_pendapatan' => $amount,
                'saldo' => $commission,
                'komisi' => $commission_rate
            ]
        );
    }
}

// Fungsi untuk memformat data komisi untuk tampilan di admin
function cap_format_currency($amount)
{
    return number_format($amount, 2, ',', '.');
}
