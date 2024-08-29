<?php

function mapelo_reservation_uninstall() {
    global $wpdb;

    $table_name1 = $wpdb->prefix . 'mapelo_reservation';
	$table_name2 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
	$table_name3 = $wpdb->prefix . 'mapelo_reservation_email';
	$table_name4 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
	$table_name5 = $wpdb->prefix . 'mapelo_reservation_destpage';
    
    $wpdb->query( "DROP TABLE IF EXISTS $table_name2" );
    $wpdb->query( "DROP TABLE IF EXISTS $table_name3" );
    $wpdb->query( "DROP TABLE IF EXISTS $table_name4" );
    $wpdb->query( "DROP TABLE IF EXISTS $table_name5" );
    $wpdb->query( "DROP TABLE IF EXISTS $table_name1" );
}