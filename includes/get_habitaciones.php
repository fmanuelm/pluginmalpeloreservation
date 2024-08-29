<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('../../../../wp-load.php');

function get_habitaciones() {
	
		global $wpdb;
		$id = $_POST['id'];
		$table_name1 = $wpdb->prefix . 'mapelo_reservation';
    	$table_name3 = $wpdb->prefix . 'mapelo_reservation_bedrooms';
		
		
    	$wpdb->delete($table_name1, ['id'=>$id]);
		$wpdb->delete($table_name2, ['id_reservation'=>$id]);
		$wpdb->delete($table_name3, ['id_reservation'=>$id]);
		/*
		wp_redirect( admin_url( "admin.php?page=form-mapelo-reservation&id=$id" ) ); 
	  	exit;
	  	*/
	
}