<?php

//require_once( $_SERVER['DOCUMENT_ROOT'] . '/fernando' . '/wp-load.php' );
//require_once('/../wp-load.php');

function process_destpage() {
	if (isset($_POST['submit'])) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'mapelo_reservation_destpage';
		
		$slug = $_POST['slug'];
		$wpdb->query( $wpdb->prepare( 
		    "
		    UPDATE $table_name
		    SET slug=%s
		    WHERE ID = 1
		    ", 
		    $slug
		) );

		wp_redirect( admin_url( 'admin.php?page=dest-page' ) ); // Redirige a la subpágina después de guardar los datos
	  	exit;
	}
}