<?php

// Trigger saat transaksi MemberPress selesai
add_action('mepr-event-transaction-completed', 'cap_add_user_to_affiliate_data_after_payment');

function cap_add_user_to_affiliate_data_after_payment($event)
{
    global $wpdb;

    // Ambil data transaksi
    $transaction = $event->get_data();

    // Ambil user ID dan membership ID dari transaksi
    $user_id = $transaction->user_id; // ID pengguna
    $membership_id = $transaction->product_id; // ID membership

    // Nama tabel
    $affiliate_data_table = $wpdb->prefix . 'affiliate_data';

    // Tambahkan data ke tabel affiliate_data
    $wpdb->insert(
        $affiliate_data_table,
        [
            'user_id' => $user_id,
            'total_pendapatan' => 0, // Awal
            'saldo' => 0,            // Awal
            'membership_id' => $membership_id // Simpan membership ID untuk relasi
        ]
    );
}
