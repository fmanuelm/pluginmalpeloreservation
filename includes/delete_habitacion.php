<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function delete_habitacion() {
	
		global $wpdb;
		$id = $_POST['id'];
		$table_name1 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
    	$table_name3 = $wpdb->prefix . 'mapelo_reservation_bedrooms_books';
		
		$wpdb->delete($table_name3, ['bedroom_id'=>$id]);
    	$wpdb->delete($table_name1, ['id'=>$id]);
		
		
		wp_redirect( admin_url( "admin.php?page=habitaciones&id=$id" ) ); 
	  	exit;
	  	
	
}